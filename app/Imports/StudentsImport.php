<?php
namespace App\Imports;

use App\Models\User;
use App\Models\UserHistory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class StudentsImport implements ToCollection, WithHeadingRow{
    public $stats = [
        'all' => 0,
        'success' => 0,
        'error' => 0
    ];
    public function collection(Collection $rows) {
        foreach ($rows as $index => $row) {
            $this->stats['all']++;
            $user = User::where('phone', $row['phone'])->first();
            if (!$user) {
                $userCreate = User::create([
                    'role' => 'user',
                    'is_active' => true,
                    'name' => $row['name'],
                    'phone' => "+".$row['phone'],
                    'phone_alt' => "+".$row['phone_alt'],
                    'balance' => $row['balance'],
                    'birth_date' => $row['birth_date'],
                    'address' => $row['address'],
                    'password' => 'password',
                    'created_by' => Auth::id(),
                ]);
                UserHistory::create([
                    'user_id' => $userCreate->id,
                    'type' => 'visit',
                    'description' => $row['description'],
                    'created_by' => Auth::id(),
                ]);
                $this->stats['success']++;
            } else {
                $this->stats['error']++;
                Log::warning("Qator #" . ($index + 1) . ": Telefon raqami bazada bor: " . $row['phone']);
            }
        }
    }
    public function prepareForValidation($data, $index){
        $requiredKeys = ['name', 'phone', 'phone_alt', 'balance', 'birth_date', 'address', 'type', 'description'];        
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new Exception("Jadvalda xatolik: '{$key}' ustuni topilmadi yoki xato yozilgan.");
            }
        }
        return $data;
    }
}