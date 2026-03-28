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
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Aktiv talabalar <span>| Oxirgi 12 oy</span></h5>
            <canvas id="aktiv" style="max-height: 350px;"></canvas>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                const ctxAktiv = document.querySelector('#aktiv').getContext('2d');
                const gradientAktiv = ctxAktiv.createLinearGradient(0, 0, 0, 350);
                gradientAktiv.addColorStop(0, 'rgba(65, 84, 241, 0.2)');
                gradientAktiv.addColorStop(1, 'rgba(65, 84, 241, 0)');
                new Chart(ctxAktiv, {
                  type: 'line',
                  data: {
                    labels: [
                      @foreach ($activeUser['date'] as $value)
                        '{{ $value }}',
                      @endforeach
                    ],
                    datasets: [{
                      label: 'Aktiv talabalar',
                      data: [{{ implode(', ', $activeUser['active']) }}],
                      fill: true,
                      backgroundColor: gradientAktiv,
                      borderColor: '#4154f1',
                      borderWidth: 3,
                      tension: 0.4, // Silliq chiziq
                      pointRadius: 4,
                      pointBackgroundColor: '#fff',
                      pointBorderWidth: 2,
                      hitRadius: 10
                    }]
                  },
                  options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                      legend: { display: false }
                    },
                    scales: {
                      y: { 
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f0f0f0' }
                      },
                      x: { grid: { display: false } }
                    }
                  }
                });
              });
            </script>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Haftalik tashriflar <span>| Taqqoslovchi tahlil</span></h5>
            <canvas id="xaftalik" style="max-height: 300px;"></canvas>            
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered text-center align-middle" style="font-size: 13px;">
                  <thead class="table-light text-muted">
                    <tr>
                      <th>Status\Hafta</th>
                      @foreach ($getLast5Weeks as $week)
                        <th>{{ $week["label"] }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th style="text-align: left">Tashriflar soni</th>
                      @foreach ($weeks5chart as $item)
                        <td>{{ $item['visit'] }}</td>
                      @endforeach
                    </tr>
                    <tr>
                      <th style="text-align: left">To'lovlar soni</th>
                      @foreach ($weeks5chart as $item)
                        <td>{{ $item['payments'] }}</td>
                      @endforeach
                    </tr>
                    <tr>
                      <th style="text-align: left">To'lovlar summasi</th>
                      @foreach ($weeks5chart as $item)
                        <td>{{ number_format($item['payment_sum'], 0, '.', ' ') }} UZS</td>
                      @endforeach
                    </tr>
                    <tr>
                      <th style="text-align: left">Guruhga qo'shilganlar</th>
                      @foreach ($weeks5chart as $item)
                        <td>{{ $item['groups'] }}</td>
                      @endforeach
                    </tr>
                  </tbody>
                </table>
            </div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new Chart(document.querySelector('#xaftalik'), {
                  type: 'bar',
                  data: {
                    labels: [
                      @foreach ($getLast5Weeks as $week)
                        '{{ $week["label"] }}',                        
                      @endforeach
                    ],
                    datasets: [{
                      label: 'Tashriflar soni',
                      data: [
                        @foreach ($weeks5chart as $item)
                          {{ $item["visit"] }},
                        @endforeach
                      ],
                      backgroundColor: '#4154f1', // NiceAdmin Primary
                      borderRadius: 6,
                    }, {
                      label: 'To\'lovlar soni',
                      data: [
                        @foreach ($weeks5chart as $item)
                          {{ $item["payments"] }},
                        @endforeach
                      ],
                      backgroundColor: '#2eca6a', // NiceAdmin Success
                      borderRadius: 6,
                    }, {
                      label: 'Guruhga qo\'shilganlar',
                      data: [
                        @foreach ($weeks5chart as $item)
                          {{ $item["groups"] }},
                        @endforeach
                      ],
                      backgroundColor: '#ff771d', // NiceAdmin Warning
                      borderRadius: 6,
                    }]
                  },
                  options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                        tooltip: { backgroundColor: 'rgba(1, 41, 112, 0.9)', padding: 12 }
                    },
                    scales: {
                      x: { grid: { display: false } },
                      y: { beginAtZero: true, grid: { color: '#f0f0f0' } }
                    }
                  }
                });
              });
            </script>
          </div>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Oxirgi 6 oylik hisobot <span>| Okt 2025 - Mar 2026</span></h5>            
            <canvas id="oylik" style="max-height: 350px;"></canvas>
            <div class="table-responsive mt-4">
              <table class="table table-hover table-bordered text-center align-middle" style="font-size: 13px;">
                <thead class="table-light text-muted">
                  <tr>
                    <th>Oy</th>
                    @foreach ($getLast6Months as $item)
                      <th>{{ $item }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th style="text-align: left">Tashriflar soni</th>
                    @foreach ($month6chart as $item)
                      <td>{{ $item["visit"] }}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <th style="text-align: left">To'lovlar soni</th>
                    @foreach ($month6chart as $item)
                      <td>{{ $item["payments"] }}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <th style="text-align: left">To'lovlar summasi</th>
                    @foreach ($month6chart as $item)
                      <td>{{ number_format($item['payment_sum'], 0, '.', ' ') }} UZS</td>
                    @endforeach
                  </tr>
                  <tr>                    
                    <th style="text-align: left">Guruhga qo'shilganlar</th>
                    @foreach ($month6chart as $item)
                      <td>{{ $item["groups"] }}</td>
                    @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                const ctxOylik = document.querySelector('#oylik');
                new Chart(ctxOylik, {
                  type: 'line',
                  data: {
                    labels: [
                      @foreach ($getLast6Months as $item)
                        '{{ $item }}',
                      @endforeach
                    ],
                    datasets: [{
                      label: 'Tashriflar soni',
                      data: [
                        @foreach ($month6chart as $item)
                          {{ $item["visit"] }},
                        @endforeach
                      ],
                      backgroundColor: 'rgba(65, 84, 241, 0.1)',
                      borderColor: '#4154f1',
                      borderWidth: 3,
                      fill: true,
                      tension: 0.3
                    }, {
                      label: 'To\'lovlar soni',
                      data: [
                        @foreach ($month6chart as $item)
                          {{ $item["payments"] }},
                        @endforeach
                      ],
                      backgroundColor: 'rgba(46, 202, 106, 0.1)',
                      borderColor: '#2eca6a',
                      borderWidth: 3,
                      fill: true,
                      tension: 0.3
                    }, {
                      label: 'Guruhga qo\'shilganlar',
                      data: [
                        @foreach ($month6chart as $item)
                          {{ $item["groups"] }},
                        @endforeach
                      ],
                      backgroundColor: 'rgba(255, 119, 29, 0.1)',
                      borderColor: '#ff771d',
                      borderWidth: 3,
                      fill: true,
                      tension: 0.3
                    }]
                  },
                  options: {
                    responsive: true,
                    plugins: {
                      legend: { position: 'top', labels: { usePointStyle: true, font: { weight: '600' } } },
                      tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                      x: { grid: { display: false } },
                      y: { beginAtZero: true, grid: { color: '#f0f0f0' } }
                    }
                  }
                });
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
      .card-title span { color: #899bbd; font-size: 14px; font-weight: 400; }
      .bg-primary-light { background-color: #e0e3ff; color: #4154f1; }
      .table thead th { text-transform: uppercase; letter-spacing: 0.5px; }
      .card { transition: transform 0.2s; }
      .card:hover { transform: translateY(-2px); }
  </style>
@endsection