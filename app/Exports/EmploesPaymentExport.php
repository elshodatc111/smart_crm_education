<?php

namespace App\Exports;

use App\Models\EmplesPayment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmploesPaymentExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize {

    public function collection(){
        return EmplesPayment::all();
    }
    
    public function headings(): array{
        return [
            'ID',
            'UserID',
            'User',
            'GuruhID',
            'Guruh',
            'To\'lov',
            'To\'lov turi',
            'To\'lov haqida',
            'Direktor',
            'To\'lov vaqt',
        ];
    }

    public function map($emploes_payment): array{
        return [
            $emploes_payment->id,
            $emploes_payment->user_id,
            $emploes_payment->user->name,
            $emploes_payment->group_id,
            $emploes_payment->group_id?$emploes_payment->group->group_name:"",
            number_format($emploes_payment->amount, 0, '.', ' ') . ' UZS',
            $emploes_payment->payment_type=='card'?"Karta":"Naqt",
            $emploes_payment->description,
            $emploes_payment->admin->name,
            $emploes_payment->created_at->format("Y-m-d h:i"),
        ];
    }
}
