<?php

namespace App\Exports;

use App\Models\ChegirmaHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserChegirmaHistoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{
    
    public function collection(){
        return ChegirmaHistory::all();
    }

    public function headings(): array{
        return [
            'ID',
            'UserID',
            'User',
            'GuruhID',
            'Guruh',
            'Chegirma yakunlanishi',
            'Chegirma uchun to\'lov',
            'Chegirma summasi',
            'Chegirma holati',
            'Chegirma yaratildi',
        ];
    }

    public function map($user_chegirma): array{
        return [
            $user_chegirma->id,
            $user_chegirma->user_id,
            $user_chegirma->user->name,
            $user_chegirma->group_id,
            $user_chegirma->group_id?$user_chegirma->group->group_name:"",
            $user_chegirma->end_data->format("Y-m-d"),
            number_format($user_chegirma->amount, 0, '.', ' ') . ' UZS',
            number_format($user_chegirma->discount, 0, '.', ' ') . ' UZS',
            $user_chegirma->status,
            $user_chegirma->created_at->format('Y-m-d H:i'),
        ];
    }
    
}
