<?php

namespace App\Exports;

use App\Models\UserDavomad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserDavomadExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{
    
    public function collection(){
        return UserDavomad::all();
    }
        public function headings(): array{
        return [
            'ID',
            'UserID',
            'User',
            'GuruhID',
            'Guruh',
            'Davomad sanasi',
            'Davomad holati',
            'Davomad oldi',
            'Davomad olindi',
        ];
    }

    public function map($user_davomad): array{
        return [
            $user_davomad->id,
            $user_davomad->user_id,
            $user_davomad->student->name,
            $user_davomad->group_id,
            $user_davomad->group_id?$user_davomad->group->group_name:"",
            $user_davomad->date->format("Y-m-d"),
            $user_davomad->status,
            $user_davomad->creator->name ?? 'Tizim',
            $user_davomad->created_at->format('Y-m-d H:i'),
        ];
    }
    
}
