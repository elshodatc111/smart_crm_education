<?php

namespace App\Exports;

use App\Models\UserHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserHistoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return UserHistory::all();
    }

        public function headings(): array{
        return [
            'ID',
            'UserID',
            'User',
            'Type',
            'Izoh',
            'Meneger',
            'Vaqti',
        ];
    }

    public function map($user_history): array{
        return [
            $user_history->id,
            $user_history->user_id,
            $user_history->user->name,
            $user_history->type,
            $user_history->description,
            $user_history->creator->name ?? 'Tizim',
            $user_history->created_at->format('Y-m-d H:i'),
        ];
    }
    
}
