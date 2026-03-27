<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AllGroupsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return Group::all();
    }
    
    public function headings(): array{
        return [
            'ID',
            'CoursID',
            'Cours',
            'RoomID',
            'Room',
            'TeacherID',
            'Teacher',
            'Price',
            'Price Descount',
            'Descount',
            'Descount Data',
            'Group',
            'LessinCount',
            'Start',
            'End',
            'TeacherPay',
            'TeacherBonus',
            'Meneger',
            'NextGroupID',
            'Time',
            'DataType',
            'Created',
        ];
    }

    public function map($group): array{
        return [
            $group->id,
            $group->cours_id,
            $group->course->cours_name,
            $group->room_id, 
            $group->room->name,
            $group->teacher_id,
            $group->teacher->name,
            number_format($group->payment->payment+$group->payment->discount, 0, '.', ' ') . ' UZS',
            number_format($group->payment->payment, 0, '.', ' ') . ' UZS',
            number_format($group->payment->discount, 0, '.', ' ') . ' UZS',
            $group->payment->discount_day,
            $group->group_name,
            $group->lesson_count,
            $group->start_lesson->format("Y-m-d"),
            $group->end_lesson,
            number_format($group->teacher_pay, 0, '.', ' ') . ' UZS',
            number_format($group->teacher_bonus, 0, '.', ' ') . ' UZS',
            $group->admin->name, // Meneger
            $group->next_group_id,
            $group->lesson_time,
            $group->group_type,
            $group->created_at->format("Y-m-d h:i"),
        ];
    }
}
