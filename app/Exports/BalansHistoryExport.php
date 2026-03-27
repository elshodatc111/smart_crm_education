<?php

namespace App\Exports;

use App\Models\BalansHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BalansHistoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{
    
    public function collection(){
        return BalansHistory::all();
    }

    public function headings(): array{
        return [
            'ID',
            'Type',
            'Summa',
            'Description',
            'Meneger',
            'Drektor',
            'Time',
        ];
    }

    public function map($balans_history): array{
        return [
            $balans_history->id,
            $balans_history->type,
            number_format($balans_history->amount, 0, '.', ' ') . ' UZS',
            $balans_history->description,
            $balans_history->user->name,
            $balans_history->admin->name,
            $balans_history->created_at->format('Y-m-d H:i'),
        ];
    }
    
}
