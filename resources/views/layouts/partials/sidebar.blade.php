<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">

            {{-- Dashboard --}}
            <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Section Title --}}
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Manajemen</h4>
            </li>

            {{-- Karyawan --}}
            <li class="nav-item {{ Route::is('karyawan.*') ? 'active' : '' }}">
                <a href="{{ route('karyawan.index') }}" class="collapsed" aria-expanded="false">
                    <i class="fas fa-users"></i>
                    <p>Data Karyawan</p>
                </a>
            </li>

            {{-- Lembur --}}
            <li class="nav-item {{ Route::is('lembur.*') ? 'active' : '' }}">
                <a href="{{ route('lembur.index') }}" class="collapsed" aria-expanded="false">
                    <i class="fas fa-clock"></i>
                    <p>Data Lembur</p>
                </a>
            </li>

            {{-- Gaji --}}
            <li class="nav-item {{ Route::is('gaji.*') ? 'active' : '' }}">
                <a href="{{ route('gaji.index') }}" class="collapsed" aria-expanded="false">
                    <i class="fas fa-money-bill-wave"></i>
                    <p>Data Gaji</p>
                </a>
            </li>

            {{-- Laporan --}}
            <!--- <li class="nav-item {{ Route::is('laporan.*') ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}" class="collapsed" aria-expanded="false">
                    <i class="fas fa-file-alt"></i>
                    <p>Laporan</p>
                </a>
            </li> --->

        </ul>
    </div>
</div>
