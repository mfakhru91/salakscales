<div id="sidebar-nav" class="sidebar">
  <div class="sidebar-scroll">
    <nav>
      <ul class="nav">
        <li><a href="{{ route('dashboard.index') }}" class="{{ Request::routeIs('dashboard.index') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
        <li><a href="{{ route('pembelian.index') }}" class="{{ Request::routeIs('pembelian.index') ? 'active' : '' }}"><i class="lnr lnr-cart"></i><span>Pembelian</span></a></li>
        <li><a href="{{ route('barang.index') }}" class="{{ Request::routeIs('barang.index')? 'active' : '' }}"><i class="lnr lnr-database"></i><span>Stok</span></a></li>
        <li><a href="{{ route('grading.index') }}" class="{{ Request::routeIs('grading.index') ? 'active' : '' }}"><i class="far fa-clipboard"></i><span>Grading</span></a></li>
        <li><a href="{{ route('penjualan.index') }}" class="{{ Request::routeIs('penjualan.index') ? 'active' : '' }}"><i class="lnr lnr-briefcase"></i><span>Penjualan</span></a></li>
        <li>
          <a href="#laporan" data-toggle="collapse" class="collapsed @if(Request::routeIs('laporan.index') || Request::routeIs('bookkeeping.index')) active @endif"><span class="lnr lnr-book"></span> <span>Laporan</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
          <div id="laporan" class="collapse ">
            <ul class="nav">
              <li><a href="{{ route('jurnal-ledger.index') }}" class="{{ Request::routeIs('jurnal-ledger.index') ? 'active' : '' }}"<span>Buku Besar</span></a></li>
              <li><a href="{{ route('jurnal-pembelian.index') }}" class="{{ Request::routeIs('jurnal-penjualan.index')? 'active' : '' }}"><span>Laporan Pembelian</span></a></li>
              <li><a href="{{ route('jurnal-penjualan.index') }}" class="{{ Request::routeIs('jurnal-penjualan.index')? 'active' : '' }}"><span>Laporan Penjualan</span></a></li>
              <li><a href="{{ route('additional-item.index') }}" class="{{ Request::routeIs('bookkeeping.index') ? 'active' : '' }}"<span>Pembelian Lain</span></a></li>
              <li><a href="{{ route('laporan-laba-rugi.index') }}" class="{{ Request::routeIs('laporan-laba-rugi.index') ? 'active' : '' }}"<span>Laporan Laba Rugi</span></a></li>
            </ul>
          </div>
        </li>
        {{--  <li><a href="{{ route('pembelian.index') }}" class=""><i class="lnr lnr-calendar-full"></i><span>Kalender</span></a></li>  --}}
        <li><a href="{{ route('setting.index') }}" class=""><i class="lnr lnr-cog"></i> <span>Setting</span></a></li>
      </ul>
    </nav>
  </div>
</div>
