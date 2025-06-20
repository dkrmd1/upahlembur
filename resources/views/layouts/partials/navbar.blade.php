<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ asset('assets/img/jb/profile.png') }}" alt="..." class="avatar-img rounded-circle"/>
                    </div>
                    <span class="profile-username">
                        <span class="op-7">{{ auth()->user()->role ?? 'User' }},</span>
                        <span class="fw-bold">{{ auth()->user()->name ?? 'Nama Pengguna' }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ asset('assets/img/jb/profile.png') }}" alt="image profile" class="avatar-img rounded"/>
                                </div>
                                <div class="u-text">
                                    <h4>{{ auth()->user()->name ?? 'Nama User' }}</h4>
                                    <p class="text-muted">{{ auth()->user()->email ?? 'email@example.com' }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
