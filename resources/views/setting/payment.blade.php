@extends('layouts.admin')
@section('title', 'To\'lov sozlamalari')
@section('content')
  <div class="pagetitle">
    <h1>To'lov sozlamalari</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">To'lov sozlamalari</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">To'lov sozlamalari</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>To'lov Summasi</th>
                        <th>Chegirma Summasi</th>
                        <th>To'lov muddati</th>
                        <th>Administrator</th>
                        <th>O'chirish</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymart_setting as $index => $item)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ number_format($item->payment, 0, '.', ' ') }}</td>
                        <td>{{ number_format($item->discount, 0, '.', ' ') }}</td>
                        <td>{{ $item->discount_day }} kun</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>
                          <form action="{{ route('payment_setting_delete', $item->id) }}" method="POST" onsubmit="return confirm('Rostdan ham o‘chirmoqchimisiz?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                          </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">To'lovlar topilmadi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 365px; overflow-y: auto; overflow-x: hidden;height:365px">
          <div class="card-body">
            <h5 class="card-title">Yangi to'lov qo'shish</h5>
            <form action="{{ route('payment_settings_store') }}" method="post">
              @csrf
              <label for="payment" class="mb-2">To'lov summasi</label>
              <input type="text" name="payment" class="form-control" id="amount" required>
              <label for="discount" class="my-2">Chegirma summasi</label>
              <input type="text" name="discount" class="form-control" id="amount1" required>
              <label for="discount_day" class="my-2">Chegirma muddati</label>
              <input type="number" name="discount_day" class="form-control" required>
              <button class="btn btn-primary w-100 mt-3">To'lovni saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection