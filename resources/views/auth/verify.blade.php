<!doctype html>
<html lang="en">

<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/vendor/chartist/css/chartist-custom.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('public/klorofil/assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/image/icon-logo.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('public/image/icon-logo.png')}}">
	@yield('header')
</head>

<body class="layout-fullwidth">
	<!-- WRAPPER -->
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
            <div class="brand">
              <a href="{{ route('home.page') }}"><img src="{{asset('public/image/logo_fix.png')}}" alt="Klorofil Logo"class="img-responsive logo" ></a>
            </div>
            <div class="container-fluid">
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span>{{Auth::user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
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
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!--  -->
					<div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="panel">
                                <div class="panel-body text-center">
                                    <h3><b>Silahkan Verifikasi Email Anda</b></h3>
                                    <h4>Tautan verifikasi baru telah dikirim ke alamat email Anda..</h4>
                                    <p>Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi.</p>
                                    <br>
                                    <p>Jika Anda tidak menerima email</p>
                                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">{{ __('click disini untuk memverifikasi ulang') }}</button>.
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				{{--  <p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>  --}}
			</div>
		</footer>
    </div>

	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	<script src="{{asset('public/klorofil/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/klorofil/assets/scripts/klorofil-common.js')}}"></script>
	@yield('footer')
	</body>

</html>

