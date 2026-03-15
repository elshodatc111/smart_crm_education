@extends('layouts.admin')
@section('title', 'Kurslar | Xonalar')
@section('content')
  <div class="pagetitle">
    <h1>Kurslar | Xonalar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kurslar | Xonalar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Kurslar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kurs nomi</th>
                    <th>Kurs turi</th>
                    <th>Video darslar</th>
                    <th>Audio fayllar</th>
                    <th>Testlar</th>
                    <th>Kurs kitoblari</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($cours as $item)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td><a href="{{ route('setting_cours_show',$item['id']) }}">{{ $item['cours_name'] }}</a></td>
                      <td>{{ $item['cours_type'] }}</td>
                      <td class="text-center">{{ $item['video'] }}</td>
                      <td class="text-center">{{ $item['audio'] }}</td>
                      <td class="text-center">{{ $item['test'] }}</td>
                      <td class="text-center">{{ $item['book'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center">Kurslar mavjud emas</td>
                    </tr>
                  @endforelse                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Yangi kurs</h5>
            <form action="{{ route('cours_store') }}" method="post">
              @csrf
              <label for="cours_name" class="mb-2">Kurs nomi</label>
              <input type="text" name="cours_name" class="form-control" required>
              <label for="cours_type" class="my-2">Kurs turi</label>
              <select name="cours_type" required class="form-select">
                <option value="">Tanlang</option>
                <option value="free">Bepul kurs</option>
                <option value="premium">Maxsus kurs</option>
              </select>
              <label for="description" class="my-2">Kurs haqida</label>
              <input type="text" name="description" required class="form-control">
              <button class="btn btn-primary w-100 mt-3">Kursni saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 442px; overflow-y: auto; overflow-x: hidden;height:500px">
          <div class="card-body">
            <h5 class="card-title">Dars xonalar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                  <th>#</th>
                  <th>Xona nomi</th>
                  <th>Xona Sig'imi</th>
                  <th>Xona qavati</th>
                  <th>Xona haqida</th>
                  <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($classrooms as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td class="text-center">{{ $item->sigim }}</td>
                      <td class="text-center">{{ $item->qavat }}</td>
                      <td>{{ $item->description }}</td>
                      <td class="text-center">
                        <form action="{{ route('classroom_destroy',$item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu xonani o\'chirmoqchimisiz?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="6">Dars xonalari mavjud emas</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Yangi dars xonasi</h5>
            <form action="{{ route('classrooms_store') }}" method="post">
              @csrf 
              <label for="name" class="mb-2">Xona nomi</label>
              <input type="text" name="name" class="form-control" required>
              <label for="sigim" class="my-2">Xona sig'imi</label>
              <input type="number" name="sigim" class="form-control" required>
              <label for="qavat" class="my-2">Xona qavati</label>
              <input type="number" name="qavat" class="form-control" required>
              <label for="description" class="my-2">Xona haqida</label>
              <input type="text" name="description" class="form-control" required>
              <button class="btn btn-primary w-100 mt-3">Xonani saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection