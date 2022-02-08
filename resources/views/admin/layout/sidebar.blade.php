<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0 d-flex flex-column items-center" href="">
        <img src="{{ asset('assets/img/logodev.png') }}" class="navbar-brand-img h-100 text-center" alt="main_logo">
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        
        <li class="nav-item">
          <a class="nav-link text-white  " href="{{ url('/dashboard') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            <span class="nav-link-text ms-1">Table de borde</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('admin.employee') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users"></i>
            </div>
            <span class="nav-link-text ms-1">Les utilisateurs</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('admin.entre') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-arrow-alt-circle-right text-success"></i>
            </div>
            <span class="nav-link-text ms-1">Gestion des entrés</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('admin.sorte') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-arrow-alt-circle-left text-danger"></i>
            </div>
            <span class="nav-link-text ms-1">Gestion des sorties</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('admin.archive.sorte') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-arrow-alt-circle-left text-info"></i>
            </div>
            <span class="nav-link-text ms-1">L'archive des sorties</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('admin.archive.entre') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-arrow-alt-circle-right text-worning"></i>
            </div>
            <span class="nav-link-text ms-1">L'archive des entres</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./pages/profile.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>