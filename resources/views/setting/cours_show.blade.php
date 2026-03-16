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
    <div class="row">
      <div class="col-lg-6">
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
      <div class="col-lg-6">
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
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
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
                    <td>{{ $loop->index+1 }}</td>
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
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Yangi videi dars</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Kurs audiolari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kurs nomi</th>
                  </tr>
                </thead>
                <tbody>
                  <td>1</td>
                  <td></td>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Yangi audio</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Kurs testlari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kurs nomi</th>
                  </tr>
                </thead>
                <tbody>
                  <td>1</td>
                  <td></td>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Yangi test</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Kurs kitoblari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kurs nomi</th>
                  </tr>
                </thead>
                <tbody>
                  <td>1</td>
                  <td></td>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Yangi kitob</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection