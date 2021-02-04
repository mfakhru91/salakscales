@extends('layouts.master')
@section('title') Laporan Penjualan @endsection
@section('header')
<link rel="stylesheet" href="{{asset('public/css/laporan.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
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
        <h3 class="panel-title">Laporan Penjualan</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('jurnal-penjualan.index')}}" method="GET">
            <div class="row">
                <div class="col-md-2" >
                    @csrf
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="from" type="datetime" value="{{$from? $from : ''}}" name="from">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="sampai tanggal" id="to" value="{{$to? $to : ''}}" type="datetime" name="to">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="market_id">
                            <option value="">Pasar</option>
                            <@foreach($select_buyer as $by)
                            <option value="{{$by->id}}" {{ $by->id == $market ? 'selected' : '' }} >{{$by->market}}</option>
                            @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <br>
        @if($profit == null)
        @else
            @php
            $income_total = [];
            @endphp
            @foreach($profit as $pr)
                @php
                    $akomodasi = $pr->tools + $pr->packing + $pr->shipping_charges;
                    $total_akomodasi = $akomodasi * $pr->tonase;
                    $sum_income = $pr->income - $pr->price - $total_akomodasi;
                    array_push($income_total, $sum_income);
                    @endphp
            @endforeach
            @php
                    $sum_profit = array_sum($income_total);
            @endphp
        @endif

        {{--  table costume additional item  --}}
        <div class="table-costume-additional-item">
            <table class="table table-striped table-bordered costume-export" style="counter-reset: rowNumber;">
                <thead>
                    @if($dvitem == null)
                    @else
                    @if($market)
                    @foreach($buyer->where('id',$market) as $item)
                    <tr>
                        <th colspan="8" class="text-center" style="text-align: center">{{ $item->market }}</th>
                    </tr>
                    @endforeach
                    @else
                    @endif
                    @endif
                    <tr>
                        <th colspan="8">
                            <h3>Laporan Pembelian</h3>
                        </th>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <th colspan="7">: <span> </span> {{ $from }} - {{ $to }}</th>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Pasar</th>
                        <th colspan="2">Tonase</th>
                        <th>Price</th>
                        <th>Nota</th>
                        <th>Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @if($dvitem == null)
                    @else
                    @foreach($dvitem as $item)
                    @foreach($buyer->where('id',$item->buyer_Id) as $by)
                    <tr>
                        <td>{{$item->date_time}}</td>
                        <td>{{$by->name}}</td>
                        <td>{{$by->market}}</td>
                        <td>{{$item->new_tonase}}</td>
                        <td width="1px" class="text-center">Kg</td>
                        <td>Rp.{{ number_format($item->price, 2, ',', '.')}}</td>
                        <td>{{$item->note_id}}</td>
                        <td>Rp.{{ number_format($item->income, 2, ',', '.')}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endif
                    <tr>
                        <th colspan="7">Total</th>
                        <th>
                            @if($profit == null)
                            @else
                                Rp.{{ number_format($profit->sum('income'), 2, ',', '.')}}
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td colspan="5" style="border: 0px; background-color: white;"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border: 0px; background-color: white;"></td>
                    </tr>
                    <tr>
                        <th colspan="5" style="background-color: white;">Total Keseluruhan</th>
                    </tr>
                    <tr>
                        <th>Pasar</th>
                        <th>Akomodasi</th>
                        <th>Harga</th>
                        <th>Penjualan</th>
                        <th>Kenutungan</th>
                    </tr>
                    @if($profit == null)
                    @else
                    @foreach($profit as $by)
                    @php
                    $addakomodasi = $by->tools + $by->packing + $by->shipping_charges;
                    $addtotal_akomodasi = $addakomodasi * $by->tonase;
                    $addsum_income = $by->income - $by->price - $addtotal_akomodasi;
                    @endphp
                    <tr>
                        <td>{{ $by->market }}</td>
                        <td>Rp.{{ number_format($addtotal_akomodasi, 2, ',', '.')}}</td>
                        <td>Rp.{{ number_format($by->price, 2, ',', '.')}}</td>
                        <td>Rp.{{ number_format($by->income, 2, ',', '.')}}</td>
                        <td>
                            @if($addtotal_akomodasi == 0)
                                Rp.0,00
                            @else
                            Rp.{{ number_format($by->income - $by->price - $addtotal_akomodasi, 2, ',', '.')}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        @if($items == null)
                        @else
                        </tr>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>
                                Rp.{{ number_format( $sum_profit, 2, ',', '.')}}
                        </tr>
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
        <button class="export-costume btn btn-primary btn-block" id="exportCostume">
            Export
        </button>
        {{--  end table costume additional item  --}}

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