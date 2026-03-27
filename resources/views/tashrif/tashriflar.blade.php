@extends('layouts.admin')
@section('title', 'Tashriflar')
@section('content')
  <div class="pagetitle">
    <h1>Tashriflar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tashriflar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <div class="row mb-3 mt-4">
          <div class="col-md-4">
            <form action="{{ route('tashriflar') }}" method="GET" id="searchForm">
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="FIO yoki telefon..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Qidirish</button>
              </div>
            </form>
          </div>
          <div class="col-md-8" style="text-align: right">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#parol_yangilash">Yangi tashrif</button>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered" style="font-size:14px;">
            <thead>
              <tr class="text-center table-light">
                <th>#</th>
                <th>FIO</th>
                <th>Telefon raqam</th>
                <th>Balans</th>
                <th>Manzil</th>
                <th>Ro'yhatga olindi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $item)
                <tr>
                  <td class="text-center">{{ ($users->currentPage()-1) * $users->perPage() + $loop->iteration }}</td>
                  <td><a href="{{ route('tashrif_show', $item->id) }}">{{ $item->name }}</a></td>
                  <td class="text-center">{{ $item->phone }}</td>
                  @if($item->balance>=0)
                    <td class="text-center text-primary">
                      <strong>{{ number_format($item->balance, 0, '.', ' ') }} UZS</strong>
                    </td>
                  @else
                    <td class="text-center text-danger">
                      <strong>{{ number_format($item->balance, 0, '.', ' ') }} UZS</strong>
                    </td>
                  @endif
                  <td class="text-center">
                    @if($item->address=='10401')
                      Qarshi shaxar
                    @elseif($item->address=='10242')
                      Chiroqchi tumani
                    @elseif($item->address=='10212')
                      Dexqonobod tumani
                    @elseif($item->address=='10207')
                      G'uzor tumani
                    @elseif($item->address=='10220')
                      Qamashi tumani
                    @elseif($item->address=='10224')
                      Qarshi tumani
                    @elseif($item->address=='10229')
                      Koson tumani
                    @elseif($item->address=='10232')
                      Kitob tumani
                    @elseif($item->address=='10233')
                      Mirishkor tumani
                    @elseif($item->address=='10234')
                      Muborak tumani
                    @elseif($item->address=='10235')
                      Nishon tumani
                    @elseif($item->address=='10237')
                      Kasbi tumani
                    @elseif($item->address=='10240')
                      Ko'kdala tumani
                    @elseif($item->address=='10245')
                      Shaxrisabz tumani
                    @elseif($item->address=='10246')
                      Shaxrisabz shaxar
                    @elseif($item->address=='10250')
                      Yakkabog' tumani
                    @else
                      Boshqa viloyat
                    @endif
                  </td>
                  <td class="text-center">
                    {{ $item->created_at->format("Y-m-d h:i") }}
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="text-center">Ma'lumot topilmadi.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $users->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  </section>
<style>
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    /* Mobil qurilmalarda juda ko'p raqam ko'rinishini oldini olish */
    @media (max-width: 576px) {
        .pagination .page-item:not(.active):not(.disabled):not(:first-child):not(:last-child):not(:nth-last-child(2)):not(:nth-child(2)) {
            display: none;
        }
    }
</style>

<script>
    let timer;
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500); // 0.8 soniya kutib keyin yuboradi
    });
</script>

<div class="modal" id="parol_yangilash" tabindex="-1">
  <form action="{{ route('visits_store') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Yangi tashrif</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="name" class="mb-2">FIO</label>
          <input type="text" name="name" required class="form-control">
          <label for="phone" class="my-2">Telefon raqam</label>
          <input type="text" name="phone" required class="form-control phone" value="+998">
          <label for="phone_alt" class="my-2">O'qshimcha telefon raqam</label>
          <input type="text" name="phone_alt" required class="form-control phone" value="+998">
          <label for="birth_date" class="my-2">Tugilgan kuni</label>
          <input type="date" name="birth_date" required class="form-control">
          <label for="address" class="my-2">Yashash hududi</label>
          <select name="address" required class="form-select">
            <option value="">Tanlang...</option>
            <option value="10401">Qarshi shaxar</option>
            <option value="10224">Qarshi tumani</option>
            <option value="10229">Koson tumani</option>
            <option value="10207">G'uzir tumani</option>
            <option value="10235">Nishon tumani</option>
            <option value="10233">Mirishkor tumani</option>
            <option value="10234">Muborak tumani</option>
            <option value="10237">Kasbi tumani</option>
            <option value="10240">Ko'kdala tumani</option>
            <option value="10242">Chiroqchi tumani</option>
            <option value="10220">Qamashi tumani</option>
            <option value="10245">Shaxrisabz tumani</option>
            <option value="10232">Kitob tumani</option>
            <option value="10250">Yakkabog' tumani</option>
            <option value="10212">Dexqonobot tumani</option>
            <option value="10246">Shaxrisabz shaxar</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Tashrifni saqlash</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection