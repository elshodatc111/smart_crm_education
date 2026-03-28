@extends('layouts.admin')
@section('title', 'Tug\'ilgan kunlar')
@section('content')
  <div class="pagetitle">
    <h1>Tug'ilgan kunlar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Tug'ilgan kunlar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Bugungi tug'ilgan kunlar</h5>
        <table class="table table-bordered" style="font-size: 14px;">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>FIO</th>
              <th>Lavozim</th>
              <th>Status</th>
              <th>Telefon raqam</th>
              <th>Tug'ilgan kuni</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $item)
              <tr>
                <td class="text-center">{{ $loop->index+1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->role }}</td>
                <td class="text-center">
                  @if($item->is_active)
                    Aktiv
                  @else
                    NoAktiv
                  @endif
                </td>
                <td class="text-center">{{ $item->phone }}</td>
                <td class="text-center">{{ $item->birth_date->format('Y-m-d') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Tug'ilgan kunlar mavjud emas.</td>
              </tr>
            @endforelse
            
          </tbody>
        </table>
      </div>
    </div>
  </section>

@endsection