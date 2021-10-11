<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ url('/') }}">
            <div class="logo-img">
                <img height="30" src="{{ asset('images/logo.png') }}" class="header-brand-img" title="RADMIN">
                SIPeba
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}"><i
                            class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard') }}</span></a>
                </div>


                @if (auth()->user()->level == 1)
                    <div class="nav-item {{ request()->is('master*') ? 'active open' : '' }} has-sub">
                        <a href="#"><i class="ik ik-inbox"></i><span>{{ __('Data Master') }}</span></a>
                        <div class="submenu-content">
                            <a href="{{ url('master/klasifikasi') }}"
                                class="menu-item {{ request()->is('master/klasifikasi') ? 'active' : '' }}">{{ __('Tabel Spesifikasi') }}</a>

                            <a href="{{ url('master/satuan') }}"
                                class="menu-item {{ request()->is('master/satuan') ? 'active' : '' }}">{{ __('Tabel Satuan') }}</a>

                            <a href="{{ url('master/rekanan') }}"
                                class="menu-item {{ request()->is('master/rekanan') ? 'active' : '' }}">{{ __('Tabel Vendor/Rekanan') }}</a>

                            <a href="{{ url('master/bagian') }}"
                                class="menu-item {{ request()->is('master/bagian') ? 'active' : '' }}">{{ __('Tabel Bagian') }}</a>

                            <a href="{{ url('master/barang') }}"
                                class="menu-item {{ request()->is('master/barang') ? 'active' : '' }}">{{ __('Tabel Barang') }}</a>

                        </div>
                    </div>

                @endif

                <div class="nav-item {{ request()->is('penerimaan') ? 'active' : '' }}">
                    <a href="{{ url('penerimaan') }}"><i
                            class="ik ik-box"></i><span>{{ __('Penerimaan') }}</span></a>
                </div>

                <div class="nav-item {{ request()->is('pengeluaran') ? 'active' : '' }}">
                    <a href="{{ url('pengeluaran') }}"><i
                            class="ik ik-layers"></i><span>{{ __('Pengeluaran') }}</span></a>
                </div>

                <div class="nav-item {{ request()->is('persediaanbarang/b22') ? 'active' : '' }}">
                    <a href="{{ url('persediaanbarang/b22') }}"><i
                            class="ik ik-file-text"></i><span>{{ __('Kartu Persediaan Barang B.22') }}</span></a>
                </div>
                <div class="nav-item {{ request()->is('persediaanbarang/b23') ? 'active' : '' }}">
                    <a href="{{ url('persediaanbarang/b23') }}"><i
                            class="ik ik-file-text"></i><span>{{ __('Kartu Persediaan Barang B.23') }}</span></a>
                </div>

                <div class="nav-item {{ request()->is('rekapitulasi') ? 'active' : '' }}">
                    <a href="{{ url('rekapitulasi') }}"><i
                            class="ik ik-layout"></i><span>{{ __('Rekapitulasi') }}</span></a>
                </div>

                @if (auth()->user()->level == 1 || auth()->user()->level == 3)
                    <div class="nav-item {{ request()->is('user') ? 'active' : '' }}">
                        <a href="{{ url('user') }}"><i
                                class="ik ik-user"></i><span>{{ __('User / Pengguna') }}</span></a>
                    </div>
                    <div class="nav-item {{ request()->is('tahun') ? 'active' : '' }}">
                        <a href="{{ url('tahun') }}"><i
                                class="ik ik-layout"></i><span>{{ __('Pergantian Tahun') }}</span></a>
                    </div>
                @endif

            </nav>
        </div>
    </div>
</div>
