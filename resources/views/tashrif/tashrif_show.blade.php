@extends('layouts.admin')
@section('title', 'Tashrif haqida')
@section('content')
  <div class="pagetitle">
    <h1>Tashrif haqida</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tashriflar') }}">Tashriflar</a></li>
        <li class="breadcrumb-item active">Tashrif haqida</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <div class="col-12 mb-2 d-flex flex-wrap gap-2">
        <button class="btn btn-success my-2"> <i class="bi bi-cash-coin"></i> TO'LOV QILISH </button>
        <button class="btn btn-primary my-2"> <i class="bi bi-percent"></i> CHEGIRMALI TO'LOV </button>
        @if(auth()->user()->role=='admin' || auth()->user()->role=='director')
          <button class="btn btn-warning text-dark my-2"> <i class="bi bi-tag"></i> CHEGIRMA </button>
        @endif
        @if($user['balance']>=0 || auth()->user()->role=='admin' || auth()->user()->role=='director')
        <button class="btn btn-info text-dark my-2" data-bs-toggle="modal" data-bs-target="#new_group"> <i class="bi bi-people"></i> GURUHGA QO'SHISH </button>
        @endif
        <button class="btn btn-outline-secondary my-2" data-bs-toggle="modal" data-bs-target="#user_update"> <i class="bi bi-pencil-square"></i> TAXRIRLASH </button>
        <form action="{{ route('users_reset_password') }}" method="post" onsubmit="return confirm('Haqiqatan ham bu talabani paroli yangilansinmi?')">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <button class="btn btn-outline-warning my-2"> <i class="bi bi-shield-lock"></i> PAROL YANGILASH </button>
        </form>
        @if($user['is_active'])
        <form action="{{ route('users_status') }}" method="post" onsubmit="return confirm('Haqiqatan ham bu talabani bloklamoqchimisiz?')">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <button class="btn btn-outline-danger my-2"> <i class="bi bi-person-x-fill"></i> BLOKLASH </button>
        </form>
        @else
        <form action="{{ route('users_status') }}" method="post" onsubmit="return confirm('Haqiqatan ham bu talabani aktivlashtirmoqchimisiz?')">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <button class="btn btn-outline-success my-2"> <i class="bi bi-person-check-fill"></i> AKTIVLASHTIRISH </button>
        </form>
        @endif
        @if(auth()->user()->role=='admin' || auth()->user()->role=='director')
        <form action="" method="post" onsubmit="return confirm('Haqiqatan ham bu talabani o\'chirmoqchimisiz?')">
          @csrf
          <button class="btn btn-danger my-2"> <i class="bi bi-trash"></i> O'CHIRISH </button>
        </form>
        @endif
      </div>
      <div class="col-lg-4">
        <div class="card notes-wrapper" style="max-height: 330px; overflow-y: auto; overflow-x: hidden;height:330px">
          <div class="card-body">
            <h5 class="card-title w-100">
              <div class="row">
                <div class="col-6">
                  {{ $user['name'] }}
                </div>
                <div class="col-6" style="text-align: right">
                  @if($user['balance']>0)
                    <b class="p-0 m-0 text-success">{{ number_format($user['balance'], 0, '.', ' ') }}</b>
                  @elseif($user['balance']==0)
                    <b class="p-0 m-0">{{ number_format($user['balance'], 0, '.', ' ') }}</b>
                  @else
                    <b class="p-0 m-0 text-danger">{{ number_format($user['balance'], 0, '.', ' ') }}</b>
                  @endif UZS
                </div>
              </div>
            </h5>
            <table class="table table-hover" style="font-size: 14px;">
              <tr>
                <td>Telefon raqam</td>
                <td style="text-align: right">{{ '+998 ' . substr($user['phone'], 4, 2) . ' ' . substr($user['phone'], 6, 3) . ' ' . substr($user['phone'], 9, 4) }}</td>
              </tr>
              <tr>
                <td>Qo'shimcha telefon</td>
                <td style="text-align: right">{{ '+998 ' . substr($user['phone_alt'], 4, 2) . ' ' . substr($user['phone_alt'], 6, 3) . ' ' . substr($user['phone_alt'], 9, 4) }}</td>
              </tr>
              <tr>
                <td>Tug'ilgan kuni</td>
                <td style="text-align: right">{{ \Carbon\Carbon::parse($user['birth_date'])->format('Y-m-d') }}</td>
              </tr>
              <tr>
                <td>Yashash hududi</td>
                <td style="text-align: right">{{ $user['address'] }}</td>
              </tr>
              <tr>
                <td>Ro'yhatga olindi</td>
                <td style="text-align: right">{{ \Carbon\Carbon::parse($user['created_at'])->format('Y-m-d h:i') }}</td>
              </tr>
              <tr>
                <td>Ro'yhatga oldi</td>
                <td style="text-align: right">{{ $user->name }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eslatmalar</h5>
            <div class="table-responsive notes-wrapper" style="max-height: 250px; overflow-y: auto; overflow-x: hidden;height:250px">
              <table class="table table-bordered" style="font-size: 12px;">
                <thead>
                  <tr class="text-center">
                    <th>Eslatma matni</th>
                    <th>Eslatma vaqti</th>
                    <th>Menejer</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($notes as $item)
                    <tr>
                      <td>{{ $item['text'] }}</td>
                      <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('Y-m-d h:i') }}</td>
                      <td>{{ $item->user->name }}</td>
                    </tr>  
                  @empty
                    <tr>
                      <td class="text-center" colspan="3">
                        Eslatmalar mavjud emas
                      </td>
                    </tr>
                  @endforelse                  
                </tbody>
              </table>
            </div>
            <form action="{{ route('notes_store') }}" method="post" class="d-flex gap-2">
              @csrf
              <input type="hidden" name="note_id" value="{{ $user['id'] }}">
              <input type="hidden" name="type" value="user">
              <input type="text" name="text" class="form-control" placeholder="Eslatma matni" required>
              <button class="btn btn-primary">
                <i class="bi bi-send"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card notes-wrapper" style="max-height: 330px; overflow-y: auto; overflow-x: hidden;height:330px">
          <div class="card-body">
            <h5 class="card-title">Talaba tarixi</h5>
            <table class="table table-bordered" style="font-size: 14px;">
                <thead>
                  <tr class="text-center">
                    <th>#</th>
                    <th>Hodisa vaqti</th>
                    <th>Hodisa turi</th>
                    <th>Hodisa haqida</th>
                    <th>Meneger</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($history as $item)
                    <tr>
                      <td class="text-center">{{ $loop->index+1 }}</td>
                      <td>
                        @if($item['type'] == 'visit')
                          <b class="text-primary">Tashrif</b>
                        @elseif($item['type'] == 'visit')
                          <b class="text-primary">Tashrif</b>
                        @elseif($item['type'] == 'payment_cash')
                          <b class="text-success">Naqt tolov</b>
                        @elseif($item['type'] == 'payment_card')
                          <b class="text-success">Karta to'lov</b>
                        @elseif($item['type'] == 'payment_return')
                          <b class="text-danger">To'lov qaytarildi</b>
                        @elseif($item['type'] == 'discont')
                          <b class="text-warning">Chegirma</b>
                        @elseif($item['type'] == 'jarima')
                          <b class="text-danger">Jarima</b>
                        @elseif($item['type'] == 'group_add')
                          <b class="text-info">Guruhga qo'shildi</b>
                        @elseif($item['type'] == 'group_delete')
                          <b class="text-danger">Guruhdan o'chirildi</b>
                        @elseif($item['type'] == 'resset_password')
                          <b class="text-warning">Parol yangilandi</b>
                        @elseif($item['type'] == 'update')
                          <b class="text-info">Yangilandi</b>
                        @elseif($item['type'] == 'status_of')
                          <b class="text-danger">Bloklandi</b>
                        @elseif($item['type'] == 'status_on')
                          <b class="text-success">Aktivlashtirildi</b>
                        @endif
                      </td>
                      <td>{{ $item['description'] }}</td>
                      <td class="text-center">{{ $item->creator->name }}</td>
                      <td class="text-center">{{ $item['created_at'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center">Tashrif tarixi mavjud emas.</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
        <div class="card notes-wrapper" style="max-height: 372px; overflow-y: auto; overflow-x: hidden;height:372px">
          <div class="card-body">
            <h5 class="card-title">Guruhlar tarixi</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card notes-wrapper" style="max-height: 330px; overflow-y: auto; overflow-x: hidden;height:330px">
          <div class="card-body">
            <h5 class="card-title">To'lovlar tarixi</h5>
            <p>Siz tizimga muvaffaqiyatli kirdingiz. Bu yerda sizning asosiy statistikalaringiz ko'rinadi.</p>
          </div>
        </div>
      </div>
    </div>
  </section>


<button data-bs-toggle="modal" data-bs-target="#parol_yangilash">sasa</button>
<div class="modal" id="parol_yangilash" tabindex="-1">
  <form action="#" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Yangilash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          sasa
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal" id="new_group" tabindex="-1">
  <form action="{{ route('add_user_group') }}" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Yangi guruhga qo'shish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" value="{{ $user['id'] }}">
          <label for="group_id" class="mb-2">Guruhni tanlang</label>
          <select name="group_id" class="form-select">
            <option value="">Tanlang...</option>
            @foreach ($newGroups as $item)
              <option value="{{ $item['group_id'] }}">{{ $item['group_name']." | ".$item['teacher']." | ".$item['start_lesson']." | ".$item['lesson_time'] }}</option>
            @endforeach
          </select>          
          <label for="start_comment" class="my-2">Guruhga qo'shish izohi</label>
          <textarea name="start_comment" required class="form-control">---</textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Guruhga qo'shish</button>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal" id="user_update" tabindex="-1">
  <form action="{{ route('users_update', $user['id']) }}" method="post">
    @csrf 
    @method('PUT')
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Talaba malumotlarini yangilash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="name" class="mb-2">FIO</label>
          <input type="text" name="name" value="{{ $user['name'] }}" required class="form-control">
          <label for="phone_alt" class="my-2">Qo'shimcha telefon raqam</label>
          <input type="text" name="phone_alt" value="{{ $user['phone_alt'] }}" required class="form-control phone">
          <label for="address" class="my-2">Yashash manzili</label>
          <select name="address" required class="form-select">
            <option value="">Tanlang...</option>
            <option value="10401" {{ $user['address'] == '10401' ? 'selected' : '' }}>Qarshi shaxar</option>
            <option value="10224" {{ $user['address'] == '10224' ? 'selected' : '' }}>Qarshi tumani</option>
            <option value="10229" {{ $user['address'] == '10229' ? 'selected' : '' }}>Koson tumani</option>
            <option value="10207" {{ $user['address'] == '10207' ? 'selected' : '' }}>G'uzir tumani</option>
            <option value="10235" {{ $user['address'] == '10235' ? 'selected' : '' }}>Nishon tumani</option>
            <option value="10233" {{ $user['address'] == '10233' ? 'selected' : '' }}>Mirishkor tumani</option>
            <option value="10234" {{ $user['address'] == '10234' ? 'selected' : '' }}>Muborak tumani</option>
            <option value="10237" {{ $user['address'] == '10237' ? 'selected' : '' }}>Kasbi tumani</option>
            <option value="10240" {{ $user['address'] == '10240' ? 'selected' : '' }}>Ko'kdala tumani</option>
            <option value="10242" {{ $user['address'] == '10242' ? 'selected' : '' }}>Chiroqchi tumani</option>
            <option value="10220" {{ $user['address'] == '10220' ? 'selected' : '' }}>Qamashi tumani</option>
            <option value="10245" {{ $user['address'] == '10245' ? 'selected' : '' }}>Shaxrisabz tumani</option>
            <option value="10232" {{ $user['address'] == '10232' ? 'selected' : '' }}>Kitob tumani</option>
            <option value="10250" {{ $user['address'] == '10250' ? 'selected' : '' }}>Yakkabog' tumani</option>
            <option value="10212" {{ $user['address'] == '10212' ? 'selected' : '' }}>Dexqonobot tumani</option>
            <option value="10246" {{ $user['address'] == '10246' ? 'selected' : '' }}>Shaxrisabz shaxar</option>
        </select>
          <label for="birth_date" class="my-2">Tugilgan kuni</label>
          <input type="date" name="birth_date" value="{{ \Carbon\Carbon::parse($user['birth_date'])->format('Y-m-d') }}" required class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" class="btn btn-primary">Yangilash</button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection