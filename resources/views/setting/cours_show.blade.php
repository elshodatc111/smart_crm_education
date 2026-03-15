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
    <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
      <div class="card-body">
        <h5 class="card-title">Kurs haqida</h5>
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