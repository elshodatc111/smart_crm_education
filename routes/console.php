<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

// * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
// Serverda Cron Jobni sozlash
/*
Sizning Laravel buyruqlaringiz avtomatik ishlashi uchun serveringiz (Ubuntu/CPanel) 
da bitta asosiy Cron entry bo'lishi shart. 
Terminalda crontab -e buyrug'ini bering va pastiga ushbu qatorni qo'shing:
*/
Schedule::command('sms:send-birthday')->dailyAt('09:00');
// (Eslatma: /path-to-your-project o'rniga loyihangiz joylashgan haqiqiy yo'lni yozing)
// Test qilish: Hammasi to'g'ri ishlayotganini tekshirish uchun terminalda qo'lda quyidagicha ishga tushirib ko'rishingiz mumkin:
// php artisan sms:send-birthday
