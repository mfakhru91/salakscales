<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li><a href="{{ route('dashboard.index') }}" class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
        <li>
          <a href="#subPages" data-toggle="collapse" class="collapsed @if(Request::routeIs('pembelian.index') || Request::routeIs('penjualan.index')) active @endif"><i class="lnr lnr-users"></i> <span>Transaksi</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="subPages" class="collapse ">
            <ul class="nav">
              <li><a href="{{ route('pembelian.index') }}" class="{{ Request::routeIs('pembelian.index') ? 'active' : '' }}"><i class="lnr lnr-cart"></i><span>Pembelian</span></a></li>
              <li><a href="{{ route('penjualan.index') }}" class="{{ Request::routeIs('penjualan.index') ? 'active' : '' }}"><i class="lnr lnr-briefcase"></i><span>Penjualan</span></a></li>
            </ul>
          </div>
        </li>
        <li><a href="{{ route('barang.index') }}" class="{{ Request::routeIs('barang.index')? 'active' : '' }}"><i class="lnr lnr-database"></i><span>Barang</span></a></li>
        <li><a href="{{ route('laporan.index') }}" class="{{ Request::routeIs('laporan.index')? 'active' : '' }}"><i class="lnr lnr-book"></i><span>Laporan</span></a></li>
        <li><a href="{{ route('pembelian.index') }}" class=""><i class="lnr lnr-calendar-full"></i><span>Kalender</span></a></li>
        <li><a href="{{ route('setting.index') }}" class=""><i class="lnr lnr-cog"></i> <span>Setting</span></a></li>
      </ul>
    </nav>
  </div>
</div>
