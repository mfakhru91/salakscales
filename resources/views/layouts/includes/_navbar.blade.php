<nav class="navbar navbar-default navbar-fixed-top">
  <div class="brand">
    <a href="{{ route('home.page') }}"><img src="{{asset('public/image/logo_fix.png')}}" alt="Klorofil Logo"class="img-responsive logo" ></a>
  </div>
  <div class="container-fluid">
    <div class="navbar-btn">
      <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
    </div>
    <div id="navbar-menu">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          @if(Auth::user()->avatar == null)
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('public/image/default-user-image.png')}}" class="img-circle" alt="Avatar"> <span>{{Auth::user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
          @else
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('storage/app/public/'.Auth::user()->avatar)}}" class="img-circle" alt="Avatar"> <span>{{Auth::user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
          @endif
          <ul class="dropdown-menu">
            {{--  <li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>  --}}
            <li><a href="{{route('setting.index')}}"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Logout</span></a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </li>
        <!-- <li>
          <a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>
