<?php

namespace App\Exports;

use App\Models\GroupData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AllGroupsDataExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{
    
    public function collection(){
        return GroupData::all();
    }

    public function headings(): array{
        return [
            'ID',
            'GuruhID',
            'Data',
        ];
    }

    public function map($group_data): array{
        return [
            $group_data->id,
            $group_data->group_id,
            $group_data->data->format("Y-m-d"),
        ];
    }

}
