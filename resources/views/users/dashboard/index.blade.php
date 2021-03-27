@extends('layouts.master')
@section('title')Dashboard @endsection
@section('header')
    <link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
@endsection
@section('content')
    @php
    $ystates = [];
    $ystates_g = [];
    $additional_sum = [];
    $additional_sum_hijri = [];
    $day_additional_sum = [];
    @endphp
    @foreach ($items as $item)
        @php
            $total_additional_items = $item->unit * $item->price;
            array_push($additional_sum, $total_additional_items);
        @endphp
    @endforeach
    @foreach ($dayItem as $ditem)
        @php
            $total_additional_items = $ditem->unit * $ditem->price;
            array_push($day_additional_sum, $total_additional_items);
        @endphp
    @endforeach
    @foreach ($hijri_items as $hijri_items)
        @php
            $total_additional_items = $hijri_items->unit * $hijri_items->price;
            array_push($additional_sum_hijri, $total_additional_items);
        @endphp
    @endforeach
    @php
    $final_additional_item = array_sum($additional_sum);
    $final_additional_item_hijri = array_sum($additional_sum_hijri);
    @endphp
    @foreach ($yprofit as $yp)
        @php
            $total_akomodasi = $yp->tools * $yp->tonase + $yp->packing * $yp->tonase + $yp->shipping_charges * $yp->tonase;
            $sum_income = $yp->income - $yp->price - $total_akomodasi;
            array_push($ystates, $sum_income);
        @endphp
    @endforeach
    @foreach ($yprofit_gregorian as $yg)
        @php
            $total_akomodasi = $yg->tools * $yg->tonase + $yg->packing * $yg->tonase + $yg->shipping_charges * $yg->tonase;
            $sum_income = $yg->income - $yg->price - $total_akomodasi;
            array_push($ystates_g, $sum_income);
        @endphp
    @endforeach
    @php
    $year_profit = array_sum($ystates);
    $year_profit_g = array_sum($ystates_g);
    @endphp
    @php
    $arr_additional_item = [];
    @endphp
    @foreach ($additionaltem as $item)
        @php
            $get_price = $item->unit * $item->price;
            array_push($arr_additional_item, $get_price);
        @endphp
    @endforeach
    @php
    $additional_item_total = array_sum($arr_additional_item);
    $additional_item_day_total = array_sum($day_additional_sum);
    @endphp
    @if ($hijri_mont == $hijri_haul_month && $hijri_year == $hijri_haul_year+1)
		@if ($hijri_mont == $hijri_haul_month )
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4><i class="fa fa-check-circle"></i> keuntungan yang anda miliki telah memenuhi nishab untuk membayar zakat
					sebesar Rp {{ number_format((($year_profit - $final_additional_item) * 2.5) / 100, 2, ',', '.') }}</h1>
            </div>
        @endif
    @endif
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Pengertian Zakat</h3>
        </div>
        <div class="panel-body">
            <p>Pengertian zakat menurut Bahasa berarti “ النماء والريع والزىادة ” (bertambah atau tumbuh). Makna ini dappat
                dapat dilihat dari perkataan ‘Ali bin Abi Thalib radhiyallahu ‘anhu. Zakat dalam istilah syar’i, berarti
                penunaian kewajiban pada harta yang khusus, dengan cara khusus, serta disyaratkan ketika ditunaikan ketika
                telah mencapai haul (masa satu tahun) serta telah mencapai nishob (standar minimal harta sehingga ia wajib
                dizakati). Zakat juga memiliki arti “harta yang dikeluarkan”. Serta Muzzakki adalah istilah untuk orang yang
                memiliki harta dan mengeluarkan zakatnya. </p>
            <br>
            <p>Adapun Rumus untuk mengeluarkan zakat yaitu :</p>
            <div class="row">
                <div class="col-md-3">
                    <div class="metric">
                        <span>&emsp;Total keuntungan bersih x 2,5%</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="metric" style="border:none;">
                        <span>atau </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="metric">
                        <span>&emsp;Total keuntungan bersih x 2,5 : 100</span>
                    </div>
                </div>
            </div>
            <p>dengan ketentuan telah mencapai <b>Nishab</b> yang setara denga <b>85 gram emas</b> dan telah mencapai
                <b>Haul</b>
            </p>
            <br>
            <h4>Pengertian Nisab dan Haul</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="metric">
                        <span>
                            <b>Haul</b> <br>
                            <hr>
                            adalah satu tahun atau 12 bulan sebagai batas waktu mengeluarkan zakat. Sedangkan, istilah
                            mencapai haul adalah apabila suatu aset dimiliki oleh seseorang selama 12 bulan
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="metric">
                        <span>
                            <b>Nisab</b> <br>
                            <hr>
                            Nisab, di dalam Syariah adalah jumlah batasan kepemilikan seorang Muslim selama satu tahun untuk
                            wajib mengeluarkan zakat.
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <h3>Untuk pengertian lebih lanjut silahkan klik link <a href="{{ route('zakat.understanding') }}"> <u>tentang zakat perniagaan</u> </a></h3>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="metric">
                <span class="icon"><i class="fas fa-hand-holding-usd"></i></span>
                <p>
                    @if ($year_profit - $final_additional_item_hijri >= $goldprice * 85)
						@if ($hijri_mont == $hijri_haul_month && $hijri_year == $hijri_haul_year+1)
                            <span class="number">Rp.
                                {{ number_format((($year_profit - $final_additional_item_hijri) * 2.5) / 100, 2, ',', '.') }}</span>
                        @else
                            <span class="number">Rp. 0,00</span>
                        @endif
                    @else
                        <span class="number">Rp. 0,00</span>
                    @endif
                    <span class="title">Zakat</span>
                </p>
            </div>
        </div>
    </div>
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
                            @foreach ($dprofit as $dp)
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
                            @if ($daily_profit == 0 || $daily_profit <= 0)
                                <span class="number">Rp
                                    {{ number_format($daily_profit - $additional_item_day_total, 2, ',', '.') }}</span>
                                <span class="title">Keuntungan Harian</span>
                            @else
                                <span class="number">Rp {{ number_format($daily_profit, 2, ',', '.') }}</span>
                                <span class="title">Keuntungan Harian</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- !! pengertian zakat !! -->
    <div class="panel">
        @php
            $mstates = [];
        @endphp
        @foreach ($mprofit as $mp)
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
                $zakat = $price->sum('total_price') - ($debt->sum('debt') * 2.5) / 100;
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
                            <span class="number">Rp
                                {{ number_format($monthly_profit - $additional_item_total, 2, ',', '.') }}</span>
                            <span class="title">Keuntungan</span>
                        </p>
                    </div>
                </div>
            </div>
            {{-- panel 2 --}}
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
                            <span class="number">{{ $mprofit->sum('tonase') }} Kg</span>
                            <span class="title">Tonase</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="metric">
                        <span class="icon"><i class="fas fa-truck"></i></span>
                        <p>
                            <span
                                class="number">{{ $deliveryItem->sum('dvitem') - $dvitems->sum('dvcounting') }}/{{ $deliveryItem->sum('dvitem') }}</span>
                            <span class="title">Pengiriman Bulan ini</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Data Penjualan Tahunan</h3>
        </div>
        <div class="panel-body">
            <div class="metric">
                <span class="icon"><i class="fas fa-wallet"></i></span>
                <p>
                    <span class="number">Rp.
                        {{ number_format($year_profit_g - $final_additional_item, 2, ',', '.') }}</span>
                    <span class="title">Keuntungan Tahun Ini</span>
                </p>
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
                    @if ($connection == 'no_internet_access')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            tidak ada jaringan internet silahkan cek kembali internet anda
                        </div>
                    @endif
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
                                <td>Total Keuntungan Bersih Dalam 1 Tahun (Hijriah)</td>
                                <td>Rp. {{ number_format($year_profit - $final_additional_item_hijri, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nisab</th>
                                <td>Rp. {{ number_format($goldprice * 85, 2, ',', '.') }}</td>
                            </tr>
                            @if ($year_profit - $final_additional_item_hijri >= $goldprice * 85)
                                <tr>
                                    <th>Zakat</th>
                                    @if ($hijri_mont == $hijri_haul_month && $hijri_year == $hijri_haul_year+1)
                                        <td>Rp
                                            {{ number_format((($year_profit - $final_additional_item_hijri) * 2.5) / 100, 2, ',', '.') }}
                                        </td>
                                    @else
                                        <td>Rp.0,00</td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <th>Zakat</th>
                                    <td>Rp.0,00</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($dayItem as $a)
            @php
            @endphp
        @endforeach
    </div>
@endsection
@section('footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
			@if ($zakatcheck->nishab != null)
				if ({{ $year_profit - $final_additional_item_hijri }} < {{$zakatcheck->nishab }}) {
					$.ajax({
						url: "{{ config('app.url') }}" + "/api/zakat/haul/" + {{ Auth::id() }},
						type: "PUT",
						async: true,
						success: function(result) {
						}
					});
				}
			@else
			if ({{ $year_profit - $final_additional_item_hijri >= $goldprice * 85 }}) {
				$.ajax({
					url: "{{ config('app.url') }}" + "/api/zakat/" + {{ Auth::id() }},
					type: "PUT",
					data: "start_haul=" + today + "&nishab=" + {{ $year_profit }},
					async: true,
					success: function(result) {
					}
				});
			}
			@endif
        })

    </script>
@endsection
