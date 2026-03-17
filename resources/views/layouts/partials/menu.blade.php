<li class="nav-item">
  <a class="nav-link {{ request()->routeIs(['home']) ? '' : 'collapsed' }}" href="{{ route('home') }}">
    <i class="bi bi-house-heart"></i>
    <span>Bosh sahifa</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link collapsed" href="">
    <i class="bi bi-house-heart"></i>
    <span>Firmalar</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link {{ request()->routeIs(['emploes','emploes_show']) ? '' : 'collapsed' }}" href="{{ route('emploes') }}">
    <i class="bi bi-house-heart"></i>
    <span>Hodimlar</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link {{ request()->routeIs(['setting_payment','setting_cours','setting_region','setting_cours_show']) ? '' : 'collapsed' }}" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-calendar2-check"></i><span>Sozlamalar</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="setting-nav" class="nav-content collapse {{ request()->routeIs(['setting_payment','setting_cours','setting_region','setting_cours_show']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{ route('setting_payment') }}" class="nav-link {{ request()->routeIs(['setting_payment']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>To'lovlar | Chegirmalar</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_cours') }}" class="nav-link {{ request()->routeIs(['setting_cours','setting_cours_show']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>Kurslar | Xonalar</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_region') }}" class="nav-link {{ request()->routeIs(['setting_region']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>Hududlar | SMS</span>
      </a>
    </li>
  </ul>
</li>


<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#davomad-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-calendar2-check"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="davomad-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
      <a href="#" class="nav-link ">
        <i class="bi bi-dot"></i><span>menu1</span>
      </a>
    </li>
    <li>
      <a href="#" class="nav-link ">
        <i class="bi bi-dot"></i><span>menu2</span>
      </a>
    </li>
  </ul>
</li>