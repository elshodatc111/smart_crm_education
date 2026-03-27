@extends('layouts.admin')
@section('title', 'Hisobot')
@section('content')
  <div class="pagetitle">
    <h1>Hisobot</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Yuborilgan SMS</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Hush kelibsiz</h5>
        <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
      </div>
    </div>
  </section>
@endsection