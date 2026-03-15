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
        <div class="card notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;height:500px">
          <div class="card-body">
            <h5 class="card-title">Kurslar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Kurs nomi</th>
                    <th>Video darslar</th>
                    <th>Audio fayllar</th>
                    <th>Testlar</th>
                    <th>Kurs turi</th>
                    <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
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
            <form action="" method="post">
              @csrf
              <label for="" class="mb-2">Kurs nomi</label>
              <input type="text" class="form-control" required>
              <label for="" class="my-2">Kurs turi</label>
              <select name="" required class="form-select">
                <option value="">Tanlang</option>
                <option value="free">Bepul kurs</option>
                <option value="private">Maxsus kurs</option>
              </select>
              <button class="btn btn-primary w-100 mt-3">Kursni saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;height:500px">
          <div class="card-body">
            <h5 class="card-title">Dars xonalar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Hudud Kodi</th>
                    <th>Hudud nomi</th>
                    <th>Admin</th>
                    <th>Hudud qo'shildi</th>
                    <th>O'chirish</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
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
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection