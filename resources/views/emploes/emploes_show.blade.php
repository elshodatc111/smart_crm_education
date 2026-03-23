@extends('layouts.admin')
@section('title', 'Hodimlar')
@section('content')
  <div class="pagetitle">
    <h1>Hodimlar</h1>
    <div class="row">
      <nav class="col-lg-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('emploes') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Hodim haqida</li>
        </ol>
      </nav>
      <nav class="col-lg-6 d-flex justify-content-end gap-2">
        <form action="{{ route('emploes_updatePassword') }}" method="post" 
          onsubmit="return confirm('Parolni yangilamoqchimisiz?')">
          @csrf 
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <button type="submit" class="btn btn-primary">Parolni yangilash</button>
        </form>
        <form action="{{ route('emploes_toggleStatus') }}" method="post" 
          onsubmit="return confirm('{{ $user['is_active'] ? 'Foydalanuvchini bloklamoqchimisiz?' : 'Foydalanuvchini aktiv qilmoqchimisiz?' }}')">
          @csrf 
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          @if($user['is_active'])
              <button type="submit" class="btn btn-danger">Bloklash</button>
          @else
              <button type="submit" class="btn btn-success">Aktivlashtirish</button>
          @endif
        </form>
      </nav>
    </div>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="{{ $user->role=='teacher' ? 'col-lg-6':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <table class="table table-bordered" style="font-size:14px;">
              <tr><th>Lavozim</th>
                <td style="text-align: right">
                  @if($user->role=='operator') Operator @elseif($user->role=='director') Diriktor @elseif($user->role=='manager') Meneger @elseif($user->role=='teacher') O'qituvchi @else Hodim @endif
                </td>
              </tr><tr>
                <th>Holati</th>
                <td style="text-align: right"> @if($user->is_active) Aktiv @else Bloklangan @endif </td>
              </tr><tr>
                <th>Telefon raqam</th>
                <td style="text-align: right"> {{ $user->phone }} </td>
              </tr><tr>
                <th>Qo'shimcha telefon</th>
                <td style="text-align: right"> {{ $user->phone_alt }} </td>
              </tr><tr>
                <th>Tug'ilgan kuni</th>
                <td style="text-align: right"> {{ $user->birth_date->format('Y-m-d') }} </td>
              </tr><tr>
                <th>Ishga oldi</th>
                <td style="text-align: right"> {{ $user->creator->name }} </td>
              </tr><tr>
                <th>Ishga olindi</th>
                <td style="text-align: right"> {{ $user->created_at }} </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="{{ $user->role=='teacher' ? 'col-lg-6':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Taxrirlash</h5>
            <form action="{{ route('emploes_update') }}" method="post">
              @csrf 
              <input type="hidden" name="user_id" value="{{ $user['id'] }}">
              <label for="name" class="mb-2">FIO</label>
              <input type="text" name="name" value="{{ $user['name'] }}" class="form-control" required>              
              <div class="row">
                <div class="col-6">
                  <label for="birth_date" class="my-2">Tug'ilgan kuni</label>
                  <input type="date" name="birth_date"  value="{{ $user['birth_date']->format('Y-m-d') }}" class="form-control" required>
                </div>
                <div class="col-6">
                  <label for="role" class="my-2">Lavozim</label>
                  <select name="role" class="form-select">
                    <option value="director" {{ $user->role == 'director' ? 'selected':'' }}>Director</option>
                    <option value="teacher" {{ $user->role == 'teacher' ? 'selected':'' }}>O'qituvchi</option>
                    <option value="manager" {{ $user->role == 'manager' ? 'selected':'' }}>Manager</option>
                    <option value="operator" {{ $user->role == 'operator' ? 'selected':'' }}>Operator</option>
                    <option value="hodim" {{ $user->role == 'hodim' ? 'selected':'' }}>Hodim</option>
                  </select>
                </div>
                <div class="col-6">
                  <label for="phone" class="my-2">Telefon raqam</label>
                  <input type="text" name="phone" class="form-control phone" value="{{ $user['phone'] }}" required>
                </div>
                <div class="col-6">
                  <label for="phone_alt" class="my-2">Qo'shimcha telefon</label>
                  <input type="text" name="phone_alt" class="form-control phone" value="{{ $user['phone_alt'] }}" required>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary w-100 mt-3">O'zgarishlarni saqlash</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <div class="{{ $user->role=='teacher' ? 'd-none':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ish haqi to'lovi</h5>
            <form action="#" method="post">
              @csrf 
              <label for="name" class="mb-2">To'lov summasi</label>
              <input type="text" name="" required class="form-control" id="amount">
              <label for="name" class="my-2">To'lov turi</label>
              <select name="" required class="form-control">
                <option value="">Tanlang</option>
                <option value="cash">Naqt</option>
                <option value="card">Karta</option>
              </select>
              <label for="name" class="my-2">To'lov haqida</label>
              <input type="text" name="" required class="form-control">
              <button type="submit" class="btn btn-primary w-100 mt-3">To'lov</button>
            </form>
          </div>
        </div>
      </div>  
      @if($user->role=='teacher')    
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Guruhlar</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;height:500px">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Guruh</th>
                    <th>To'lov summasi</th>
                    <th>To'lov vaqti</th>
                    <th>To'lov haqida</th>
                    <th>Direktor</th>
                    <th>To'lov vaqti</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ish haqi to'lovlari</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;height:500px">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Guruh</th>
                    <th>To'lov summasi</th>
                    <th>To'lov vaqti</th>
                    <th>To'lov haqida</th>
                    <th>Direktor</th>
                    <th>To'lov vaqti</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection