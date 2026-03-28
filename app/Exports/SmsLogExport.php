<?php

namespace App\Exports;

use App\Models\SmsLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting; 
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SmsLogExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize{

    public function collection(){ 
        return SmsLog::all();
    }
        
    public function headings(): array{
        return [
            'ID',
            'PHONE',
            'MESSAGE',
            'SMSID',
            'STATUS',
            'TIME',
        ];
    }

    public function map($message): array{
        return [
            $message->id,
            " +".$message->phone,
            $message->message,
            $message->sms_id,
            $message->status,
            $message->created_at->format('Y-m-d H:i'),
        ];
    }
}
