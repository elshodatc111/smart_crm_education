<?php

namespace App\Exports;

use App\Models\UserPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserPaymenmtExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return UserPayment::all();
    }

    public function headings(): array{
        return [
            'ID',
            'UserID',
            'User',
            'GuruhID',
            'Guruh',
            'PaymentType',
            'To\'lov summasi',
            'Chegirma Summasi',
            'To\'lov turi',
            'Izoh',
            'Qabul qildi',
            'Qabul qilindi',
        ];
    }

    public function map($user_history): array{
        return [
            $user_history->id,
            $user_history->user_id,
            $user_history->user->name,
            $user_history->group_id,
            $user_history->group_id?$user_history->group->group_name:"",
            $this->TypeING($user_history->type, number_format($user_history->amount, 0, '.', ' ')),
            number_format($user_history->amount, 0, '.', ' ') . ' UZS',
            number_format($user_history->discount, 0, '.', ' ') . ' UZS',
            $user_history->payment_type=='cash'?"Naqt":"Karta",
            $user_history->description,
            $user_history->admin->name ?? 'Tizim',
            $user_history->created_at->format('Y-m-d H:i'),
        ];
    }
    
    private function TypeING($type,$amount){
        if($type=='return'){
            return "Qaytarildi";
        }elseif($amount==0){
            return "Chegirma";
        }else{
            return "To'lov";
        }
    }
}
