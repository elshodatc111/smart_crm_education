<?php

namespace App\Exports;

use App\Models\GroupUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GroupUserExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return GroupUser::all();
    }

    public function headings(): array{
        return [
            "ID",
            "GroupID",
            "Group",
            "UserID",
            "User",
            "Status",
            "Start",
            "StartComment",
            "StartAdminID",
            "StartAdmin",
            "EdnData",
            "EndCommint",
            "EndAdminID",
            "EndAdmin",
        ];
    }

    public function map($user_user): array{
        return [
            $user_user->id,
            $user_user->group_id,
            $user_user->group->group_name,
            $user_user->user_id,
            $user_user->user->name,
            $user_user->is_active,
            $user_user->start_data->format("Y-m-d"),
            $user_user->start_comment,
            $user_user->start_admin_id,
            $user_user->startAdmin->name,
            $user_user->end_data?$user_user->end_data->format("Y-m-d"):"",
            $user_user->end_comment?$user_user->end_comment:"",
            $user_user->end_admin_id?$user_user->end_admin_id:"",
            $user_user->end_admin_id?$user_user->endAdmin->name:"",
        ];
    }


}
