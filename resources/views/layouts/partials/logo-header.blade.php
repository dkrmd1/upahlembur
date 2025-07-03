@php
    use App\Models\Setting;
    $setting = Setting::first();
@endphp

<div class="logo-header" data-background-color="dark">
    <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        @if ($setting && $setting->logo)
            <img src="{{ asset('storage/logo/' . $setting->logo) }}"
                 alt="Logo"
                 class="navbar-brand"
                 style="max-height: 40px; max-width: 140px; object-fit: contain;">
        @else
            <img src="{{ asset('assets/img/jb/logo.png') }}"
                 alt="Logo Default"
                 class="navbar-brand"
                 style="max-height: 40px; max-width: 140px; object-fit: contain;">
        @endif
    </a>

    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
    </div>

    <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
    </button>
</div>
