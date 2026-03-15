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
  <a class="nav-link collapsed" href="#">
    <i class="bi bi-house-heart"></i>
    <span>Firmalar</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link {{ request()->routeIs(['setting_message','setting_payment','setting_room','setting_cours','setting_region']) ? '' : 'collapsed' }}" data-bs-target="#davomad-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-calendar2-check"></i><span>Sozlamalar</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="davomad-nav" class="nav-content collapse {{ request()->routeIs(['setting_message','setting_payment','setting_room','setting_cours','setting_region']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{ route('setting_message') }}" class="nav-link {{ request()->routeIs(['setting_message']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>SMS sozlamalari</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_payment') }}" class="nav-link {{ request()->routeIs(['setting_payment']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>To'lov sozlamalari</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_room') }}" class="nav-link {{ request()->routeIs(['setting_room']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>Dars xonalari</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_cours') }}" class="nav-link {{ request()->routeIs(['setting_cours']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>Kurslar</span>
      </a>
    </li>
    <li>
      <a href="{{ route('setting_region') }}" class="nav-link {{ request()->routeIs(['setting_region']) ? '' : 'collapsed' }}">
        <i class="bi bi-dot"></i><span>Hududlar</span>
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