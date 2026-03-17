@extends('layouts.admin')
@section('title', 'Hodimlar')
@section('content')
  <div class="pagetitle">
    <h1>Hodimlar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Hodimlar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 665px; overflow-y: auto; overflow-x: hidden;height:665px">
          <div class="card-body">
            <h5 class="card-title">Hodimlar</h5>
            <div class="table-responsive">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>FIO</th>
                    <th>Telefon raqam</th>
                    <th>Ish haqi</th>
                    <th>Lavozim</th>
                    <th>Holati</th>
                    <th>Ishga olindi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($users as $item)
                  <tr>
                    <td class="text-center">{{ $loop->index+1 }}</td>
                    <td><a href="{{ route('emploes_show',$item['id']) }}">{{ $item['name'] }}</a></td>
                    <td class="text-center">{{ '+998 ' . substr($item['phone'], 4, 2) . ' ' . substr($item['phone'], 6, 3) . ' ' . substr($item['phone'], 9, 4) }}</td>
                    <td class="text-center">{{ number_format($item['balance'], 0, '.', ' ') }}</td>
                    <td class="text-center">
                      @if($item['role']=='director')
                        Direktor
                      @elseif($item['role']=='teacher')
                        O'qituvchi
                      @elseif($item['role']=='operator')
                        Operator
                      @elseif($item['role']=='manager')
                        Manager
                      @else
                        Hodim
                      @endif
                    </td>
                    <td class="text-center">
                      @if($item['is_active']==true)
                        Aktiv
                      @else
                        Bloklangan
                      @endif
                    </td>
                    <td class="text-center">{{ $item['created_at'] }}</td>
                  </tr>
                  @empty

                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 665px; overflow-y: auto; overflow-x: hidden;height:665px">
          <div class="card-body">
            <h5 class="card-title mb-0 pb-0">Yangi hodim qo'shish</h5>
            <form action="{{ route('emploes_store') }}" method="post">
              @csrf 
              <label for="name" class="my-2">FIO</label>
              <input type="text" name="name" required class="form-control">              
              <label for="role" class="my-2">Hodim lavozimi</label>
              <select name="role" required class="form-select">
                <option value="">Tanlang</option>
                <option value="director">Direktor</option>
                <option value="manager">Meneger</option>
                <option value="operator">Operator</option>
                <option value="teacher">O'qituvchi</option>
                <option value="hodim">Hodim</option>
              </select>
              <label for="phone" class="my-2">Telefon raqam</label>
              <input type="text" name="phone" required class="form-control phone" value="+998">
              <label for="phone_alt" class="my-2">Qo'shimcha telefon raqam</label>
              <input type="text" name="phone_alt" required class="form-control phone" value="+998">
              <label for="balance" class="my-2">Oylik ish haqi</label>
              <input type="text" name="balance" required class="form-control" id="amount">
              <label for="birth_date" class="my-2">Tug'ilgan kuni</label>
              <input type="date" name="birth_date" required class="form-control">
              <label for="address" class="my-2">Yashash manzili</label>
              <input type="text" name="address" required class="form-control">
              <button class="btn btn-primary w-100 mt-3">Hodimni ishga olish</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection