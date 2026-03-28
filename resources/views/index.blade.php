@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card info-card sales-card border-0 shadow-sm" style="border-radius: 15px;">
          <div class="card-body pt-3">
            <h5 class="card-title text-primary fw-bold mb-3" style="font-size: 20px;">
              <i class="bi bi-calendar3 me-2"></i>Dars jadvali
            </h5>
            
            <div class="table-responsive">
              <table class="table table-hover table-bordered align-middle border-light" style="font-size: 13px; min-width: 900px;">
                <thead class="bg-light text-secondary">
                  <tr class="text-center border-bottom-0">
                    <th class="py-3 text-primary" style="background: #f0f3ff; width: 12%;">
                      <i class="bi bi-clock me-1"></i> Vaqt
                    </th>
                    <th class="py-3">Dushanba</th>
                    <th class="py-3">Seshanba</th>
                    <th class="py-3">Chorshanba</th>
                    <th class="py-3">Payshanba</th>
                    <th class="py-3">Juma</th>
                    <th class="py-3">Shanba</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach ($darsJadvali as $item)
                  <tr>
                    <th class="py-3 fw-bold text-dark" style="background: #fbfcfe;">
                      {{ $item['vaqt'] }}
                    </th>
                    
                    {{-- Dushanba --}}
                    <td class="p-2">
                      @foreach ($item[0]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-primary">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>

                    {{-- Seshanba --}}
                    <td class="p-2">
                      @foreach ($item[1]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-success">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>

                    {{-- Chorshanba --}}
                    <td class="p-2">
                      @foreach ($item[2]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-primary">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>

                    {{-- Payshanba --}}
                    <td class="p-2">
                      @foreach ($item[3]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-success">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>

                    {{-- Juma --}}
                    <td class="p-2">
                      @foreach ($item[4]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-primary">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>

                    {{-- Shanba --}}
                    <td class="p-2">
                      @foreach ($item[5]['guruh'] as $item1)
                        <div class="group-badge mb-1">
                          <a href="{{ route('group_show', $item1['group_id']) }}" class="text-decoration-none d-block p-2 rounded-3 shadow-sm bg-gradient-success">
                            <div class="fw-bold">{{ $item1['group_name'] }}</div>
                            <div class="small opacity-75" style="font-size: 10px;">{{ $item1['teacher'] }}</div>
                          </a>
                        </div>
                      @endforeach
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* Gradient Ranglar */
    .bg-gradient-primary {
      background: linear-gradient(45deg, #4154f1, #6f7ef8);
      color: white !important;
      transition: 0.3s;
    }
    .bg-gradient-success {
      background: linear-gradient(45deg, #2eca6a, #4de38a);
      color: white !important;
      transition: 0.3s;
    }
    
    /* Hover Effekti */
    .group-badge a:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
      filter: brightness(1.1);
    }

    /* Jadval Chiziqlari */
    .table thead th {
      border-top: none;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-color: red;
    }
    .table tbody tr td {
      border-color: red;
    }
    
    /* Responsive sozlamalar */
    .table-responsive::-webkit-scrollbar {
      height: 8px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
      background: #e0e0e0;
      border-radius: 10px;
    }
  </style>

@endsection