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
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Dars jadvali</h5>
            <table class="table table-bordered" style="font-size: 14px">
              <head>
                <tr class="text-center">
                  <th>Dars Vaqt \ Hafta kunlari</th>
                  <th>Dushanba</th>
                  <th>Seshanba</th>
                  <th>Chorshanba</th>
                  <th>Payshanba</th>
                  <th>Juma</th>
                  <th>Shanba</th>
                </tr>
              </head>
              <tbody class="text-center">
                <tr>
                  <th>08:00 - 09:30</th>
                  <td>
                    <span class="badge rounded-pill bg-primary">Matematika</span>
                    <span class="badge rounded-pill bg-primary">FIZIKA</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="badge rounded-pill bg-primary">Tarix</span>
                  </td>
                  <td>
                    <span class="badge rounded-pill bg-primary">Tarix</span>
                    <span class="badge rounded-pill bg-primary">Falsafa</span>
                    <span class="badge rounded-pill bg-primary">Informatika</span>
                  </td>
                  <td></td>
                  <td>
                    <span class="badge rounded-pill bg-primary">Tarix</span>
                  </td>
                </tr>
                <tr>
                  <th>09:30 - 11:00</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <th>11:00 - 12:30</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>                
                <tr>
                  <th>12:30 - 14:00</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>     
                <tr>
                  <th>14:00 - 15:30</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <th>15:30 - 17:00</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <th>17:00 - 18:30</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <th>18:30 - 20:00</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <th>20:00 - 21:30</th>
                  <td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection