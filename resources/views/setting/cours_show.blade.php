@extends('layouts.admin')
@section('title', 'Kurs')
@section('content')
  <div class="pagetitle">
    <h1>Kurs</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setting_cours') }}">Kurslar | Xonalar</a></li>
        <li class="breadcrumb-item active">Kurs</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <!-- Kurs haqida -->
    <div class="row">
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;height:350px">
          <div class="card-body">
            <h5 class="card-title">Kurs haqida</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <tr>
                  <th>Kurs nomi</th>
                  <td style="text-align: right">{{ $cours['cours_name'] }}</td>
                </tr>
                <tr>
                  <th>Kurs turi</th>
                  <td style="text-align: right">
                    @if($cours['cours_type']=='free')
                      Bepul kurs
                    @else
                      Maxsus kurs
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Kurs haqida</th>
                  <td style="text-align: right">{{ $cours['description'] }}</td>
                </tr>
                <tr>
                  <th>Kurs yaratildi</th>
                  <td style="text-align: right">{{ $cours['created_at'] }}</td>
                </tr>
                <tr>
                  <th>Kurs yangilandi</th>
                  <td style="text-align: right">{{ $cours['updated_at'] }}</td>
                </tr>
              </table>
              <form action="{{ route('cours_destroy', $cours['id'] ) }}" method="post" onsubmit="return confirm('Haqiqatan ham bu kursni o\'chirmoqchimisiz?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger w-100 mt-3">Kursni o'chirish</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;height:350px">
          <div class="card-body">
            <h5 class="card-title">Kursni taxrirlash</h5>
            <form action="{{ route('cours_update', $cours['id']) }}" method="post">
              @csrf 
              @method('PUT')
              <label for="cours_name" class="mb-1">Kurs nomi</label>
              <input type="text" name="cours_name" value="{{ $cours['cours_name'] }}" class="form-control" required>
              <label for="cours_type" class="my-1">Kurs turi</label>
              <select name="cours_type" required class="form-select">
                  <option value="">Tanlang</option>
                  <option value="free" {{ $cours['cours_type'] == 'free' ? 'selected' : '' }}>Bepul kurs</option>
                  <option value="premium" {{ $cours['cours_type'] == 'premium' ? 'selected' : '' }}>Maxsus kurs</option>
              </select>
              <label for="description" class="my-1">Kurs haqida</label>
              <input type="text" value="{{ $cours['description'] }}" name="description" required class="form-control">
              <button class="btn btn-primary w-100 mt-3">Kursni yangilash</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;height:350px">
          <div class="card-body">
            <h5 class="card-title">Kursga yangi kitob qo'shish</h5>
            <form action="{{ route('books_store') }}" method="post" enctype="multipart/form-data">
              @csrf 
              <input type="hidden" name="cours_id" value="{{ $cours['id'] }}">
              <label for="book_name" class="my-1">Kitob nomi</label>
              <input type="text" name="book_name" required class="form-control">
              <label for="book_file" class="my-1">AKitob fayli (.pdf, max:1MB)</label>
              <input type="file" name="book_file" required class="form-control">
              <label for="description" class="my-1">AKitob haqida</label>
              <input type="text" name="description" required class="form-control">
              <button type="submit" class="btn btn-primary w-100 mt-2">Testni saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <div class="card notes-wrapper" style="max-height: 415px; overflow-y: auto; overflow-x: hidden;height:415px">
          <div class="card-body">
            <h5 class="card-title">Kursga yangi video qo'shish</h5>
            <form action="{{ route('videos_store') }}" method="post">
              @csrf 
              <input type="hidden" name="cours_id" value="{{ $cours['id'] }}">
              <label for="video_name" class="mb-1">Video dars nomi</label>
              <input type="text" name="video_name" required class="form-control">
              <label for="video_url" class="my-1">Video url(Youtube)</label>
              <input type="text" name="video_url" required class="form-control">
              <label for="description" class="my-1">Video haqida</label>
              <input type="text" name="description" required class="form-control">
              <label for="sort_order" class="my-1">Video dars tartib raqami</label>
              <input type="number" min="1" name="sort_order" required class="form-control">
              <button class="btn btn-primary w-100 mt-2">Videoni saqlash</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card notes-wrapper" style="max-height: 415px; overflow-y: auto; overflow-x: hidden;height:415px">
          <div class="card-body">
            <h5 class="card-title">Kursga yangi audio qo'shish</h5>
            <form action="{{ route('audio_store') }}" method="post" enctype="multipart/form-data">
              @csrf 
              <input type="hidden" name="cours_id" value="{{ $cours['id'] }}">
              <label for="audio_name" class="my-1">Audo nomi</label>
              <input type="text" name="audio_name" required class="form-control">
              <label for="audio_file" class="my-1">Audio fayli (.mp3, .wma, max:1MB)</label>
              <input type="file" name="audio_file" required class="form-control">
              <label for="description" class="my-1">Audio haqida</label>
              <input type="text" name="description" required class="form-control">
              <label for="sort_order" class="my-1">Audio tartib raqami</label>
              <input type="text" name="sort_order" required class="form-control">
              <button type="submit" class="btn btn-primary w-100 mt-2">Testni saqlash</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card notes-wrapper" style="max-height: 415px; overflow-y: auto; overflow-x: hidden;height:415px">
          <div class="card-body">
            <h5 class="card-title">Kursga yangi test qo'shish</h5>
            <form action="{{ route('tests_store') }}" method="post">
              @csrf 
              <input type="hidden" name="cours_id" value="{{ $cours['id'] }}">
              <label for="test_quez" class="my-1">Test savoli</label>
              <input type="text" name="test_quez" required class="form-control">
              <div class="row">
                <div class="col-lg-6">
                  <label for="answer_a" class="my-1">A variant</label>
                  <input type="text" name="answer_a" required class="form-control">
                </div>
                <div class="col-lg-6">
                  <label for="answer_b" class="my-1">B variant</label>
                  <input type="text" name="answer_b" required class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <label for="answer_c" class="my-1">C variant</label>
                  <input type="text" name="answer_c" required class="form-control">
                </div>
                <div class="col-lg-6">
                  <label for="answer_d" class="my-1">D variant</label>
                  <input type="text" name="answer_d" required class="form-control">
                </div>
              </div>
              <label for="correct_answer" class="my-1">To'g'ri javobni tanlang</label>
              <select name="correct_answer" required class="form-select">
                <option value="">Tanlang</option>
                <option value="a">A javob</option>
                <option value="b">B javob</option>
                <option value="c">C javob</option>
                <option value="d">D javob</option>
              </select>
              <button class="btn btn-primary w-100 mt-2">Testni saqlash</button>
            </form>
          </div>
        </div>
      </div>
      

    <!-- Kurs videolari -->
      <div class="col-lg-6">
        <div class="card notes-wrapper" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;height:400px">
          <div class="card-body">
            <h5 class="card-title">Video darslar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Video nomi</th>
                    <th>Video manzili</th>
                    <th>Video haqida</th>
                    <th>Tartib raqami</th>
                    <th>Videoni o'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($cours_video as $item)
                  <tr>
                    <td class="text-center">{{ $loop->index+1 }}</td>
                    <td>{{ $item['video_name'] }}</td>
                    <td>
                        <a href="{{ $item['video_url'] }}" target="_blank">Videoni ko'rish</a>
                    </td>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-center">{{ $item['sort_order'] }}</td>
                    <td class="text-center">
                      <form action="{{ route('video_destroy',$item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu videoni o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center">
                      Video darslar mavjud emas
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <!-- Kurs testlari -->
      <div class="col-lg-6">
        <div class="card notes-wrapper" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;height:400px">
          <div class="card-body">
            <h5 class="card-title">Kurs testlari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Test savoli</th>
                    <th>A javob</th>
                    <th>B javob</th>
                    <th>C javob</th>
                    <th>D javob</th>
                    <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($cours_tests as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>{{ $item['test_quez'] }}</td>
                      <td><i class={{ $item['correct_answer']=='a'?'text-success':'text-danger' }}>{{ $item['answer_a'] }}</i></td>
                      <td><i class={{ $item['correct_answer']=='b'?'text-success':'text-danger' }}>{{ $item['answer_b'] }}</i></td>
                      <td><i class={{ $item['correct_answer']=='c'?'text-success':'text-danger' }}>{{ $item['answer_c'] }}</i></td>
                      <td><i class={{ $item['correct_answer']=='d'?'text-success':'text-danger' }}>{{ $item['answer_d'] }}</i></td>
                      <td class="text-center">
                        <form action="{{ route('test_destroy',$item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu testni o\'chirmoqchimisiz?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center">Test savollari mavjud emas</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <!-- Kurs audiolari -->
      <div class="col-lg-6">
        <div class="card notes-wrapper" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;height:400px">
          <div class="card-body">
            <h5 class="card-title">Kurs audiolari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Audio nomi</th>
                    <th>Audio</th>
                    <th>Audio haqida</th>
                    <th>Tartib raqami</th>
                    <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($cours_audio as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>{{ $item['audio_name'] }}</td>
                      <td>
                          <a href="{{ $item['audio_url'] }}" target="_blank">Audio ko'rish</a>
                      </td>
                      <td>{{ $item['description'] }}</td>
                      <td class="text-center">{{ $item['sort_order'] }}</td>
                      <td class="text-center">
                        <form action="{{ route('audio_delete',$item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu audioni o\'chirmoqchimisiz?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="6">Audio fayllar mavjud emas</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <!-- Kurs kitoblari -->
      <div class="col-lg-6">
        <div class="card notes-wrapper" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;height:400px">
          <div class="card-body">
            <h5 class="card-title">Kurs kitoblari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kitob nomi</th>
                    <th>Kitob</th>
                    <th>Kitob Haqida</th>
                    <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($cours_books as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>{{ $item['book_name'] }}</td>
                      <td>
                          <a href="{{ $item['book_url'] }}" target="_blank">Audio ko'rish</a>
                      </td>
                      <td>{{ $item['description'] }}</td>
                      <td class="text-center">
                        <form action="{{ route('book_delete',$item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu kitobni o\'chirmoqchimisiz?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="5">Kitoblar mavjud emas</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>



@endsection