@extends('layouts.admin')
@section('title', 'Kassa')
@section('content')
  <div class="pagetitle">
    <h1>Kassa</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kassa</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 225px; overflow-y: auto; overflow-x: hidden;height:225px">
          <div class="card-body">
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-success"></i> Kassada mavjud summa
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-success"></i> Naqt: <b>{{ number_format($kassa['cash'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-success"></i> Plastik: <b>{{ number_format($kassa['card'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-danger w-100 mt-3" data-bs-toggle="modal" data-bs-target="#refundModal">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Qaytarilgan to'lovlar
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 225px; overflow-y: auto; overflow-x: hidden;height:225px">
          <div class="card-body">
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-warning"></i> Tasdiqlanmagan chiqimlar
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-warning"></i> Naqt: <b>{{ number_format($kassa['output_cash_pending'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-warning"></i> Plastik: <b>{{ number_format($kassa['output_card_pending'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#kassadanChiqim">
                <i class="bi bi-box-arrow-right me-1"></i> Kassadan chiqim
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 225px; overflow-y: auto; overflow-x: hidden;height:225px">
          <div class="card-body">
            <h3 class="card-title text-center w-100">
                <i class="bi bi-cash-coin me-1 text-danger"></i> Tasdiqlanmagan xarajatlar
            </h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <i class="bi bi-cash-stack me-1 text-danger"></i> Naqt: <b>{{ number_format($kassa['cost_cash_pending'], 0, '.', ' ') }}</b> UZS
                </li>
                <li class="list-group-item">
                    <i class="bi bi-credit-card-2-front me-1 text-danger"></i> Plastik: <b>{{ number_format($kassa['cost_card_pending'], 0, '.', ' ') }}</b> UZS
                </li>
            </ul>
            <button class="btn btn-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#kassadanXarajat">
                <i class="bi bi-box-arrow-right me-1"></i> Kassadan xarajat
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tasdiqlanmaxan xarajat va chiqimlar</h5>
            <div class="table-responsive notes-wrapper" style="font-size:14px;max-height: 300px; overflow-y: auto; overflow-x: hidden;height:300px">
              <table class="table table-bordered">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Chiqim summasi</th>
                    <th>Chiqim turi</th>
                    <th>Chiqim haqida</th>
                    <th>Meneger</th>
                    <th>Chiqim vaqti</th>
                    <th>Tasdiqlash</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($history as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>{{ number_format($item['amount'], 0, '.', ' ') }} UZS</td>
                      <td class="text-center">
                        @if($item->type=='output_cash')
                        <b class='text-primary m-0 p-0'>Naqt chiqim</b>
                        @elseif($item->type=='output_card')
                        <b class='text-primary m-0 p-0'>Karta chiqim</b>
                        @elseif($item->type=='cost_cash')
                        <b class='text-warning m-0 p-0'>Naqt xarajat</b>
                        @elseif($item->type=='cost_card')
                        <b class='text-warning m-0 p-0'>Karta xarajat</b>
                        @endif
                      </td>
                      <td>{{ $item->description }}</td>
                      <td class="text-center">{{ $item->created_at }}</td>
                      <td class="text-center">{{ $item->meneger->name }}</td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <form action="{{ route('kassa_history_approve', $item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu chiqimni tasdiqlamoqchimisiz?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Tasdiqlash">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form action="{{ route('kassa_history_cancel', $item->id) }}" method="POST" onsubmit="return confirm('Haqiqatan ham bu chiqimni o\'chirmoqchimisiz?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Bekor qilish">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="text-center" colspan="7">
                        Chiqimlar mavjud emas
                      </td>
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


<div class="modal" id="kassadanChiqim" tabindex="-1">
  <form action="{{ route('kassa_chiqim') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kassadan chiqim</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" style="font-size:12px;">
            <tr class="text-center">
              <th>Mavjud Naqt</th>
              <th>Mavjud Karta</th>
            </tr>
            <tr class="text-center">
              <td>{{ number_format($kassa['cash'], 0, '.', ' ') }}</td>
              <td>{{ number_format($kassa['card'], 0, '.', ' ') }}</td>
            </tr>
          </table>
          <hr>
          <label for="amount">Chiqim summasi</label>
          <input type="text" name="amount" required class="form-control my-2" id="amount">
          <label for="">Chiqim turi</label>
          <select name="type" required class="form-control my-2">
            <option value="">Tanlang...</option>
            <option value="output_cash">Naqt</option>
            <option value="output_card">Karta</option>
          </select>
          <label for="description">Chiqim haqida</label>
          <input type="text" name="description" required class="form-control my-2">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Chiqim tasdilqash</button>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal" id="kassadanXarajat" tabindex="-1">
  <form action="{{ route('kassa_chiqim') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kassadan xarajat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" style="font-size:12px;">
            <tr class="text-center">
              <th>Mavjud Naqt</th>
              <th>Mavjud Karta</th>
            </tr>
            <tr class="text-center">
              <td>{{ number_format($kassa['cash'], 0, '.', ' ') }}</td>
              <td>{{ number_format($kassa['card'], 0, '.', ' ') }}</td>
            </tr>
          </table>
          <hr>
          <label for="amount">Xarajat summasi</label>
          <input type="text" name="amount" required class="form-control my-2" id="amount1">
          <label for="type">Xarajat turi</label>
          <select name="type" required class="form-control my-2">
            <option value="">Tanlang...</option>
            <option value="cost_cash">Naqt</option>
            <option value="cost_card">Karta</option>
          </select>
          <label for="description">Xarajat haqida</label>
          <input type="text" name="description" required class="form-control my-2">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Xarajat chiqim qilish</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection