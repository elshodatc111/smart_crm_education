@extends('layouts.admin')
@section('title', 'Guruhlar')
@section('content')
  <div class="pagetitle">
    <h1>Guruhlar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Guruhlar</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Guruhlar</h5>
            <div class="table-responsive notes-wrapper" style="font-size:14px;max-height: 592px; overflow-y: auto; overflow-x: hidden;height:592px">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Guruh</th>
                    <th>O'qituvchi</th>
                    <th>Boshlanish vaqti</th>
                    <th>Tugash vaqti</th>
                    <th>Darslar soni</th>
                    <th>Guruh holati</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($groups as $item)
                  <tr>
                    <td class="text-center">{{ $loop->index+1 }}</td>
                    <td><a href="{{ route('group_show',$item['id']) }}">{{ $item['group_name'] }}</a></td> 
                    <td>{{ $item['teacher'] }}</td>
                    <td class="text-center">{{ $item['start_lesson'] }}</td>
                    <td class="text-center">{{ $item['end_lesson'] }}</td>
                    <td class="text-center">{{ $item['users'] }}</td>
                    <td class="text-center">
                      @if($item['status']=='Yangi')
                        <b class="text-primary">Yangi</b>
                      @elseif($item['status']=='Jarayonda')
                        <b class="text-warning">Jarayonda</b>
                      @else
                        <b class="text-danger">Yakunlangan</b>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td class="text-center" colspan="7">Guruhlar mavjud emas</td>
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
            <h5 class="card-title">Yangi guruh qo'shish</h5>
            <form action="{{ route('group_store') }}" method="post">
              @csrf 
              <label class="mb-2">Yangi guruh nomi</label>
              <input type="text" name="group_name" value="{{ old('group_name') }}" class="form-control" required>
              <div class="row">
                <div class="col-6">
                  <label class="my-2">Kurs</label>
                  <select name="cours_id" class="form-control" required>
                      <option value="">Tanlang...</option>
                      @foreach ($form['cours'] as $item)
                          <option value="{{ $item['id'] }}"
                              {{ old('cours_id') == $item['id'] ? 'selected' : '' }}>
                              {{ $item['cours_name'] }}
                          </option>
                      @endforeach
                  </select>
                </div>
                <div class="col-6">
                  <label class="my-2">Darslar soni</label>
                  <input type="number" name="lesson_count" min="1" value="{{ old('lesson_count', 12) }}" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="my-2">Dars xonasi</label>
                    <select name="room_id" class="form-control" required>
                        <option value="">Tanlang...</option>
                        @foreach ($form['rooms'] as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('room_id') == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="my-2">Boshlanishi</label>
                    <input type="date" name="start_lesson" value="{{ old('start_lesson') }}" min="{{ date('Y-m-d') }}" class="form-control" required>
                </div>
                <div class="col-6">
                  <label class="my-2">Dars kunlari</label>
                  <select name="group_type" class="form-control" required>
                    <option value="">Tanlang...</option>
                    <option value="toq" {{ old('group_type')=='toq'?'selected':'' }}>Toq kunlar</option>
                    <option value="juft" {{ old('group_type')=='juft'?'selected':'' }}>Juft kunlar</option>
                    <option value="all" {{ old('group_type')=='all'?'selected':'' }}>Har kuni</option>
                  </select>
                </div>
                <div class="col-6">
                  <label class="my-2">Dars vaqti</label>
                  <select name="lesson_time" class="form-select" required>
                    <option value="">Tanlang...</option>
                    <option value="08:00 - 09:30">08:00 - 09:30</option>
                    <option value="09:30 - 11:00">09:30 - 11:00</option>
                    <option value="11:00 - 12:30">11:00 - 12:30</option>
                    <option value="12:30 - 14:00">12:30 - 14:00</option>
                    <option value="14:00 - 15:30">14:00 - 15:30</option>
                    <option value="15:30 - 17:00">15:30 - 17:00</option>
                    <option value="17:00 - 18:30">17:00 - 18:30</option>
                    <option value="18:30 - 20:00">18:30 - 20:00</option>
                    <option value="20:00 - 21:30">20:00 - 21:30</option>
                  </select>
                </div>
              </div>
              <label class="my-2">To'lov summasi</label>
              <select name="payment_id" class="form-control" required>
                <option value="">Tanlang...</option>
                @foreach ($form['paymarts'] as $item)
                  <option value="{{ $item['id'] }}"
                    {{ old('payment_id')==$item['id']?'selected':'' }}>
                    To'lov: {{ number_format($item['payment'],0,'.',' ') }} UZS,
                    Chegirma: {{ number_format($item['discount'],0,'.',' ') }} UZS,
                    Muddat: {{ $item['discount_day'] }} kun
                  </option>
                @endforeach
              </select>
              <label class="my-2">Guruh o'qituvchisi</label>
              <select name="teacher_id" class="form-control" required>
                <option value="">Tanlang...</option>
                @foreach ($form['teachers'] as $item)
                  <option value="{{ $item['id'] }}"
                    {{ old('teacher_id')==$item['id']?'selected':'' }}>
                    {{ $item['name'] }}
                  </option>
                @endforeach
              </select>
              <div class="row">
                <div class="col-6">
                  <label class="my-2">O'qituvchi(to'lov)</label>
                  <input type="text" name="teacher_pay" value="{{ old('teacher_pay') }}" class="form-control" id='amount' required>
                </div>
                <div class="col-6">
                  <label class="my-2">O'qituvchi(bonus)</label>
                  <input type="text" name="teacher_bonus" value="{{ old('teacher_bonus') }}" class="form-control" id='amount1' required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100 mt-3">Guruhni saqlash</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection