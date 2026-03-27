@extends('layouts.admin')
@section('title', 'Hisobot')
@section('content')
  <div class="pagetitle">
    <h1>Hisobot</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">To'lovlar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">To'lovlar</h5>
        <form action="{{ route('report_export') }}" method="post">
          @csrf 
          <div class="row">
            <div class="col-6">
              <select name="report_type" required class="form-select">
                <option value="">Tanlang...</option>
                <option value="user_payment">Talaba to'lovlari</option>
                <option value="emploes_payment">Hodimlarga ish haqi to'lovlari</option>
                <option value="kasssHistory">Kassa tarixi</option>
                <option value="balans_history">Balans tarixi</option>
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