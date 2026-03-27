@extends('layouts.admin')
@section('title', 'Hisobot')
@section('content')
  <div class="pagetitle">
    <h1>Hisobot</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Guruhlar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Guruhlar</h5>
        <form action="{{ route('report_export') }}" method="post">
          @csrf 
          <div class="row">
            <div class="col-6">
              <select name="report_type" required class="form-select">
                <option value="">Tanlang...</option>
                <option value="all_groups">Barcha guruhlar</option>
                <option value="all_group_data">Guruhlar dars kunlari</option>
                <option value="all_quez_history">Test natijalari</option>
                <option value="all_group_user">Guruh talabalari</option>
              </select>
            </div>
            <div class="col-6">
              <button class="btn btn-primary w-100">Excelga yuklash</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection