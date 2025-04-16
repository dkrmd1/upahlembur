<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">

        <li class="nav-item {{ Route::is(['dashboard']) ? 'active' : '' }}">
          <a href="/" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Components</h4>
        </li>

        <li class="nav-item {{ Route::is(['import.data*']) ? 'active' : '' }}">
          <a href="{{ route('import.data') }}" class="collapsed" aria-expanded="false">
            <i class="fas fa-database"></i>
            <p>Data</p>
          </a>
        </li>

      </ul>
    </div>
  </div>
