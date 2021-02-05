@extends('layouts.master')
@section('title') Laporan Laba Rugi @endsection
@section('content')
@section('header')
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@php
    $mstates = [];
@endphp
@foreach($profit as $mp)
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
@php
$arr_additional_item = [];
@endphp
@foreach($additem as $item)
    @php
       $get_price = $item->unit * $item->price;
       array_push($arr_additional_item,$get_price);
    @endphp
@endforeach
@php
    $additional_item_total = array_sum($arr_additional_item);
@endphp
<div class="row">
    <div class="col-md-7">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Laporan Laba Rugi</h3>
            </div>
            <div class="panel-body">
                <div id="dataprint">
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4">
                                <div class="text-center">
                                    <h3>Laporan Laba/Rugi</h3>
                                    Untuk Periode {{ $start_day }} Sampai {{$end_day}}
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">Pendapatan Penjualan</th>
                        </tr>
                        <tr>
                            <th colspan="4">Penjualan Tiap Pasar :</th>
                        </tr>
                        @foreach($profit as $by)
                        <tr>
                            <td style="width: 150px"></td>
                            <th>{{$by->market}}</th>
                            <td colspan="2">Rp. {{number_format($by->income, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Akomodasi</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Harga Alat</td>
                            <td>Rp. {{number_format($by->tools * $by->tonase, 2, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ongkos Kirim</td>
                            <td>Rp. {{ number_format($by->packing * $by->tonase, 2, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ongkos Kirim</td>
                            <td>Rp. {{ number_format($by->shipping_charges * $by->tonase, 2, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>
                                @php
                                    $sub_total_akomodasi = $by->tools + $by->packing + $by->shipping_charges;
                                    $total_akomodasi_final = $sub_total_akomodasi * $by->tonase;
                                    $income = $by->income - $by->price - $total_akomodasi_final;
                                @endphp
                                Rp. {{number_format($income, 2, ',', '.')}}
                            </th>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Laba Kotor</th>
                            <th>Rp. {{number_format($monthly_profit, 2, ',', '.')}}</th>
                        </tr>
                        <tr>
                            <th colspan="4">Pengeluaran</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Pembelian lain</td>
                            <td>Rp. {{number_format($additional_item_total, 2, ',', '.')}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>Rp. {{number_format($additional_item_total, 2, ',', '.')}}</th>
                        </tr>
                        <tr>
                            <th colspan="3">Laba Bersih</th>
                            <th>Rp. {{number_format($monthly_profit - $additional_item_total, 2, ',', '.')}}</th>
                        </tr>
                    </table>
                </div>
                <button type="button"  class="btn btn-primary btn-block" onclick="printJS({ printable: 'dataprint', type: 'html', css:'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',showModal:true})">
                    <span class="lnr lnr-printer"></span> Print
                </button></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
@endsection

