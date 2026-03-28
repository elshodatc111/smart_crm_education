<?php

namespace App\Jobs;

use App\Models\SettingSms;
use App\Models\SmsLog;
use App\Services\EskizService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $smsTemplates = [
        'verify'           => "ATKO o‘quv markazi ilovasiga kirish uchun tasdiqlash kodi: {CODE}. Kodni hech kimga bermang.",
        'register'         => "Hurmatli {NAME}, ATKO o‘quv markazida ro‘yxatdan o‘tdingiz. Ilovaga kirish: telefon +{PHONE}, parol: password.",
        'employee_payment' => "Hurmatli {NAME}, sizga {SUM} so‘m ish haqi to‘landi. ATKO o‘quv markazi.",
        'user_payment'     => "Hurmatli {NAME}, sizning {SUM} so‘m to‘lovingiz qabul qilindi. ATKO o‘quv markazi.",
        'discount'         => "Hurmatli {NAME}, sizga {SUM} so‘m chegirma taqdim etildi. ATKO o‘quv markazi.",
        'refund'           => "Hurmatli {NAME}, sizning {SUM} so‘m to‘lovingiz qaytarildi. ATKO o‘quv markazi.",
        'password'         => "Hurmatli {NAME}, ATKO o‘quv markazi ilovasiga kirish uchun parolingiz: password.",
        'birthday'         => "Hurmatli {NAME}, sizni tug‘ilgan kuningiz bilan ATKO o‘quv markazi jamoasi tabriklaydi!",
        'debt'             => "Hurmatli {NAME}, sizda ATKO o‘quv markazida {SUM} so‘m qarzdorlik mavjud. Iltimos, to‘lovni amalga oshiring."
    ];
    public int $tries = 3;
    public int $backoff = 60;
    public function __construct(
        protected string $phone,
        protected string $name,
        protected string $sum,
        protected string $code,
        protected string $type,
    ) {}
    public function handle(EskizService $eskiz): void{
        $settingSMS = SettingSms::first();
        if (!$settingSMS) return;
        $isAllowed = match ($this->type) {
            'verify', 'register' => $settingSMS->visit_sms,
            'employee_payment', 'user_payment', 'discount', 'refund', 'debt' => $settingSMS->payment_sms,
            'password' => $settingSMS->password_sms,
            'birthday' => $settingSMS->birthday_sms,
            default => false,
        };
        if (!$isAllowed) return;
        $template = $this->smsTemplates[$this->type] ?? "";
        $message = str_replace(
            ['{NAME}', '{CODE}', '{SUM}', '{PHONE}'],
            [$this->name, $this->code, $this->sum, $this->phone],
            $template
        );
        if (empty($message)) return;
        $result = $eskiz->sendSms($this->phone, $message);
        $isWaiting = isset($result['status']) && $result['status'] === 'waiting';
        SmsLog::create([
            'phone'   => $this->phone,
            'message' => $message,
            'sms_id'  => $result['id'] ?? null,
            'status'  => $isWaiting ? 'waiting' : 'failed',
        ]);
        if (!$isWaiting) {
            Log::error("SMS yuborishda xatolik: " . json_encode($result));
        }
    }
}
