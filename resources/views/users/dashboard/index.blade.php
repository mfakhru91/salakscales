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
		<h3 class="panel-title">Data Penjualan Harian</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fa fa-shopping-cart"></i></span>
					<p>
						<span class="number">Rp {{ number_format($dprofit->sum('price'), 2, ',', '.') }}</span>
						<span class="title">Total Pembelian</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fas fa-poll"></i></i></span>
					<p>
						<span class="number">Rp {{ number_format($dprofit->sum('income'), 2, ',', '.') }}</span>
						<span class="title">Total Penjualan</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric bg-info">
					<span class="icon"><i class="fas fa-wallet"></i></i></span>
					<p>
						@php
							$dstates = [];
						@endphp
						@foreach($dprofit as $dp)
							@php
								$akomodasi = $dp->tools + $dp->packing + $dp->shipping_charges;
								$total_akomodasi = $akomodasi * $dp->tonase;
								$sum_income = $dp->income - $dp->price - $total_akomodasi;
								array_push($dstates, $sum_income);
							@endphp
						@endforeach
						@php
							 $daily_profit = array_sum($dstates);
						@endphp
						<span class="number">Rp {{ number_format($daily_profit, 2, ',', '.') }}</span>
						<span class="title">Keuntungan Harian</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="panel">
	@php
		$mstates = [];
	@endphp
	@foreach($mprofit as $mp)
		@php
			$akomodasi = $mp->tools + $mp->packing + $mp->shipping_charges;
			$total_akomodasi = $akomodasi * $mp->tonase;
			$sum_income = $mp->income - $mp->price - $total_akomodasi;
			array_push($mstates, $sum_income);
		@endphp
	@endforeach
	@php
			$monthly_profit = array_sum($mstates);
	@endphp
	<div class="panel-heading">
		<h3 class="panel-title">Data Penjualan Bulanan</h3>
	</div>
	<div class="panel-body">
		@php
			$nishab = $price->sum('total_price') - $debt->sum('debt');
			$zakat = $price->sum('total_price') - $debt->sum('debt') * 2.5 / 100;
			$penjualan = $price->sum('total_price');
		@endphp
		<div class="row">
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fa fa-shopping-cart"></i></span>
					<p>
						<span class="number">Rp {{ number_format($mprofit->sum('price'), 2, ',', '.') }}</span>
						<span class="title">Total Pembelian/Bulan</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fas fa-poll"></i></i></span>
					<p>
						<span class="number">Rp {{ number_format($mprofit->sum('income'), 2, ',', '.') }}</span>
						<span class="title">Total Penjualan/bulan</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric bg-info">
					<span class="icon"><i class="fas fa-wallet"></i></i></span>
					<p>
						<span class="number">Rp {{ number_format($monthly_profit, 2, ',', '.') }}</span>
						<span class="title">Keuntungan</span>
					</p>
				</div>
			</div>
		</div>
		{{--  panel 2  --}}
		<div class="row">
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fas fa-credit-card"></i></span>
					<p>
						<span class="number">Rp {{ number_format($debt->sum('debt'), 2, ',', '.') }}</span>
						<span class="title">Hutang</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fas fa-balance-scale"></i></span>
					<p>
						<span class="number">{{$mprofit->sum('tonase')}} Kg</span>
						<span class="title">Tonase</span>
					</p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="metric">
					<span class="icon"><i class="fas fa-truck"></i></span>
					<p>
						<span class="number">{{$deliveryItem->sum('dvitem') - $dvitems->sum('dvcounting') }}/{{ $deliveryItem->sum('dvitem') }}</span>
						<span class="title">Pengiriman Bulan ini</span>
					</p>
				</div>
			</div>
		</div>
		{{-- panel 3 --}}
		<div class="row">
			<div class="col-md-12">
				<div class="metric">
					<span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
					<p>
						@if($yprofit->sum('yincome') >= $goldprice * 85)
							<span class="number">Rp {{number_format($goldprice->sum('yincome') * 2.5/100, 2, ',', '.')}}</span>
						@else
							<span class="number">Rp 0,00</span>
						@endif
						<span class="title">Zakat</span>
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
				<div class="row">
					<div class="col-md-12">
						<div class="metric bg-warning">
							<span class="icon"><i class="fas fa-ring"></i></span>
							<p>
								<span class="number">Rp {{ number_format($goldprice, 2, ',', '.') }}</span>
								<span class="title">Harga emas hari ini</span>
							</p>
						</div>
					</div>
				</div>
				<div class="print" style="margin-top:20px">
					<table class="table table-bordered">
						<tr>
							<td colspan="2">
								<div class="text-center">
									Total Keuntungan - Zakat
								</div>
							</td>
						</tr>
						<tr>
							<th>Harga Emas</th>
							<td>Rp. {{ number_format($goldprice, 2, ',', '.') }}</td>
						</tr>
						<tr>
							<th>Nisab</th>
							<td>Rp. {{ number_format($goldprice * 85, 2, ',', '.') }}</td>
						</tr>
						@if($yprofit->sum('yincome') >= $goldprice * 85)
						<tr>
							<th>Zakat</th>
							<td>Rp {{number_format($yprofit->sum('yincome') * 2.5/100, 2, ',', '.')}}</td>
						</tr>
						@else
						<tr>
							<th>Zakat</th>
							<td>Rp.0</td>
						</tr>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
	@foreach($dayItem as $a)
	@php
	@endphp
	@endforeach
</div>
@endsection
@section('footer')
@endsection