@extends('layouts.admin')
@section('title', 'Dam olish kunlari')
@section('content')
  <div class="pagetitle">
    <h1>Dam olish kunlari</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Dam olish kunlari</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Dam olish kunlari</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;height:500px">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Dam olish kuni</th>
                    <th>Dam olish kuni haqida</th>
                    <th>Dam olish kuni saqlandi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($dam_olish_kunlar as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td class="text-center">{{ \Carbon\Carbon::parse($item['data'])->format('Y-m-d') }}</td>
                      <td>{{ $item['title'] }}</td>
                      <td class="text-center">{{ $item['created_at'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Dam olish kunlari mavjud emas.</td>
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
            <h5 class="card-title">Yangi dam olish kuni</h5>
            <form action="{{ route('setting_dam_olish_store') }}" method="post">
              @csrf 
              <label for="data" class="mb-2">Dam olish kuni</label>
              <input type="date" name="data" class="form-control" required>
              <label for="title" class="my-2">Dam olish uni haqida</label>
              <input type="text" name="title" required class="form-control">
              <button class="btn btn-primary w-100 mt-3" type="submit">Saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection