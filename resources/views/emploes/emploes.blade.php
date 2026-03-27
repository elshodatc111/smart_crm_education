@extends('layouts.admin')
@section('title', 'Hodimlar')
@section('content')
  <div class="pagetitle">
    <h1>Hodimlar</h1>
    <div class="row">
      <div class="col-lg-6">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Hodimlar</li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6" style="text-align: right">
        <button data-bs-toggle="modal" data-bs-target="#newEmploes" class="btn btn-primary">Yangi hodim qo'shish</button>
      </div>
    </div>
  </div>
  
  <section class="section dashboard">
    <div class="card notes-wrapper" style="max-height: 665px; overflow-y: auto; overflow-x: hidden;">
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
                    <b class="text-success">Aktiv</b>
                  @else
                    <b class="text-danger">Bloklangan</b>
                  @endif
                </td>
                <td class="text-center">{{ $item['created_at']->format("y-m-d h:i") }}</td>
              </tr>
              @empty

              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>


<div class="modal" id="newEmploes" tabindex="-1">
  <form action="{{ route('emploes_store') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Yangi hodim qo'shish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection