<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salak Scales IOT </title>
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/welcome.css')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('public/image/icon-logo.png')}}">
	  <link rel="icon" type="image/png" sizes="96x96" href="{{asset('public/image/icon-logo.png')}}">
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container-fluid"><a href="#" class="navbar-brand text-uppercase font-weight-bold"><img src="public/image/icon-logo.png" width="60px" alt=""></a>
                <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>

                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                      <li class="nav-item active"><a href="#" class="nav-link text-uppercase font-weight-bold">Lorem <span class="sr-only">(current)</span></a></li>
                      <li class="nav-item"><a href="#" class="nav-link text-uppercase font-weight-bold">About</a></li>
                      <li class="nav-item"><a href="#" class="nav-link text-uppercase font-weight-bold">faq</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                      @if (Route::has('login'))
                        @auth
                        <li>
                          <a href="{{ route('dashboard.index') }}" class="nav-link text-uppercase font-weight-bold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        </li>
                        <li>
                          <i><img src="public\image\user.png" alt="" class="img-fluid" width="40px"></i>
                        </li>
                        @else
                          <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-uppercase font-weight-bold">Login</a></li>
                          @if(Route::has('register'))
                          <li class="nav-item"><a href="{{ route('register') }}" class="nav-link text-uppercase font-weight-bold">Registe</a></li>
                          @endif
                        @endauth
                      @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="jumbotron ">
        <div class="row mt-5 mb-5">
          <div class="col-md-6 mb-5">
            <p class="title-1">SALAK SCALES <small>IOT</small> </p>
            <h3>Selamat Datang di Aplikasi Manajemen dan Monitorin Penjualan dan Pembelian Buah salak</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            @if(Route::has('login'))
            @else
            <a href="{{ route('register') }}" class="btn btn-warning">Mulai Bergabung</a>
            @endif
          </div>
          <div class="col-md-6 mb-5">
              <img class="img-fluid" src="public\image\tool.png" alt="">
          </div>
        </div>
    </div>
    <!-- content -->
    <div class="container-fluid mb-5">
      <div class="row">
        <div class="col-md-6 offset-md-2">
          <h3 class="font-weight-bold">Apa itu Aplikasi Salak Pondoh ?</h3>
          <hr class="line-title float-left">
          <br><br>
          <p>Aplikasi ini bertujuan untuk memudahkan anda dalam melakukan transaksi penjualan dan pembelian dengan bantuan teknologi IOT yang akan mempermudah dan membantu dalam meningkatkan kinerja dan mengorganisir usaha salak anda dengan baik sehingga memberikan manfaat yang lebih untuk kemanjuan usaha anda</p>
          <br>
          <img src="public\image\iotlogo.png" width="150px" alt="">
        </div>
        <div class="col-md-4">
          <div class="img-sizing">
            <img class="img-fluid" src="public\image\right-salak-photo.png" alt="">
          </div>
        </div>
      </div>
      <div class="bg-light p-4 ml-5 mt-5" style="border-radius: 50px 0px 0px 50px;">
        <div class="row ml-3 ">
          <div class="col-md-6">
            <h3 class="font-weight-bold">Apa itu IOT ?</h3>
            <hr class="line-title float-left">
            <br><br>
            <p>nternet of Things, atau dikenal juga dengan singkatan IoT) merupakan sebuah konsep yang bertujuan untuk memperluas manfaat dari konektivitas internet yang tersambung secara terus-menerus. Adapun kemampuan seperti berbagi data, remote control, dan sebagainya, termasuk juga pada benda di dunia nyata. Contohnya bahan pangan, elektronik, koleksi, peralatan apa saja, termasuk benda hidup yang semuanya tersambung ke jaringan lokal dan global melalui sensor yang tertanam dan selalu aktif.</p>
            <br>
            <div class="row">
              <div class="col-md-10 offset-md-1">
                <img src="public\image\iot.png" class="img-fluid"alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-md-4">
          <div class="img-sizing">
            <img src="public\image\leaf.png" class="img-fluid" alt="">
          </div>
        </div>
        <div class="col-md-6 offset-md-1">
          <h3 class="font-weight-bold">Tiga Tahap Bertransaksi di <br>Salak Pondoh </h3>
          <hr class="line-title float-left">
          <br><br>
            <ul class="list-style">
              <li class="list-item">
                <p>Memberikan Inputan baru dengan menimbang barang yang akan di jual ataupun di beli</p>
              </li>
              <li class="list-item">Proses pengiriman data ke Cloud akan dilakukan secara otomatis ketika penimbangan selesai dan memasukan data ke database</li>
              <li class="list-item">Aplikasi Web akan memproses dan menghitung semua inputan yang ada dan memberikan nota pembelian dan penjualan</li>
            </ul>
          <p>Aplikasi ini bertujuan untuk memudahkan anda dalam melakukan transaksi penjualan dan pembelian dengan bantuan teknologi IOT yang akan mempermudah dan membantu dalam meningkatkan kinerja dan mengorganisir usaha salak anda dengan baik sehingga memberikan manfaat yang lebih untuk kemanjuan usaha anda</p>
        </div>
      </div>
    </div>
    <!-- end content -->
    <footer>
      <div class="row">
        <div class="col-md-4 border border-secondary border-left-0 border-bottom-0 p-3">
          <h4 class="font-weight-bold ">TENTANG</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="col-md-4 border border-secondary border-left-0 border-bottom-0 border-right-0 p-3">
          <h4 class="font-weight-bold ">TENTANG</h4>
          <a href="#" class=" text-light" style="text-decoration:none;"> <img src="{{URL::asset('public\image\facebook.png')}}" alt="" style="height:30px; padding-right:10px; padding-bottom:5px;">Facebook</a><br>
          <p class="pl-5">salakpondoh</p>
          <a href="#" class=" text-light" style="text-decoration:none;"><img src="{{URL::asset('public\image\twiter.png')}}" alt="" style="height:30px; padding-right:10px; padding-bottom:5px;">Twiter</a><br>
          <p class="pl-5">@salakpondoh</p>
          <a href="#" class=" text-light" style="text-decoration:none;"><img src="{{URL::asset('public\image\instagram.png')}}" alt="" style="height:30px; padding-right:10px; padding-bottom:5px;">Instagram</a><br>
          <p class="pl-5">@salakpondoh</p>
        </div>
        <div class="col-md-4 border border-secondary border-right-0 border-bottom-0 p-3">
          <h4 class="font-weight-bold ">TENTANG</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
      </div>
      <hr class="border-secondary">
      <p class="blockquote-footer">Copyright © 2020 Salak Pondoh</p>
    </footer>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
  <script type="text/javascript">
      $(function () {
      $(window).on('scroll', function () {
              if ( $(window).scrollTop() > 10 ) {
                  $('.navbar').addClass('active');
              } else {
                  $('.navbar').removeClass('active');
              }
          });
        });
  </script>
  </body>
</html>
