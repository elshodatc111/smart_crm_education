<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){
        return User::where('role', 'user')->get();
    }
    
    public function headings(): array{
        return [
            'ID',
            'Status',
            'FIO',
            'Balans',
            'Telefon',
            'Qo\'shimcha telefon',
            'Tug\'ilgan kuni',
            'Hudud',
            'Ro\'yhatga oldi',
            'Ro\'yxatdan o\'tgan sana',
        ];
    }

    public function map($user): array{
        return [
            $user->id,
            $user->is_active ? 'Faol' : 'Nofaol',
            $user->name,
            number_format($user->balance, 0, '.', ' ') . ' UZS',
            "Tel: ".$user->phone,
            "Tel: ".$user->phone_alt,
            $user->birth_date ? $user->birth_date->format("Y-m-d") : '-',
            $this->formatAddress($user->address), // Hudud kodini nomga o'girish
            $user->creator->name ?? 'Tizim',
            $user->created_at->format('Y-m-d H:i'),
        ];
    }

    private function formatAddress($code){
        $addresses = [
            '10401' => 'Qarshi shaxar',
            '10224' => 'Qarshi tumani',
            '10229' => 'Koson tumani',
            '10207' => 'G\'uzor tumani',
            '10235' => 'Nishon tumani',
            '10233' => 'Mirishkor tumani',
            '10234' => 'Muborak tumani',
            '10237' => 'Kasbi tumani',
            '10240' => 'Ko\'kdala tumani',
            '10242' => 'Chiroqchi tumani',
            '10220' => 'Qamashi tumani',
            '10245' => 'Shaxrisabz tumani',
            '10232' => 'Kitob tumani',
            '10250' => 'Yakkabog\' tumani',
            '10212' => 'Dexqonobod tumani',
            '10246' => 'Shaxrisabz shaxar',
        ];
        return $addresses[$code] ?? 'Boshqa';
    }

}
