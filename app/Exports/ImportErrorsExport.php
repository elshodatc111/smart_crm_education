<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportErrorsExport implements FromCollection, WithHeadings{

    protected $errors;

    public function __construct(array $errors){
        $this->errors = $errors;
    }

    public function collection(){
        return collect($this->errors);
    }

    public function headings(): array{
        return array_keys($this->errors[0]);
    }

}
 