@extends('layouts.admin')
@section('title', 'Hodimlar')
@section('content')
  <div class="pagetitle">
    <h1>Hodimlar</h1>
    <div class="row">
      <nav class="col-lg-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('emploes') }}">Hodimlar</a></li>
          <li class="breadcrumb-item active">Hodim haqida</li>
        </ol>
      </nav>
      <nav class="col-lg-6 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ish_haqi_tolash">Ish haqi to'lash</button>
        <form action="{{ route('emploes_updatePassword') }}" method="post" 
          onsubmit="return confirm('Parolni yangilamoqchimisiz?')">
          @csrf 
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <button type="submit" class="btn btn-primary">Parolni yangilash</button>
        </form>
        <form action="{{ route('emploes_toggleStatus') }}" method="post" 
          onsubmit="return confirm('{{ $user['is_active'] ? 'Foydalanuvchini bloklamoqchimisiz?' : 'Foydalanuvchini aktiv qilmoqchimisiz?' }}')">
          @csrf 
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          @if($user['is_active'])
              <button type="submit" class="btn btn-danger">Bloklash</button>
          @else
              <button type="submit" class="btn btn-success">Aktivlashtirish</button>
          @endif
        </form>
      </nav>
    </div>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="{{ $user->role=='teacher' ? 'col-lg-6':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <table class="table table-bordered" style="font-size:14px;">
              <tr><th>Lavozim</th>
                <td style="text-align: right">
                  @if($user->role=='operator') Operator @elseif($user->role=='director') Diriktor @elseif($user->role=='manager') Meneger @elseif($user->role=='teacher') O'qituvchi @else Hodim @endif
                </td>
              </tr><tr>
                <th>Holati</th>
                <td style="text-align: right"> @if($user->is_active) Aktiv @else Bloklangan @endif </td>
              </tr><tr>
                <th>Telefon raqam</th>
                <td style="text-align: right"> {{ $user->phone }} </td>
              </tr><tr>
                <th>Qo'shimcha telefon</th>
                <td style="text-align: right"> {{ $user->phone_alt }} </td>
              </tr><tr>
                <th>Tug'ilgan kuni</th>
                <td style="text-align: right"> {{ $user->birth_date->format('Y-m-d') }} </td>
              </tr><tr>
                <th>Ishga oldi</th>
                <td style="text-align: right"> {{ $user->creator->name }} </td>
              </tr><tr>
                <th>Ishga olindi</th>
                <td style="text-align: right"> {{ $user->created_at }} </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="{{ $user->role=='teacher' ? 'col-lg-6':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Taxrirlash</h5>
            <form action="{{ route('emploes_update') }}" method="post">
              @csrf 
              <input type="hidden" name="user_id" value="{{ $user['id'] }}">
              <label for="name" class="mb-2">FIO</label>
              <input type="text" name="name" value="{{ $user['name'] }}" class="form-control" required>              
              <div class="row">
                <div class="col-6">
                  <label for="birth_date" class="my-2">Tug'ilgan kuni</label>
                  <input type="date" name="birth_date"  value="{{ $user['birth_date']->format('Y-m-d') }}" class="form-control" required>
                </div>
                <div class="col-6">
                  <label for="role" class="my-2">Lavozim</label>
                  <select name="role" class="form-select">
                    <option value="director" {{ $user->role == 'director' ? 'selected':'' }}>Director</option>
                    <option value="teacher" {{ $user->role == 'teacher' ? 'selected':'' }}>O'qituvchi</option>
                    <option value="manager" {{ $user->role == 'manager' ? 'selected':'' }}>Manager</option>
                    <option value="operator" {{ $user->role == 'operator' ? 'selected':'' }}>Operator</option>
                    <option value="hodim" {{ $user->role == 'hodim' ? 'selected':'' }}>Hodim</option>
                  </select>
                </div>
                <div class="col-6">
                  <label for="phone" class="my-2">Telefon raqam</label>
                  <input type="text" name="phone" class="form-control phone" value="{{ $user['phone'] }}" required>
                </div>
                <div class="col-6">
                  <label for="phone_alt" class="my-2">Qo'shimcha telefon</label>
                  <input type="text" name="phone_alt" class="form-control phone" value="{{ $user['phone_alt'] }}" required>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary w-100 mt-3">O'zgarishlarni saqlash</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>      
      <div class="{{ $user->role=='teacher' ? 'd-none':'col-lg-4' }}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ish haqi to'lovi</h5>
            <form action="#" method="post">
              @csrf 
              <label for="name" class="mb-2">To'lov summasi</label>
              <input type="text" name="" required class="form-control" id="amount">
              <label for="name" class="my-2">To'lov turi</label>
              <select name="" required class="form-control">
                <option value="">Tanlang</option>
                <option value="cash">Naqt</option>
                <option value="card">Karta</option>
              </select>
              <label for="name" class="my-2">To'lov haqida</label>
              <input type="text" name="" required class="form-control">
              <button type="submit" class="btn btn-primary w-100 mt-3">To'lov</button>
            </form>
          </div>
        </div>
      </div>  
      @if($user->role=='teacher')  
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Guruhlar (Guruh yakunlangach 40 kundan kiyin o'chiriladi)</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Guruh</th>
                    <th>Guruh holati</th>
                    <th>Boshlanish / Tugash</th>
                    <th>Davomad/Darslar</th>
                    <th>O'qituvchiga to'lov(Talaba)</th>
                    <th>O'qituvchiga bonus(Talaba)</th>
                    <th>Ish haqi hisoblandi</th>
                    <th>Ish haqi to'landi</th>
                    <th>Qoldi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($teacherGroups as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>
                        <a href="{{ route('group_show',$item['group_id']) }}">
                          {{ $item['group_name'] }}
                        </a>
                      </td>
                      <td class="text-center">
                        @if($item['status']=='yakunlangan')
                          <b class="p-0 m-0 text-danger">Yakunlandi</b>
                        @elseif($item['status']=='jarayonda')
                          <b class="p-0 m-0 text-warning">Jarayonda</b>
                        @else
                          <b class="p-0 m-0 text-primary">Yangi</b>
                        @endif
                      </td>
                      <td class="text-center">{{ $item['start_lesson'] }} / {{ $item['end_lesson'] }}</td>
                      <td class="text-center">{{ $item['davomat_count'] }} / {{ $item['dars_count'] }}</td>
                      <td class="text-center">{{ number_format($item['teacher_pay'], 0, '.', ' ') }} UZS ({{ $item['users'] }})</td>
                      <td class="text-center">{{ number_format($item['teacher_bonus'], 0, '.', ' ') }} UZS ({{ $item['users_bonus'] }})</td>
                      <td class="text-center">{{ number_format($item['payment_hisob'], 0, '.', ' ') }} UZS</td>
                      <td class="text-center">{{ number_format($item['payment'], 0, '.', ' ') }} UZS</td>
                      <td class="text-center">{{ number_format($item['payment_qoldiq'], 0, '.', ' ') }} UZS</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="10" class="text-center">Guruhlar mavjud emas.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endif
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ish haqi to'lovlari</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
              <table class="table table-bordered" style="font-size:14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    @if($user->role=='teacher')  
                    <th>Guruh</th>
                    @endif
                    <th>To'lov summasi</th>
                    <th>To'lov haqida</th>
                    <th>Direktor</th>
                    <th>To'lov vaqti</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($paymart as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      @if($user->role=='teacher')  
                      <td>{{ $item->group->group_name }}</td>
                      @endif
                      <td class="text-center">{{  number_format($item->amount, 0, '.', ' ') }} UZS</td>
                      <td class="text-center">{{ $item->payment_type }}</td>
                      <td class="text-center">{{ $item->admin->name }}</td>
                      <td class="text-center">{{ $item->created_at->format("Y-m-d h:i") }}</td>
                    </tr>
                  @empty
                    <tr>
                      @if($user->role=='teacher')  
                      <td colspan="6" class="text-center">Ish haqi to'lovlari mavjud emas.</td>
                      @else
                      <td colspan="6" class="text-center">Ish haqi to'lovlari mavjud emas.</td>
                      @endif
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


<div class="modal" id="ish_haqi_tolash" tabindex="-1">
  <form action="{{ route('emploes_payment') }}" method="post">
    @csrf 
    <input type="hidden" name="user_id" value="{{ $user['id'] }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ish haqi to'lash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" style="font-size: 12">
            <tr>
              <td colspan="2" class="text-center">Balansda mavjud ish haqi</td>
            </tr>
            <tr class="text-center">
              <td>{{ number_format($balans['cash_salary'], 0, '.', ' ') }} UZS (Naqt)</td>
              <td>{{ number_format($balans['card_salary'], 0, '.', ' ') }} UZS (Karta)</td>
            </tr>
          </table>
          @if($user->role=='teacher')  
          <label for="group_id" class="mb-2">Guruhni tanlang</label>
          <select name="group_id" required class="form-select">
            <option value="">Tanlang ...</option>
            @foreach ($teacherGroups as $item)
              <option value="{{ $item['group_id'] }}">{{ $item['group_name'] }} | Qoldiq: {{ number_format($item['payment_qoldiq'], 0, '.', ' ') }} UZS</option>
            @endforeach
          </select>
          @else
          <input type="hidden" name="group_id">
          @endif
          <label for="amount" class="my-2">To'lov summasi</label>
          <input type="text" name="amount" class="form-control" required id="amount1">
          <label for="payment_type" class="my-2">To'lov turi</label>
          <select name="payment_type" required class="form-select">
            <option value="">Tanlang ...</option>
            <option value="cash">Naqt</option>
            <option value="card">Karta</option>
          </select>
          <label for="description" class="my-2">To'lov haqida</label>
          <input type="text" name="description" required class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Ish haqi to'lash</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection