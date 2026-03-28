@extends('layouts.admin')
@section('title', 'To\'lovlar')
@section('content')
  <div class="pagetitle">
    <h1>To'lovlar</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">To'lovlar</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <h5 class="card-title">Kunlik to'lovlar <span>| Oxirgi 7 kun</span></h5>
            <div id="kunlikTolov" style="min-height: 300px;"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#kunlikTolov"), {
                  series: [
                    {name: 'Naqt', data: [
                      @foreach ($kunlikPayment as $item)
                        {{ $item['cash'] }},
                      @endforeach
                    ]},
                    {name: 'Karta', data: [
                      @foreach ($kunlikPayment as $item)
                        {{ $item['card'] }},
                      @endforeach]}, 
                    {name: 'Chegirma', data: [
                      @foreach ($kunlikPayment as $item)
                        {{ $item['discount'] }},
                      @endforeach
                    ]}, 
                    {name: 'Qaytarilgan', data: [
                      @foreach ($kunlikPayment as $item)
                        {{ $item['return'] }},
                      @endforeach
                    ]}
                  ],
                  chart: {type: 'bar', height: 300, toolbar: {show: false}, zoom: {enabled: false}},
                  colors: ['#4154f1', '#2eca6a', '#ff771d', '#ff1919'],
                  plotOptions: {
                    bar: {horizontal: false, columnWidth: '55%', borderRadius: 5, endingShape: 'rounded'},
                  },
                  dataLabels: {enabled: false},
                  stroke: {show: true, width: 2, colors: ['transparent']},
                  xaxis: {
                    categories: [
                      @foreach ($getLast7Days as $item)
                        '{{ $item }}',
                      @endforeach
                    ],
                  },
                  yaxis: {title: {text: 'UZS (ming)'}},
                  fill: {opacity: 1},
                  tooltip: {y: {formatter: function(val) {return val.toLocaleString() + " UZS"}}}
                }).render();
              });
            </script>
            <div class="table-responsive mt-3">
              <table class="table table-hover table-bordered text-center align-middle" style="font-size: 13px;">
                <thead class="table-light text-muted">
                  <tr>
                    <th class="text-start">Status\Kunlik</th>
                    @foreach ($getLast7Days as $item)
                      <th>{{ $item }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr><th class="text-start fw-normal">Naqt to'lov</th>
                    @foreach ($kunlikPayment as $item)
                      <td>{{ number_format($item['cash'], 0, '.', ' ') }}</td>
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Karta to'lov</th>
                    @foreach ($kunlikPayment as $item)
                      <td>{{ number_format($item['card'], 0, '.', ' ') }}</td>
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal text-danger">Qaytarilgan</th>
                    @foreach ($kunlikPayment as $item)
                      <td>{{ number_format($item['return'], 0, '.', ' ') }}</td>
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal text-warning">Chegirma</th>
                    @foreach ($kunlikPayment as $item)
                      <td>{{ number_format($item['discount'], 0, '.', ' ') }}</td>
                    @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <h5 class="card-title">Haftalik to'lovlar <span>| Dinamika</span></h5>
            <div id="haftalikTolov" style="min-height: 300px;"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#haftalikTolov"), {
                  series: [
                    {name: 'Naqt', data: [
                      @foreach ($haftalikPayment as $item)
                        {{ $item['cash'] }},
                      @endforeach
                    ]},
                    {name: 'Karta', data: [
                      @foreach ($haftalikPayment as $item)
                        {{ $item['card'] }},
                      @endforeach
                    ]}, 
                    {name: 'Chegirma', data: [
                      @foreach ($haftalikPayment as $item)
                        {{ $item['discount'] }},
                      @endforeach
                    ]}, 
                    {name: 'Qaytarilgan', data: [
                      @foreach ($haftalikPayment as $item)
                        {{ $item['return'] }},
                      @endforeach
                    ]}
                  ],
                  chart: {type: 'bar', height: 300, toolbar: {show: false}},
                  colors: ['#4154f1', '#2eca6a', '#ff771d', '#dc3545'],
                  plotOptions: {
                    bar: {horizontal: false, columnWidth: '45%', borderRadius: 5},
                  },
                  dataLabels: {enabled: false},
                  stroke: {show: true, width: 2, colors: ['transparent']},
                  xaxis: {
                    categories: [
                      @foreach ($getLast5Weeks as $item)
                        '{{ $item['label'] }}',
                      @endforeach
                    ],
                  },
                  yaxis: {title: {text: 'Summa (mln)'}},
                  fill: {opacity: 0.9},
                  tooltip: {y: {formatter: function(val) {return val + " UZS"}}}
                }).render();
              });
            </script>
            <div class="table-responsive mt-3">
              <table class="table table-hover table-bordered text-center align-middle" style="font-size: 13px;">
                <thead class="table-light text-muted">
                  <tr>
                    <th class="text-start">Status\Hafta</th>                    
                    @foreach ($getLast5Weeks as $item)
                      <th>{{ $item['label'] }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr><th class="text-start fw-normal">Naqt to'lov</th>
                  @foreach ($haftalikPayment as $item)
                    <td>{{ number_format($item['cash'], 0, '.', ' ') }}</td>
                  @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Karta to'lov</th>
                  @foreach ($haftalikPayment as $item)
                    <td>{{ number_format($item['card'], 0, '.', ' ') }}</td>
                  @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal text-danger">Qaytarilgan</th>
                  @foreach ($haftalikPayment as $item)
                    <td>{{ number_format($item['return'], 0, '.', ' ') }}</td>
                  @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal text-warning">Chegirma</th>
                  @foreach ($haftalikPayment as $item)
                    <td>{{ number_format($item['discount'], 0, '.', ' ') }}</td>
                  @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title">Oylik to'lovlar <span>| Yillik tahlil</span></h5>
            <div id="oylikTolov" style="min-height: 300px;"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#oylikTolov"), {
                  series: [
                    {name: 'Naqt', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['cash'] }}',
                      @endforeach
                    ]},
                    {name: 'Karta', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['card'] }}',
                      @endforeach
                    ]}, 
                    {name: 'Chegirma', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['discount'] }}',
                      @endforeach
                    ]}, 
                    {name: 'Qaytarilgan', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['return'] }}',
                      @endforeach
                    ]},
                    {name: 'Exson', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['exson'] }}',
                      @endforeach
                    ]},
                    {name: 'Ish haqi', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['ishHaqqi'] }}',
                      @endforeach
                    ]} ,
                    {name: 'Xarajat', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['xarajat'] }}',
                      @endforeach
                    ]} ,
                    {name: 'Daromad', data: [
                      @foreach ($oylikPayment as $item)
                        '{{ $item['daromad'] }}',
                      @endforeach
                    ]} 
                  ],
                  chart: {type: 'bar', height: 350, stacked: false, toolbar: {show: true}},
                  plotOptions: {
                    bar: {horizontal: false, columnWidth: '70%', borderRadius: 3},
                  },
                  dataLabels: {enabled: false},
                  stroke: {show: true, width: 2, colors: ['transparent']},
                  xaxis: {
                    categories: [
                      @foreach($getLast6Months as $item)
                        '{{ $item }}',
                      @endforeach
                    ],
                  },
                  legend: { position: 'top', horizontalAlign: 'center', offsetY: 0 },
                  fill: {opacity: 1},
                  tooltip: {y: {formatter: function(val) {return val + " UZS"}}}
                }).render();
              });
            </script>
            <div class="table-responsive mt-3">
              <table class="table table-hover table-bordered text-center align-middle" style="font-size: 13px;">
                <thead class="table-light text-muted">
                  <tr>
                    <th class="text-start">Status\Oylik</th>
                    @foreach($getLast6Months as $item)
                      <th>{{ $item }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr><th class="text-start fw-normal">Naqt to'lov</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['cash'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Karta to'lov</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['card'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal text-danger">Qaytarilgan</th>
                    @foreach ($oylikPayment as $item) 
                      <td>{{ number_format($item['return'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr> 
                  <tr><th class="text-start fw-normal text-warning">Chegirma</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['discount'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Exson</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['exson'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Xarajatlar</th>
                    @foreach ($oylikPayment as $item) 
                      <td>{{ number_format($item['xarajat'], 0, '.', ' ') }}</td>  
                    @endforeach
                  </tr>
                  <tr><th class="text-start fw-normal">Ish haqi</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['ishHaqqi'], 0, '.', ' ') }}</td>  
                    @endforeach                  
                  </tr>
                  <tr><th class="text-start fw-normal">Daromad</th>
                    @foreach ($oylikPayment as $item)
                      <td>{{ number_format($item['daromad'], 0, '.', ' ') }}</td>  
                    @endforeach 
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <style>
    .card-title span { color: #899bbd; font-size: 14px; font-weight: 400; }
    .table thead th { font-weight: 600; background-color: #f6f9ff !important; color: #4154f1; }
    .card { border-radius: 15px; overflow: hidden; }
    .table-hover tbody tr:hover { background-color: #f1f4ff; transition: 0.3s; }
  </style>
@endsection