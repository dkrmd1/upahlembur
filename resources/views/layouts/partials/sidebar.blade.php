@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

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

            {{-- Menu Tambahan untuk Admin --}}
            @if ($user && $user->role === 'admin')
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pengaturan</h4>
                </li>

                <li class="nav-item {{ Route::is('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-user-cog"></i>
                        <p>Kelola Akun</p>
                    </a>
                </li>

                {{-- Setting Website --}}
                <li class="nav-item {{ Route::is('setting.index') ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-cogs"></i>
                        <p>Setting Website</p>
                    </a>
                </li>
            @endif

            {{-- Menu Pengaturan Akun untuk Manager --}}
            @if ($user && $user->role === 'manager')
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Akun</h4>
                </li>

                <li class="nav-item {{ Route::is('akun.setting') ? 'active' : '' }}">
                    <a href="{{ route('akun.setting') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <p>Setting Akun</p>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
