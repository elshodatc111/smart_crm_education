<?php

namespace App\Exports;

use App\Models\GroupTest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TestNatijaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return GroupTest::all();
    }
        
    public function headings(): array{
        return [
            "ID",
            "GroupID",
            "Group",
            "CoursID",
            "Cours",
            "UserID",
            "User",
            "Savollar soni",
            "To'g'ri javob",
            "Ball",
            "Topshirish vaqti",
        ];
    }

    public function map($test): array{
        return [
            $test->id,
            $test->group_id,
            $test->group->group_name,
            $test->cours_id,
            $test->course->cours_name,
            $test->user_id,
            $test->user->name,
            $test->savollar,
            $test->togri_javob,
            $test->ball,
            $test->created_at->format('Y-m-d h:i'),
        ];
    }
}
