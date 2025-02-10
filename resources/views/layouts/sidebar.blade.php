<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logos/iconWebsite.png') }}" style="max-width: 2em" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text" style="color: black; padding: 0.8em">{{ config('app.name', 'Asiap Apps') }}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-chevron-left'></i></div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="">
                <div class="parent-icon"><i class='bx bx-tachometer'></i></div> <!-- Ubah ikon dashboard -->
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
        <li class="menu-label">Manajemen</li>
        <li class="{{ request()->is('kelola-buku') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.kelolaBuku.index') }}">
                <div class="parent-icon"><i class='bx bx-book'></i></div> <!-- Ubah ikon Kelola Buku -->
                <div class="menu-title">Kelola Buku</div>
            </a>
        </li>
        
        <li class="{{ request()->is('data-anggota') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dataAnggota.index') }}">
                <div class="parent-icon"><i class='bx bx-user'></i></div> <!-- Ubah ikon Data Anggota -->
                <div class="menu-title">Data Anggota</div>
            </a>
        </li>
        
        <li class="menu-label">Proses</li>
        <li class="{{ request()->is('sirkulasi') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.sirkulasi.index') }}">
                <div class="parent-icon"><i class='bx bx-time'></i></div> <!-- Ubah ikon Surkulasi -->
                <div class="menu-title">Sirkulasi</div>
            </a>
        </li>
        
        {{-- <li class="menu-label">Log Data</li>
        <li class="{{ request()->is('log-data-peminjaman') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.logDataPeminjaman.index') }}">
                <div class="parent-icon"><i class='bx bx-calendar-check'></i></div> <!-- Ubah ikon Data Peminjaman -->
                <div class="menu-title">Data Peminjaman</div>
            </a>
        </li>
        
        <li class="{{ request()->is('log-data-pengembalian') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.logDataPengembalian.index') }}">
                <div class="parent-icon"><i class='bx bx-calendar-exclamation'></i></div> <!-- Ubah ikon Data Pengembalian -->
                <div class="menu-title">Data Pengembalian</div>
            </a>
        </li> --}}
        
        <li class="menu-label">Laporan</li>
        <li class="{{ request()->routeIs('admin.laporanSirkulasi.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.laporanSirkulasi.index') }}">
                <div class="parent-icon"><i class='bx bx-file'></i></div> <!-- Ubah ikon Laporan Sirkulasi -->
                <div class="menu-title">Laporan Sirkulasi</div>
            </a>
        </li>
        
        <li class="menu-label">Settings</li>
        <li>
            <a href="{{ route('admin.manajemenUsers.index') }}">
                <div class="parent-icon"><i class='bx bx-cog'></i></div> <!-- Ubah ikon Manajemen Pengguna -->
                <div class="menu-title">Manajemen Pengguna</div>
            </a>
        </li>
     
    </ul>
    <!--end navigation-->
</div>
