<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
class UsersImport implements WithHeadingRow, ToCollection{
    public $errors = [];
    public $successCount = 0;
    public function collection(Collection $rows){
        foreach ($rows as $index => $row) {
            if (!isset($row['name']) || empty($row['name'])) {
                continue;
            }
            $validator = Validator::make($row->toArray(), [
                'id' => 'nullable',
                'name'     => 'required|string|max:255',
                'phone'    => 'required|unique:users,phone',
                'phone_alt'    => 'required',
                'balance' => 'required|numeric',
                'birth_date' => 'nullable',
                'address' => 'required|in:10207,10212,10220,10224,10229,10232,10233,10234,10235,10237,10240,10242,10245,10246,10250,10401',
                'password' => 'required|min:8',
            ]);
            if ($validator->fails()) {
                $row['error_reason'] = implode(', ', $validator->errors()->all());
                $row['row_number'] = $index + 2;
                $this->errors[] = $row->toArray();
                continue;
            }
            try {
                $birthDate = is_numeric($row['birth_date']) ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birth_date'])) : \Carbon\Carbon::parse($row['birth_date']);
                User::create([
                    'role'       => 'user',
                    'is_active'  => true,
                    'name'       => $row['name'],
                    'phone'      => $row['phone'],
                    'phone_alt'  => $row['phone_alt'],
                    'balance'    => $row['balance'],
                    'birth_date' => $birthDate,
                    'address'    => $row['address'],
                    'password'   => $row['password'],
                    'created_by' => Auth::id(),
                ]);
                
                $this->successCount++;
            } catch (\Exception $e) {
                $row['error_reason'] = "Sana yoki ma'lumot formatida xatolik: " . $e->getMessage();
                $row['row_number'] = $index + 2;
                $this->errors[] = $row->toArray();
            }
        }
    }
}
 