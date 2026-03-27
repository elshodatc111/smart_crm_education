<?php

namespace App\Jobs;

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

    public int $tries = 3;
    
    public int $backoff = 60;

    public function __construct(protected string $phone,protected string $message) {}

    public function handle(EskizService $eskiz): void{
        $result = $eskiz->sendSms($this->phone, $this->message);
        if (isset($result['status']) && $result['status'] === 'waiting') {
            SmsLog::create([
                'phone'   => $this->phone,
                'message' => $this->message,
                'sms_id'  => $result['id'] ?? null,
                'status'  => $result['status'],
            ]);
        }else{
            Log::error("SMS yuborishda xatolik (Job): " . json_encode($result));
            SmsLog::create([
                'phone'   => $this->phone,
                'message' => $this->message,
                'status'  => 'failed',
            ]);
        }
    }

}
