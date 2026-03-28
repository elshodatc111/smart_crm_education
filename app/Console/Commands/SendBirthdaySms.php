<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendSmsJob;
use App\Models\User;
use Carbon\Carbon;

class SendBirthdaySms extends Command{

    protected $signature = 'sms:send-birthday';

    protected $description = 'Bugun tug‘ilgan kuni bo‘lgan foydalanuvchilarga SMS yuborish';

    public function handle(){
        $today = Carbon::today();
        User::whereMonth('birth_date', $today->month)
            ->whereDay('birth_date', $today->day)
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    SendSmsJob::dispatch(
                        str_replace('+', '', $user->phone),
                        $user->name,
                        '', // Summa shart emas
                        '', // Kod shart emas
                        'birthday'
                    );
                }
            });
        $this->info('Tug‘ilgan kun SMSlari navbatga qo‘shildi.');
    }
}
