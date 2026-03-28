<?php

namespace App\Imports;

use App\Models\UserHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class UsersHistoryImport implements WithHeadingRow, ToCollection{
    public $errors = [];
    public $successCount = 0;
    public function collection(Collection $rows){
        foreach ($rows as $index => $row) {
            if (!isset($row['user_id']) || empty($row['user_id'])) {
                continue;
            }
            
            $validator = Validator::make($row->toArray(), [
                'id' => 'nullable',
                'user_id'     => 'required|exists:users,id',
                'type'    => 'required|in:visit,payment_cash,payment_card,payment_return,discont,jarima,group_add,group_delete,resset_password,update,status_of,status_on',
                'description' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                $row['error_reason'] = implode(', ', $validator->errors()->all());
                $row['row_number'] = $index + 2;
                $this->errors[] = $row->toArray();
                continue;
            }
            try {
                UserHistory::create([
                    'user_id'       => $row['user_id'],
                    'type'       => $row['type'],
                    'description'      => $row['description'],
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
