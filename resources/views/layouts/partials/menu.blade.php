@auth
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
      <i class="bi bi-grid"></i>
      <span>Bosh sahifa</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs(['tashriflar','tashrif_show']) ? '' : 'collapsed' }}" href="{{ route('tashriflar') }}">
      <i class="bi bi-person-plus"></i>
      <span>Tashriflar</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs(['groups','group_show']) ? '' : 'collapsed' }}" href="{{ route('groups') }}">
      <i class="bi bi-people"></i>
      <span>Guruhlar</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('kassa') ? '' : 'collapsed' }}" href="{{ route('kassa') }}">
      <i class="bi bi-cash-stack"></i>
      <span>Kassa</span>
    </a>
  </li>
  @if(auth()->user()->role == 'admin' OR auth()->user()->role == 'director')
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['emploes','emploes_show']) ? '' : 'collapsed' }}" href="{{ route('emploes') }}">
        <i class="bi bi-person-badge"></i>
        <span>Hodimlar</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('balans') ? '' : 'collapsed' }}" href="{{ route('balans') }}">
        <i class="bi bi-bank"></i>
        <span>Moliya</span>
      </a>
    </li>
    @endif
    @if(auth()->user()->role == 'admin' OR auth()->user()->role == 'director' OR auth()->user()->role == 'manager')
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['report_*']) ? '' : 'collapsed' }}" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-earmark-bar-graph"></i><span>Hisobotlar</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="report-nav" class="nav-content collapse {{ request()->routeIs(['report_*']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('report_users') }}" class="{{ request()->routeIs('report_users') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Talabalar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('report_payment') }}" class="{{ request()->routeIs('report_payment') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>To'lovlar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('report_groups') }}" class="{{ request()->routeIs('report_groups') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Guruhlar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('report_message') }}" class="{{ request()->routeIs('report_message') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Yuborilgan SMS</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['chart_*']) ? '' : 'collapsed' }}" data-bs-target="#chart-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-graph-up-arrow"></i><span>Statistika</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="chart-nav" class="nav-content collapse {{ request()->routeIs(['chart_*']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('chart_tashrif') }}" class="{{ request()->routeIs('chart_tashrif') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Tashriflar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('chart_payment') }}" class="{{ request()->routeIs('chart_payment') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>To'lovlar</span>
          </a>
        </li>
      </ul>
    </li>
    @endif
    @if(auth()->user()->role == 'admin' OR auth()->user()->role == 'director')
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['setting_*']) ? '' : 'collapsed' }}" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear"></i><span>Sozlamalar</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="setting-nav" class="nav-content collapse {{ request()->routeIs(['setting_*']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('setting_payment') }}" class="{{ request()->routeIs('setting_payment') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>To'lov turlari</span>
          </a>
        </li>
        <li>
          <a href="{{ route('setting_cours') }}" class="{{ request()->routeIs(['setting_cours','setting_cours_show']) ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Kurslar va Xonalar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('setting_region') }}" class="{{ request()->routeIs('setting_region') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Hududlar | SMS</span>
          </a>
        </li>
        <li>
          <a href="{{ route('setting_dam_olish') }}" class="{{ request()->routeIs('setting_dam_olish') ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Dam olish kunlari</span>
          </a>
        </li>
      </ul>
    </li>
    @endif
    @if(auth()->user()->role == 'admin')
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('upload_view') ? '' : 'collapsed' }}" href="{{ route('upload_view') }}">
        <i class="bi bi-cloud-arrow-up"></i>
        <span>Upload</span>
      </a>
    </li>
  @endif
@endauth