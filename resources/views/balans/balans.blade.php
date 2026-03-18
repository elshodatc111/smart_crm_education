@extends('layouts.admin')
@section('title', 'Moliya')
@section('content')
  <div class="pagetitle">
    <h1>Moliya</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Moliya</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-primary"></i> Balansda mavjud
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-primary"></i> Naqt: <b>{{ number_format($balans['cash'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-primary"></i> Plastik: <b>{{ number_format($balans['card'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#balansdanXarajat">
                <i class="bi bi-cash-coin me-1"></i> Balansdan chiqim
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-info"></i> Mavjud ish haqi
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-info"></i> Naqt: <b>{{ number_format($balans['cash_salary'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-info"></i> Plastik: <b>{{ number_format($balans['card_salary'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-info w-100 mt-3" data-bs-toggle="modal" data-bs-target="#almashtirish">
                <i class="bi bi-arrow-left-right me-1"></i> Almashtirish
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">            
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-warning"></i> Balansda mavjud Exson
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-warning"></i> Naqt: <b>{{ number_format($balans['cash_exson'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-warning"></i> Plastik: <b>{{ number_format($balans['card_exson'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#exsonChiqim">
                <i class="bi bi-gift me-1"></i> Exson uchun chiqim
            </button>
          </div>
        </div>
      </div>      
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Balans tarixi (oxirgi 45 kun)</h5>
            <div class="table-responsive notes-wrapper" style="font-size:14px;max-height: 400px; overflow-y: auto; overflow-x: hidden;height:400px">
              <table class="table table-bordered">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Chiqim turi</th>
                    <th>Chiqim summasi</th>
                    <th>Chiqim haqida</th>
                    <th>Meneger</th>
                    <th>Chiqim vaqti</th>
                    <th>Tasdiqladi</th>
                    <th>Tasdiqlash vaqti</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($history45 as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td class="text-center">{{ $item['type'] }}</td>
                      <td class="text-center">{{ number_format($item['amount'], 0, '.', ' ') }} UZS</td>
                      <td class="text-center">{{ $item['description'] }}</td>
                      <td class="text-center">{{ $item->user->name }}</td>
                      <td class="text-center">{{ $item['created_at'] }}</td>
                      <td class="text-center">{{ $item->admin->name }}</td>
                      <td class="text-center">{{ $item['updated_at'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="8">Balans tarixi mavjud emas</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="modal" id="balansdanXarajat" tabindex="-1">
  <form action="{{ route('balans_chiqim') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Balansdan chiqim</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="category" class="mb-2">Chiqim turi</label>
          <select name="category" required class="form-select">
            <option value="xarajat">Xarajat</option>
            <option value="daromad">Daromad</option>
          </select>
          <label for="amount" class="my-2">Chiqim Summasi</label>
          <input type="text" name="amount" class="form-control" id="amount" required>
          <label for="payment_type" class="my-2">To'lov turi</label>
          <select name="payment_type" required class="form-select">
            <option value="">Tanlang...</option>
            <option value="cash">Naqt</option>
            <option value="card">Karta</option>
          </select>
          <label for="description" class="my-2">Chiqim haqida</label>
          <input type="text" name="description" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Chiqimni saqlash</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal" id="almashtirish" tabindex="-1">
  <form action="{{ route('balans_convert') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Almashtirish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="transfer_type" class="mb-2">Almastirish turini tanlang</label>
          <select name="transfer_type" required class="form-control">
            <option value="">Tanlang</option>
            <option value="balans_to_ishhaqi">Balansdan ish haqiga o'tqazish</option>
            <option value="ishhaqi_to_balans">Ish haqidan balansga o'tqazish</option>
          </select>
          <label for="amount" class="my-2">Almashinish summasi</label>
          <input type="text" name="amount" class="form-control" id="amount1" required>
          <label for="payment_type" class="my-2">To'lov turini tanlang</label>
          <select name="payment_type" required class="form-control">
            <option value="">Tanlang...</option>
            <option value="cash">Naqt</option>
            <option value="card">Karta</option>
          </select>
          <label for="description" class="my-2">Almashtirish haqida</label>
          <input type="text" name="description" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Almashtirish</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal" id="exsonChiqim" tabindex="-1">
  <form action="{{ route('balans_exson') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Exson uchun chiqim</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="amount" class="mb-2">Exson summasi</label>
          <input type="text" name="amount" class="form-control" id="amount2" required>
          <label for="payment_type" class="my-2">To'lov turini tanlang</label>
          <select name="payment_type" required class="form-control">
            <option value="">Tanlang...</option>
            <option value="cash">Naqt</option>
            <option value="card">Karta</option>
          </select>
          <label for="description" class="my-2">Exson haqida haqida</label>
          <input type="text" name="description" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Chiqimni saqlash</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection