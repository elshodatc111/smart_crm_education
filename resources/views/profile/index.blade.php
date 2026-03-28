@extends('layouts.admin')
@section('title', 'Profil')
@section('content')
  <div class="pagetitle">
    <h1>Profil</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil</li>
      </ol>
    </nav>
  </div>
  <section class="section profil">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ Auth()->user()->name }}</h5>
            <table class="table table-bordered" style="font-size: 14">
              <tr>
                <th>Lavozim:</th>
                <td style="text-align: right">{{ Auth::user()->role }}</td>
              </tr>
              <tr>
                <th>Telefon raqam:</th>
                <td style="text-align: right">{{ Auth::user()->phone }}</td>
              </tr>
              <tr>
                <th>Tug'ilgan kun:</th>
                <td style="text-align: right">{{ Auth::user()->birth_date->format('Y-m-d') }}</td>
              </tr>
              <tr>
                <th>Yashash manzil:</th>
                <td style="text-align: right">{{ Auth::user()->address }}</td>
              </tr>
              <tr>
                <th>Ishga olindi:</th>
                <td style="text-align: right">{{ Auth::user()->created_at->format("Y-m-d h:i") }}</td>
              </tr>
              <tr>
                <th>Ishga oldi:</th>
                <td style="text-align: right">{{ Auth::user()->creator->name }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Parolni yangilash</h5>
            <form action="{{ route('profile_password_update') }}" method="post">
              @csrf 
              <label for="current_password" class="mb-2">Joriy parol</label>
              <input type="password" name="current_password" class="form-control" required>
              <label for="password" class="my-2">Yangi parol</label>
              <input type="password" name="password" class="form-control" required>
              <label for="password_confirmation" class="my-2">Yangi parolni takrorlang</label>
              <input type="password" name="password_confirmation" class="form-control" required>
              <button class="btn btn-primary w-100 mt-2">Parolni yangilash</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ish haqi to'lovlar</h5>
            <table class="table table-bordered" style="font-size:14px;">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Guruh</th>
                  <th>To'lov Summasi</th>
                  <th>To'lov turi</th>
                  <th>To'lov haqida</th>
                  <th>Direktor</th>
                  <th>To'lov vaqti</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($payment as $item)
                  <tr>
                    <td class="text-center">{{ $loop->index+1 }}</td>
                    <td class="text-center">
                      @if($item->group_id != null)
                        {{ $item->group->group_name }}
                      @else
                        ---
                      @endif
                    </td>
                    <td class="text-center">{{ number_format($item->amount, 0, '.', ' ') }} UZS</td>
                    <td class="text-center">
                      @if($item->payment_type=='cash')
                        Naqt
                      @else
                        Karta
                      @endif
                    </td>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">{{ $item->admin->name }}</td>
                    <td class="text-center">{{ $item->created_at->format("Y-m-d") }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center">Ish haqi to'lovlari mavjud emas.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection