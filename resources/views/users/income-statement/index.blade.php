@extends('layouts.master')
@section('title') Laporan Laba Rugi @endsection
@section('content')
@section('header')
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@php
$mstates = [];
$arr_tools = [];
$arr_packing = [];
$arr_shipping_charges = [];
$arr_buting_price = [];
@endphp
@foreach ($profit as $mp)
    @php
        $tools = $mp->tools * $mp->tonase;
        $packing = $mp->packing * $mp->tonase;
        $shipping_charges = $mp->shipping_charges * $mp->tonase;
        $sum_income = $mp->income;
        $sum_price = $mp->price;
        array_push($arr_tools, $tools);
        array_push($arr_packing, $packing);
        array_push($arr_shipping_charges, $shipping_charges);
        array_push($mstates, $sum_income);
        array_push($arr_buting_price, $sum_price);
    @endphp
@endforeach
@php
$monthly_profit = array_sum($mstates);
$total_tools = array_sum($arr_tools);
$total_packing = array_sum($arr_packing);
$total_shipping_charges = array_sum($arr_shipping_charges);
$total_buying_price = array_sum($arr_buting_price);
@endphp
@php
$arr_additional_item = [];
@endphp
@foreach ($additem as $item)
    @php
        $get_price = $item->unit * $item->price;
        array_push($arr_additional_item, $get_price);
    @endphp
@endforeach
@php
$additional_item_total = array_sum($arr_additional_item);
@endphp

{{-- year income total --}}

@php
$year_additem = [];
$year_income = [];
@endphp

@foreach ($profitYear as $profir)
    @php
        $total_akomodasi = $profir->tools * $profir->tonase + $profir->packing * $profir->tonase + $profir->shipping_charges * $profir->tonase;
        $sum_income = $profir->income - $profir->price - $total_akomodasi;
        array_push($year_income, $sum_income);
    @endphp
@endforeach

@foreach ($additionaltemYear as $item)
    @php
        $total_additional_items = $item->unit * $item->price;
        array_push($year_additem, $total_additional_items);
    @endphp
@endforeach

@php
$year_profit = array_sum($year_income);
$year_additem_total = array_sum($year_additem);
@endphp


{{-- end year income total --}}
<div class="row">
    <div class="col-md-7">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Laporan Laba Rugi</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('laporan-laba-rugi.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input class="form-control datepicker" @if ($date_selected == null) placeholder="Pilih Bulan" @else value="{{ $date_selected }}" @endif id="month" type="datetime" name="month">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                    <br>
                </form>
                <div id="dataprint">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4">
                                <div class="text-center">
                                    <h5>Salak Pondoh - {{ Auth::user()->business_name }}</h5>
                                    <h3 style="margin-top: 0px">Laporan Laba Rugi</h3>
                                    Untuk Periode {{ $start_day }} Sampai {{ $end_day }}
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">Pendapatan Penjualan</th>
                        </tr>
                        <tr>
                            <td style="width: 150px"></td>
                            <th>Penjualan Bersih</th>
                            <td colspan="2">Rp. {{ number_format($monthly_profit, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th colspan="3">Total Pendapatan</th>
                            <th>Rp. {{ number_format($monthly_profit, 2, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4">Pengeluaran</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pembelian Alat</td>
                            <td>Rp. {{ number_format($total_tools, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Gaji Kariyawan</td>
                            <td>Rp. {{ number_format($total_packing, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ongkos Kirim</td>
                            <td>Rp. {{ number_format($total_shipping_charges, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pembelian Salak</td>
                            <td>Rp. {{ number_format($total_buying_price, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pembelian lain</td>
                            <td>Rp. {{ number_format($additional_item_total, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">Total</th>
                            @php
                                $total_pengeluaran = $additional_item_total + $total_buying_price + $total_shipping_charges + $total_packing + $total_tools;
                            @endphp
                            <th>Rp. {{ number_format($total_pengeluaran, 2, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3">Laba Bersih</th>
                            <th>Rp. {{ number_format($monthly_profit - $total_pengeluaran, 2, ',', '.') }}</th>
                        </tr>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-block"
                    onclick="printJS({ printable: 'dataprint', type: 'html', css:'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',showModal:true})">
                    <span class="lnr lnr-printer"></span> Print
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Total Keuntungan 1 tahun</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="metric">
                            <span class="icon"><i class="fas fa-poll"></i></i></span>
                            <p>
                                <span class="number">Rp
                                    {{ number_format($year_profit - $year_additem_total, 2, ',', '.') }}</span>
                                <span class="title">Total Penjualan</span>
                            </p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('incomestatement.year') }}" class="btn btn-primary btn-block">detail</a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer')
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="{{ asset('public/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{ asset('public/js/table2excel.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        console.log("ready!");
        $("#month").datepicker({
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });
        $("#month").focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
    });

</script>
@endsection
