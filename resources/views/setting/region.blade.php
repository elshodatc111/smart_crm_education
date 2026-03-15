@extends('layouts.admin')
@section('title', 'Hududlar | SMS')
@section('content')
  <div class="pagetitle">
    <h1>Hududlar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Hududlar | SMS</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Mavjud hududlar</h5>
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
                  @forelse($regions as $item)
                  <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $item->region_code }}</td>
                    <td>{{ $item->region_name }}</td>
                    <td>{{ $item->creator?->name ?? '—' }}</td>
                    <td class="text-center">{{ $item->created_at?->format('d.m.Y H:i') }}</td>
                    <td class="text-center">
                      <form action="{{ route('regions_destroy',$item->id) }}" method="POST" onsubmit="return confirm('Hududni o‘chirishni tasdiqlaysizmi?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm py-0 px-1"><i class="bi bi-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center">Hududlar mavjud emas</td>
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
            <h5 class="card-title">Yangi hudud qo'shish</h5>
            <form action="{{ route('setting_region_create') }}" method="post">
              @csrf 
              <label for="region_code" class="mb-2">Hudud kodi</label>
              <input type="text" name="region_code" class="form-control region_code" required>
              <label for="region_name" class="my-2">Hudud nomi</label>
              <input type="text" name="region_name" class="form-control" required>
              <button type="submit" class="btn btn-primary mt-3 w-100">Hududni saqlash</button>
            </form>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">SMS sozlamalari</h5>
            <form action="{{ route('sms_settings_update') }}" method="POST">
              @csrf
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="visit_sms"
                {{ $setting->visit_sms ? 'checked' : '' }}>
                <label>Yangi qo'shilgan tashrifga yoki yangi hodimga sms yuborish</label>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="payment_sms"
                {{ $setting->payment_sms ? 'checked' : '' }}>
                <label>Ish haqi to'lovi yoki mijozlar to'lovi kiritilganda yuboriladigan sms</label>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="password_sms"
                {{ $setting->password_sms ? 'checked' : '' }}>
                <label>Parol yangilanganda yuboriladigan sms</label>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="birthday_sms"
                {{ $setting->birthday_sms ? 'checked' : '' }}>
                <label>Tug'ilgan kunlar uchun yuboriladigan smslar</label>
              </div>
              <button class="btn btn-primary w-100">Saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection