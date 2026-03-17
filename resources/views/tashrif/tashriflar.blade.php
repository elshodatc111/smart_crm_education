@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <h5 class="card-title">Hush kelibsiz</h5>
          </div>
          <div class="col-6" style="text-align: right">
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#parol_yangilash">Yangi tashrif</button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size:14px;">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>FIO</th>
                <th>Telefon raqam</th>
                <th>Balans</th>
                <th>Manzil</th>
                <th>Guruhlar soni</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $item)
                <tr>
                  <td class="text-center">{{ $loop->index+1 }}</td>
                  <td><a href="{{ route('tashrif_show',$item['id'] ) }}">{{ $item['name'] }}</a></td>
                  <td class="text-center">{{ '+998 ' . substr($item['phone'], 4, 2) . ' ' . substr($item['phone'], 6, 3) . ' ' . substr($item['phone'], 9, 4) }}</td>
                  <td class="text-center">{{ number_format($item['balance'], 0, '.', ' ') }}</td>
                  <td class="text-center">{{ $item['address'] }}</td>
                  <td class="text-center">0</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">Tashriflar mavjud emas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>




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