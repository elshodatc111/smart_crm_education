@extends('layouts.admin')
@section('title', 'Guruh haqida')
@section('content')
  <div class="pagetitle">
    <h1>Guruh haqida</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('groups') }}">Guruhlar</a></li>
        <li class="breadcrumb-item active">Guruh haqida</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title w-100 text-center">{{ $group['group_name'] }}</h5>
        <div class="table-responsive notes-wrapper" style="font-size:14px;max-height: 300px; overflow-y: auto; overflow-x: hidden;height:300px">
          <div class="row">
            <div class="col-lg-4">
              <table class="table table-bordered">
                <tr>
                  <th>Kurs</th>
                  <td style="text-align: right">{{ $group->course->cours_name }}</td>
                </tr>
                <tr>
                  <th>Dars xonasi</th>
                  <td style="text-align: right">{{ $group->room->name }}</td>
                </tr>
                <tr>
                <tr>
                  <th>Darslar soni</th>
                  <td style="text-align: right">{{ $group->lesson_count }}</td>
                </tr>
                <tr>
                  <th>Dars kunlari</th>
                  <td style="text-align: right">
                    @if($group->group_type=='toq')
                      Haftaning toq kunlari
                    @elseif($group->group_type=='juft')
                      Haftaning juft kunlari
                    @else
                      Darslar har kuni
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Dars vaqti</th>
                  <td style="text-align: right">{{ $group->lesson_time }}</td>
                </tr>
                <tr>
                  <th>Dars boshlanishi vaqti</th>
                  <td style="text-align: right">{{ $group->start_lesson->format('Y-m-d') }}</td>
                </tr>
              </table>
            </div>
            <div class="col-lg-4">
              <table class="table table-bordered">
                <tr>
                  <th>Guruh narxi</th>
                  <td style="text-align: right">{{ number_format($group->payment->payment, 0, '.', ' ') }} UZS</td>
                </tr>
                <tr>
                <tr>
                  <th>Chegirma summasi</th>
                  <td style="text-align: right">{{ number_format($group->payment->discount, 0, '.', ' ') }} UZS</td>
                </tr>
                <tr>
                  <th>Chegirma muddati</th>
                  <td style="text-align: right">{{ $group->payment->discount_day }} kun</td>
                </tr>
                <tr>
                  <th>O'qituvchi</th>
                  <td style="text-align: right">{{ $group->teacher->name }}</td>
                </tr>
                <tr>
                  <th>O'qituvchiga to'lov</th>
                  <td style="text-align: right">{{ number_format($group->teacher_pay, 0, '.', ' ') }} UZS</td>
                </tr>
                <tr>
                  <th>O'qituvchiga bonus</th>
                  <td style="text-align: right">{{ number_format($group->teacher_bonus, 0, '.', ' ') }} UZS</td>
                </tr>
              </table>
            </div>
            <div class="col-lg-4">
              <table class="table table-bordered">
                <tr>
                  <th>Guruh yakunlanish vaqti</th>
                  <td style="text-align: right">{{ $group->end_lesson }}</td>
                </tr>
                <tr>
                  <th>Guruhni ochdi</th>
                  <td style="text-align: right">{{ $group->admin->name }}</td>
                </tr>
                <tr>
                  <th>Guruh ochildi</th>
                  <td style="text-align: right">{{ $group->created_at }}</td>
                </tr>
                <tr>
                  <th>Oxirgi yangilanish</th>
                  <td style="text-align: right">{{ $group->updated_at }}</td>
                </tr>
                <tr>
                  <th>Guruh davomi</th>
                  <td style="text-align: right">
                    @if($group->next_group_id)
                      <a href="{{ route('group_show',$group->nextGroup->id ) }}">{{ $group->nextGroup->group_name }}</a>
                    @else
                      Guruh davom ettirilmagan
                    @endif
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3">
              <button class="btn btn-warning w-100 mt-2 text-white" data-bs-toggle="modal" data-bs-target="#sendDebetMessage">
                <i class="bi bi-envelope me-1"></i> Qarzdorlarga SMS
              </button>
            </div>
            <div class="col-lg-3">
              <button class="btn btn-info w-100 mt-2 text-white" data-bs-toggle="modal" data-bs-target="#updateGroup">
                <i class="bi bi-pencil me-1"></i> Guruhni tahrirlash
              </button>
            </div>
            <div class="col-lg-3">
              <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#trashUser">
                <i class="bi bi-trash me-1"></i> Guruhdan o'chirish
              </button>
            </div>
            @if(!$group->next_group_id)
            <div class="col-lg-3">
              <button class="btn btn-success w-100 mt-2" data-bs-toggle="modal" data-bs-target="#nextGroup">
                <i class="bi bi-play-circle me-1"></i> Guruhni davom ettirish
              </button>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Guruhdagi talabalar tarixi</h4>
            <div class="table-responsive notes-wrapper" style="font-size:14px;max-height: 300px; overflow-y: auto; overflow-x: hidden;height:300px">
              <table class="table table-bordered table-sm" style="font-size: 14px; vertical-align: middle;">
                <thead>
                  <tr class="text-center align-middle bg-light">
                    <th rowspan="2">#</th>
                    <th rowspan="2">Talaba</th>
                    <th rowspan="2">Guruhga qo'shildi</th>
                    <th rowspan="2">Izoh</th>
                    <th rowspan="2">Meneger</th>
                    <th rowspan="2">Guruhga o'chirildi</th>
                    <th rowspan="2">Izoh</th>
                    <th rowspan="2">Meneger</th>
                    <th colspan="4">Test natijasi</th> <th rowspan="2">Davomad</th>
                  </tr>
                  <tr class="text-center align-middle bg-light">
                    <th>Urinish</th>
                    <th>Testlar soni</th>
                    <th>To'g'ri javob</th>
                    <th>Ball</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-center align-middle">
                    <td>1</td>
                    <td class="text-start">Aliyev Vali</td> <td>2024-01-10</td>
                    <td>Yaxshi</td>
                    <td>Admin</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>1</td>
                    <td>50</td>
                    <td>45</td>
                    <td><span class="badge bg-success">90</span></td>
                    <td>95%</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


<div class="modal" id="sendDebetMessage" tabindex="-1">
  <form action="#" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Qarzdirlarga sms yuborish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="group_id" value="{{ $group['id'] }}">
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
<div class="modal" id="updateGroup" tabindex="-1">
  <form action="#" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Guruhni taxrirlash</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="group_id" value="{{ $group['id'] }}">
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
<div class="modal" id="trashUser" tabindex="-1">
  <form action="#" method="post">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Gyruhdan talaba o'chirish</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="group_id" value="{{ $group['id'] }}">
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

<div class="modal" id="nextGroup" tabindex="-1">
  <form action="{{ route('group_store_continue') }}" method="post" id="multiStepForm">
    @csrf 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Guruhni davom ettirish - <span id="stepTitle">1-qism</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>        
        <div class="modal-body">
          <input type="hidden" name="group_id" value="{{ $group['id'] }}">
          <!-- 1-Step -->
          <div class="form-step" id="step-1">
            <label class="mb-2" for="group_name">Yangi guruh nomi</label>
            <input type="text" name="group_name" value="{{ $group['group_name'] }}" class="form-control" required>
            <div class="row">
              <div class="col-6">
                <label class="my-2" for="cours_id">Kurs</label>
                <select name="cours_id" class="form-control" required>
                  <option value="">Tanlang...</option>
                  @foreach ($cours as $item)
                    <option value="{{ $item['id'] }}" @selected($item['id'] == $group['cours_id'])>
                      {{ $item['cours_name'] }}
                    </option>
                  @endforeach 
                </select>
              </div>
              <div class="col-6">
                <label class="my-2" for="room_id">Dars xonasi</label>
                <select name="room_id" class="form-control" required>
                  <option value="">Tanlang...</option>
                  @foreach ($rooms as $item)
                    <option value="{{ $item['id'] }}" @selected($item['id'] == $group['room_id'])>
                      {{ $item['name'] }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <label class="my-2" for="payment_id">Guruh narxi</label>
                <select name="payment_id" class="form-control" required>
                  <option value="">Tanlang...</option>
                  @foreach ($pay_setting as $item)
                    <option value="{{ $item['id'] }}" @selected($item['id'] == $group['payment_id'])>
                      To'lov: {{ $item['payment'] }} | Chegirma: {{ $item['discount'] }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <label class="my-2" for="teacher_id">O'qituvchi</label>
                <select name="teacher_id" class="form-control" required>
                  <option value="">Tanlang...</option>
                  @foreach ($teacher as $item)
                    <option value="{{ $item['id'] }}" @selected($item['id'] == $group['teacher_id'])>
                      {{ $item['name'] }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <label class="my-2" for="teacher_pay">O'qituvchiga to'lov</label>
                <input type="text" name="teacher_pay" id="amount0" value="{{ $group['teacher_pay'] }}" required class="form-control">
              </div>
              <div class="col-6">
                <label class="my-2" for="teacher_bonus">O'qituvchiga bonus</label>
                <input type="text" name="teacher_bonus" id="amount1" value="{{ $group['teacher_bonus'] }}" required class="form-control">
              </div>
            </div>
          </div>
          <!-- 2-Step -->
          <div class="form-step d-none" id="step-2">
            <label class="my-2" for="group_type">Dars kunlari</label>
            <select name="group_type" class="form-control" required>
              <option value="toq" @selected($group['group_type']=='toq')>Toq kunlar</option>
              <option value="juft" @selected($group['group_type']=='juft')>Juft kunlar</option>
              <option value="all" @selected($group['group_type']=='all')>Har kuni</option>
            </select>
            <label class="my-2" for="lesson_count">Darslar soni</label>
            <input type="number" name="lesson_count" value="{{ $group['lesson_count'] }}" class="form-control" required>    
            <label class="my-2" for="start_lesson">Dars boshlanish vaqti</label>
            <input type="date" name="start_lesson" value="{{ $group['end_lesson'] }}" class="form-control" id='amount' required>    
            <label class="my-2" for="lesson_time">Darslar boshlanish vaqti</label>        
            <select name="lesson_time" class="form-control" required>
              <option value="08:00 - 09:30" @selected($group['lesson_time']=='08:00 - 09:30')>08:00 - 09:30</option>
              <option value="09:30 - 11:00" @selected($group['lesson_time']=='09:30 - 11:00')>09:30 - 11:00</option>
              <option value="11:00 - 12:30" @selected($group['lesson_time']=='11:00 - 12:30')>11:00 - 12:30</option>
              <option value="12:30 - 14:00" @selected($group['lesson_time']=='12:30 - 14:00')>12:30 - 14:00</option>
              <option value="14:00 - 15:30" @selected($group['lesson_time']=='14:00 - 15:30')>14:00 - 15:30</option>
              <option value="15:30 - 17:00" @selected($group['lesson_time']=='15:30 - 17:00')>15:30 - 17:00</option>
              <option value="17:00 - 18:30" @selected($group['lesson_time']=='17:00 - 18:30')>17:00 - 18:30</option>
              <option value="18:30 - 20:00" @selected($group['lesson_time']=='18:30 - 20:00')>18:30 - 20:00</option>
              <option value="20:00 - 21:30" @selected($group['lesson_time']=='20:00 - 21:30')>20:00 - 21:30</option>
            </select>
          </div>
          <!-- 3-Step -->
          <div class="form-step d-none" id="step-3">
            <h6 class="w-100 text-center">Yangi guruhga o'tadigan talabalar</h6>
            <table class="table table-bordered">
              @forelse ($activUser as $item)
                <tr>
                  <td>
                    <input type="checkbox" name="student_ids[]" value="{{ $item['user_id'] }}" checked class="form-checkbox">
                  </td>
                  <td>{{ $item->user->name }} ( {{ $item->user->balance }} )</td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="2">Talabalar mavjud emas</td>
                </tr>
              @endforelse
            </table>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary d-none" id="prevBtn" onclick="changeStep(-1)">Orqaga</button>
          <div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelBtn">Bekor qilish</button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">Keyingi</button>
            <button type="submit" class="btn btn-success d-none" id="submitBtn">Yangi guruhni saqlash</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  let currentStep = 1;
  function changeStep(stepChange) {
      const steps = document.querySelectorAll('.form-step');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const submitBtn = document.getElementById('submitBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      const stepTitle = document.getElementById('stepTitle');
      document.getElementById(`step-${currentStep}`).classList.add('d-none');
      currentStep += stepChange;
      document.getElementById(`step-${currentStep}`).classList.remove('d-none');
      prevBtn.classList.toggle('d-none', currentStep === 1);
      nextBtn.classList.toggle('d-none', currentStep === 3);
      submitBtn.classList.toggle('d-none', currentStep !== 3);
      cancelBtn.classList.toggle('d-none', currentStep !== 1);
      stepTitle.innerText = `${currentStep}-qism`;
  }
</script>
@endsection