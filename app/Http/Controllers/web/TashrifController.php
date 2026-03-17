<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Visit\ChangeUserStatusRequest;
use App\Http\Requests\Web\Visit\StoreVisitRequest;
use App\Http\Requests\Web\Visit\UpdateUserRequest;
use App\Models\Note;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TashrifController extends Controller{

    public function tashriflar(){
        $users = User::where('role','user')->orderby('id','desc')->get();
        return view('tashrif.tashriflar',compact('users'));
    }

    public function store(StoreVisitRequest $request){
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'phone_alt' => $request->phone_alt,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => 'password',
            'role' => 'user',
            'is_active' => true,
            'balance' => 0,
            'created_by' => Auth::id(),
        ]);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'visit',
            'description' => "Markazga tashri",
            'created_by' => Auth::id()
        ]);
        return back()->with('success','Tashrif muvaffaqiyatli qo‘shildi');
    }

    public function tashrifShow($id){
        $user = User::findOrFail($id);
        $notes = Note::where('note_id',$id)->where('type','user')->orderby('id', 'desc')->get();
        $history = UserHistory::where('user_id',$id)->orderby('id','desc')->get();
        return view('tashrif.tashrif_show',compact('user','notes','history'));
    }

    public function storeNote(Request $request){
        $request->validate([
            'note_id' => 'required|integer',
            'type' => 'required|in:user,emploes,groups',
            'text' => 'required|string|max:1000',
        ]);
        Note::create([
            'note_id' => $request->note_id,
            'type' => $request->type,
            'text' => $request->text,
            'created_by' => Auth::id(),
        ]);
        return back()->with('success', 'Eslatma qo‘shildi');
    }

    public function changeStatus(ChangeUserStatusRequest $request){
        $user = User::findOrFail($request->user_id);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => $user->is_active?'status_of':'status_on',
            'description' => $user->is_active?"Talaba bloklandi":"Talaba aktivlashtirildi",
            'created_by' => Auth::id()
        ]);
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'Status muvaffaqiyatli o‘zgartirildi');
    }

    public function resetPassword(ChangeUserStatusRequest $request){
        $user = User::findOrFail($request->user_id);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'resset_password',
            'description' => 'Talaba paroli yangilandi',
            'created_by' => Auth::id()
        ]);
        $user->password = 'password';
        $user->save();
        return back()->with('success', "Parol yangilandi. Yangi parol: password");
    }
    
    public function update(UpdateUserRequest $request, $id){
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'phone_alt' => $request->phone_alt,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);
        UserHistory::create([
            'user_id' => $user->id,
            'type' => 'update',
            'description' => 'Talaba malumotlari yangilandi',
            'created_by' => Auth::id()
        ]);
        return back()->with('success', 'Foydalanuvchi ma’lumotlari yangilandi');
    }

}
