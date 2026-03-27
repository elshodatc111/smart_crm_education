<?php

namespace App\Exports;

use App\Models\KassaHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KassaHistoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return KassaHistory::all();
    }
    
    public function headings(): array{
        return [
            'ID',
            'Summa',
            'Type',
            'Description',
            'Meneger',
            'Status',
            'Direktor',
            'Time',
        ];
    }

    public function map($kassa_history): array{
        return [
            $kassa_history->id,
            number_format($kassa_history->amount, 0, '.', ' ') . ' UZS',
            $kassa_history->type,
            $kassa_history->description,
            $kassa_history->meneger->name,
            $kassa_history->status,
            $kassa_history->admin->name,
            $kassa_history->created_at->format('Y-m-d H:i'),
        ];
    }
    
}
