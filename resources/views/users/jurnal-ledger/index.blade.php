@extends('layouts.master')
@section('title') Jurnal Ledger @endsection
@section('content')
@section('header')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@php
    $lastIncome = '800000';
@endphp
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Jurnal Ledger</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('jurnal-pembelian.index')}}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3" >
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="dateFrom" type="datetime" name="date_from">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" >
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="sampai tanggal" id="dateTo" type="datetime" name="date_to">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="payment" id="payment">
                          <option value="" >Jenis Transaksi</option>
                          <option value="paid off">Debet</option>
                          <option value="debt">Kredit</option>
                        </select>
                      </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
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
                    <td></td>
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( document ).ready(function() {
        console.log( "ready!" );
        $( "#from" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $( "#to" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#dateFrom").datepicker({
            dateFormat: 'yy-mm-dd'
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
                    defaultFileName: "Bookkeeping Pembelian",
                    Number : true,
                }
                );
                table2excel.export(document.getElementById("export-pembelian"));
            }
        })
    });
</script>
@endsection