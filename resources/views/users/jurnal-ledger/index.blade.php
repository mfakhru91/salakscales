@extends('layouts.master')
@section('title') Buku Besar @endsection
@section('content')
@section('header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
@endsection
@php
$arr_laba_kotor = [];
$arr_additional_item = [];
@endphp
@if($profit == null || $profit == '0')
array_push($arr_laba_kotor,"0");
array_push($arr_additional_item,"0");
@else
@foreach($profit as $by)
    @php
        $laba_kotor = $by->income - $by->price - ($by->tools * $by->tonase) - ($by->packing * $by->tonase) - ($by->shipping_charges);
        array_push($arr_laba_kotor,$laba_kotor);
    @endphp
@endforeach
@foreach($additem as $item)
    @php
       $get_price = $item->unit * $item->price;
       array_push($arr_additional_item,$get_price);
    @endphp
@endforeach
@endif
@php
    $laba_kotor_total = array_sum($arr_laba_kotor);
    $additional_item_total = array_sum($arr_additional_item);
    $lastIncome = $laba_kotor_total - $additional_item_total
@endphp
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Buku Besar</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('jurnal-pembelian.index')}}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-2" >
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="Pilih Bulan" id="month" type="datetime" name="date_from">
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
        <table class="table table-striped table-bordered" id="exportBukuBesar">
            <thead>
                <tr>
                    <th class="text-center" colspan="5">
                        <h3>Laporan Buku Besar</h3>
                        Catatan laporan buku besar antara tanggal
                    </th>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Keuntungan Bulan Lalu</td>
                    <td>{{$last_date}}</td>
                    <td>Rp. 0,00</td>
                    <td>Rp. 0,00</td>
                    <td>
                        Rp. {{number_format($lastIncome , 2, ',', '.')}}
                    </td>
                </tr>
                @foreach($data as $dt)
                <tr>
                    <td>{{ $dt->description }}</td>
                    <td>{{ $dt->date }}</td>
                    @if($dt->status == "debet")
                        <td>Rp. {{number_format($dt->nominal , 2, ',', '.')}}</td>
                        <td>Rp. 0,00</td>
                    @else
                        <td>Rp. 0,00</td>
                        <td>Rp. {{number_format($dt->nominal , 2, ',', '.')}}</td>
                    @endif
                    <td>
                        @php
                            if($dt->status == "kredit")
                            {
                                $lastIncome = $lastIncome - $dt->nominal;
                            }else{
                                $lastIncome = $lastIncome + $dt->nominal;
                            }
                        @endphp
                        Rp. {{number_format($lastIncome , 2, ',', '.')}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button class="export-costume btn btn-primary btn-block" id="exportPembelian">
            Export
        </button>
    </div>
</div>
@endsection
@section('footer')
<script src="{{asset('public/js/jquery-3.5.1.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{asset('public/js/table2excel.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( document ).ready(function() {
        console.log( "ready!" );
        $("#month").datepicker({
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function (dateText, inst) {
              var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
              var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
              $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
          });
        $("#month").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
              my: "center top",
              at: "center bottom",
              of: $(this)
            });
          });
        $("#dateTo").datepicker({
            dateFormat: 'yy-mm-dd'
        })
        $("#exportCostume").click(function(){
            var table2excel = new Table2Excel({
                defaultFileName: "Bookkeeping Costume",
                Number : true,
            }
            );
            table2excel.export(document.getElementsByClassName("costume-export"));
        })
        $("#exportPembelian").click(function(){
            const dateFrom = $("#dateFrom").val()
            const dateTo = $("#dateTo").val()
            if( dateFrom == '' || dateTo == ''){
                alert("pilih tanggal atau pembayaran terlebih dahulu")
            }else{
                var table2excel = new Table2Excel({
                    defaultFileName: "Laporan Buku Besar",
                    Number : true,
                }
                );
                table2excel.export(document.getElementById("exportBukuBesar"));
            }
        })
    });
</script>
@endsection