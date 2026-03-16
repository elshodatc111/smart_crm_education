<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\web\SettingCreateRegionRequest;
use App\Models\Classroom;
use App\Models\Cours;
use App\Models\CoursAudio;
use App\Models\CoursBook;
use App\Models\CoursTest;
use App\Models\CoursVideo;
use App\Models\SettingRegion;
use App\Models\SettingSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller{

    public function payment(){
        return view('setting.payment');
    }

    public function coursRoom(){
        $cours = Cours::withCount([
            'videos',
            'audios',
            'tests',
            'books'
        ])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'cours_name' => $item->cours_name,
                'cours_type' => $item->cours_type == 'free' ? 'Bepul kurs' : 'Maxsus kurs',
                'video' => $item->videos_count,
                'audio' => $item->audios_count,
                'test' => $item->tests_count,
                'book' => $item->books_count,
            ];
        });
        $classrooms = Classroom::all();
        return view('setting.cours', compact('cours','classrooms'));
    }
    public function coursShow($id){
        $cours = Cours::findOrFail($id);
        $cours_video = CoursVideo::where('cours_id',$id)->orderby('sort_order','asc')->get();
        $cours_tests = CoursTest::where('cours_id',$id)->get();
        $cours_audio = CoursAudio::where('cours_id',$id)->orderby('sort_order','asc')->get();
        $cours_books = CoursBook::where('cours_id',$id)->get();
        return view('setting.cours_show',compact('cours','cours_video','cours_tests','cours_audio','cours_books'));
    } 
    public function destroyBook($id){
        $book = CoursBook::findOrFail($id);
        if ($book->book_url) {
            $path = public_path(parse_url($book->book_url, PHP_URL_PATH));
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $book->delete();
        return back()->with('success', 'Kitob muvaffaqiyatli o‘chirildi');
    }
    public function storeBook(Request $request){
        $request->validate([
            'cours_id' => 'required',
            'book_name' => 'required|string|max:255',
            'book_file' => 'required|mimes:pdf|max:1024',
            'description' => 'required|string'
        ]);
        $bookPath = null;
        if ($request->hasFile('book_file')) {
            $file = $request->file('book_file');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('books'), $filename);
            $bookPath = url('books/'.$filename);
        }
        CoursBook::create([
            'cours_id' => $request->cours_id,
            'book_name' => $request->book_name,
            'book_url' => $bookPath,
            'description' => $request->description
        ]);
        return back()->with('success','Kitob muvaffaqiyatli yuklandi');
    }
    public function destroyAudio($id){
        $audio = CoursAudio::findOrFail($id);
        if ($audio->audio_url) {
            $path = public_path(parse_url($audio->audio_url, PHP_URL_PATH));
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $audio->delete();
        return back()->with('success', 'Audio muvaffaqiyatli o‘chirildi');
    }
    public function storeAudio(Request $request){
        $request->validate([
            'cours_id' => 'required',
            'audio_name' => 'required|string|max:255',
            'audio_file' => 'required|mimetypes:audio/mpeg,audio/x-ms-wma,audio/wav|max:1024',
            'description' => 'required|string',
            'sort_order' => 'required|integer'
        ]);
        $audioPath = null;
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('audios'), $filename);
            $audioPath = url('audios/'.$filename);
        }
        CoursAudio::create([
            'cours_id' => $request->cours_id,
            'audio_name' => $request->audio_name,
            'audio_url' => $audioPath,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
        ]);
        return back()->with('success','Audio muvaffaqiyatli yuklandi');
    }
    public function destroyTest($id){
        $test = CoursTest::findOrFail($id);
        $test->delete();
        return redirect()->back()->with('success','Test savoli muvaffaqiyatli o\'chirildi');
    }
    public function storeTest(Request $request){
        $request->validate([
            'cours_id' => 'required',
            'test_quez' => 'required|string|max:255',
            'answer_a' => 'required|string',
            'answer_b' => 'required|string',
            'answer_c' => 'required|string',
            'answer_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);
        CoursTest::create([
            'cours_id' => $request->cours_id,
            'test_quez' => $request->test_quez,
            'answer_a' => $request->answer_a,
            'answer_b' => $request->answer_b,
            'answer_c' => $request->answer_c,
            'answer_d' => $request->answer_d,
            'correct_answer' => $request->correct_answer,
        ]);
        return back()->with('success','Test savoli muvaffaqiyatli qo‘shildi');
    }
    public function destroyVideo($id){
        $video = CoursVideo::findOrFail($id);
        $video->delete();
        return redirect()->back()->with('success','Video muvaffaqiyatli o\'chirildi');
    }
    public function storeVideo(Request $request){
        $request->validate([
            'cours_id' => 'required',
            'video_name' => 'required|string|max:255',
            'video_url' => 'required|url',
            'description' => 'required|string',
            'sort_order' => 'required|integer|min:1'
        ]);
        CoursVideo::create([
            'cours_id' => $request->cours_id,
            'video_name' => $request->video_name,
            'video_url' => $request->video_url,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
        ]);
        return back()->with('success','Video muvaffaqiyatli qo‘shildi');
    }
    public function destroyCours($id){
        $cours = Cours::findOrFail($id);
        $cours->delete();
        return redirect()->route('setting_cours')->with('success','Kurs muvaffaqiyatli o\'chirildi');
    }
    public function updateCours(Request $request, $id){
        $request->validate([
            'cours_name' => 'required|string|max:255',
            'cours_type' => 'required',
            'description' => 'required|string'
        ]);
        $cours = Cours::findOrFail($id);
        $cours->update([
            'cours_name' => $request->cours_name,
            'cours_type' => $request->cours_type,
            'description' => $request->description
        ]);
        return redirect()->back()->with('success','Kurs muvaffaqiyatli yangilandi');
    }
    public function storeCours(Request $request){
        $request->validate([
            'cours_name' => 'required|string|max:255',
            'cours_type' => 'required|in:free,premium',
            'description' => 'required|string|max:500'
        ]);
        Cours::create([
            'cours_name' => $request->cours_name,
            'cours_type' => $request->cours_type,
            'description' => $request->description
        ]);
        return back()->with('success','Kurs muvaffaqiyatli qo\'shildi');
    }
    public function destroyRoom($id){
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return redirect()->back()->with('success','Xona muvaffaqiyatli o\'chirildi');
    }
    public function storeRoom(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'sigim' => 'required|integer|min:1',
            'qavat' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);
        Classroom::create([
            'name' => $request->name,
            'sigim' => $request->sigim,
            'qavat' => $request->qavat,
            'description' => $request->description
        ]);
        return back()->with('success','Xona muvaffaqiyatli qo\'shildi');
    }
    public function region(){
        $regions = SettingRegion::get();
        $setting = SettingSms::firstOrCreate(
            [],
            [
                'visit_sms' => false,
                'payment_sms' => false,
                'password_sms' => false,
                'birthday_sms' => false,
            ]
        );
        return view('setting.region',compact('regions','setting'));
    }
    public function createRegion(SettingCreateRegionRequest $request){
        SettingRegion::create([
            ...$request->validated(),
            'created_by' => Auth::id()
        ]);
        return back()->with('success','Hudud muvaffaqiyatli qo‘shildi');
    }
    public function destroyRegion($id){
        $region = SettingRegion::findOrFail($id);
        $region->deleted_by = Auth::id();
        $region->save();
        $region->delete();
        return back()->with('success','Hudud muvaffaqiyatli o‘chirildi');
    }
    public function smsUpdate(Request $request){
        SettingSms::updateOrCreate(
            ['id' => 1],
            [
                'visit_sms' => $request->has('visit_sms'),
                'payment_sms' => $request->has('payment_sms'),
                'password_sms' => $request->has('password_sms'),
                'birthday_sms' => $request->has('birthday_sms'),
            ]
        );
        return back()->with('success', 'SMS sozlamalar yangilandi');
    }







}
