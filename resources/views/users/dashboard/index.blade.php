@extends('layouts.master')
@section('title')Dashboard @endsection
@section('header')
<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
@endsection
@section('content')
@if(session('status'))
  <div class="alert alert-warning alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <i class="fa fa-check-circle"></i> {{session('status')}}
  </div>
@endif
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">Weekly Overview</h3>
	</div>
	<div class="panel-body">
		@php
			$nishab = $price->sum('total_price') - $debt->sum('debt');
			$zakat = $price->sum('total_price') - $debt->sum('debt') * 2.5 / 100;
			$penjualan = $price->sum('total_price');
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fa fa-shopping-cart"></i></span>
					<p>
						<span class="number">Rp {{ number_format($priceyear->sum('total_price'), 2, ',', '.') }}</span>
						<span class="title">Total Penjualan/Tahun</span>
					</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fa fa-shopping-cart"></i></span>
					<p>
						<span class="number">Rp {{ number_format($price->sum('total_price'), 2, ',', '.') }}</span>
						<span class="title">Total Penjualan/bulan</span>
					</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fas fa-credit-card"></i></span>
					<p>
						<span class="number">Rp {{ number_format($debt->sum('debt'), 2, ',', '.') }}</span>
						<span class="title">Hutang</span>
					</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fas fa-money-bill-wave-alt"></i></span>
					<p>
						@if($price->sum('total_price') - $debt->sum('debt') <= 0)
							<span class="number">Rp {{ number_format($debt->sum('debt')-$price->sum('total_price'), 2, ',', '.') }}</span>
							<span class="title">Rugi</span>
						@else
							<span class="number">Rp {{ number_format($price->sum('total_price')  , 2,',', '.') }}</span>
							<span class="title">Profit</span>
						@endif
					</p>
				</div>
			</div>
		</div>
		{{--  panel 2  --}}
		<div class="row">
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
					<p>
						@if($zakat >= 85000000)
							<span class="number">Rp {{ number_format($price->sum('total_price') - $debt->sum('debt'), 2, ',', '.') }}</span>
						@else
							<span class="number">Rp 0,00</span>
						@endif
						<span class="title">Zakat</span>
					</p>
				</div>
			</div>
			<div class="col-md-3">
				<div class="metric">
					<span class="icon"><i class="fas fa-box"></i></span>
					<p>
						<span class="number">{{ $item->sum('item_count') }}</span>
						<span class="title">Barang</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Zakat Yang Harus Dikeluaran</h3>
				<div class="right">
					<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('metal.store')}}" method="POST" class="form-inline">
					@csrf
					<div class="form-group mx-sm-3 mr-2">
						<input type="text" class="form-control" value="Emas" disabled style="width: 60px">
						<label for="inputPassword2" class="sr-only">Data Emas</label>
						<input type="number" class="form-control" id="inputPassword2" placeholder="Harga" name="price">
						<small></small>
					</div>
					<button type="submit" class="btn btn-primary mb-2 mr-2">kirim</button>
				</form>
				<small>* Masukan <a href="https://www.indogold.id/harga-emas-hari-ini"> <b>penjualan emas/perak</b> </a> terbaru untuk mendapatkan nishab</small>
				<div class="print" style="margin-top:20px">
					<table class="table table-bordered">
						<tr>
							<td colspan="2">
								<div class="text-center">
									Total Keuntungan - Zakat
								</div>
							</td>
						</tr>
						@if(empty($metals))
						<tr>
							<th>Harga Emas</th>
							<td>Rp. 0</td>
						</tr>
						<tr>
							<th>Nisab</th>
							<td>Rp. 0</td>
						</tr>
						@else
						<tr>
							<th>Harga {{ $metals->type }}</th>
							<td>Rp. {{ number_format($metals->price, 2, ',', '.') }}</td>
						</tr>
						<tr>
							<th>Nisab</th>
							<td>Rp. {{ number_format($metals->price * 85, 2, ',', '.') }}</td>
						</tr>
						@if($priceyear->sum('total_price') >= $metals->price * 85)
						<tr>
							<th>Zakat</th>
							<td>Rp.100.00.000,00</td>
						</tr>
						@else
						<tr>
							<th>Zakat</th>
							<td>Rp.0</td>
						</tr>
						@endif
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Data Penjualan Pasar</h3>
				<div class="right">
					<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
				</div>
			</div>
			<div class="panel-body">
				<canvas id="myChart"  class="ct-chart" height="100px"></canvas>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
			label: 'Pasar 1',
			data: [620, 380, 350, 320, 410, 450, 570, 400, 555,433, 750, 900],
			backgroundColor: 'rgba(54, 162, 235, 1)',
			borderColor:'rgba(54, 162, 235, 1)',
			fill: false,
		},
		{
            label: 'Pasar 2',
            data: [200,900],
            backgroundColor: 'rgba(255, 99, 132, 1)',
			borderColor:'rgba(255, 99, 132, 1)',
			data: [400, 555, 620, 750, 900,200, 380, 350, 320, 232, 450, 570],
			fill: false,
		},
		{
            label: 'Pasar 3',
            data: [200,900],
            backgroundColor: 'orange',
			borderColor:'orange',
			data: [ 900,200, 380, 350,400, 555, 620, 750,320, 232, 450, 570],
			fill: false,
		},
		]
    },
    options: {
        height: "300px",
		showPoint: true,
		axisX: {
			showGrid: false
		},
		lineSmooth: false,
    }
});
</script>
@endsection