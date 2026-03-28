@extends('layouts.admin')
@section('title', 'Upload')
@section('content')
  <div class="pagetitle">
    <h1>Upload</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Upload</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Talabalar yuklash</h5>
            <p>Shablon <a href="{{ asset('users.xlsx') }}" download>yuklash</a></p>
            <form action="{{ route('upload_users') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <label for="excel">Talabalar jadvali Excel faylini yuklang (.xlsx, max: 500kb)</label>              
              <input type="file" name="excel" id="excel" required class="form-control my-2">              
              <button type="submit" class="btn btn-primary w-100">Yuklash</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Talabalar tarixini yuklash</h5>
            <p>Shablon <a href="{{ asset('user_history.xlsx') }}" download>yuklash</a></p>
            <form action="{{ route('upload_user_history') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <label for="excel">Talabalar jadvali Excel faylini yuklang (.xlsx, max: 500kb)</label>              
              <input type="file" name="excel" id="excel" required class="form-control my-2">              
              <button type="submit" class="btn btn-primary w-100">Yuklash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection