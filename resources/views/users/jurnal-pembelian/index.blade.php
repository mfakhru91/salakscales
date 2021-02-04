@extends('layouts.master')
@section('title') Laporan Pembelian @endsection
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
        <h3 class="panel-title">Laporan Pembelian</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('jurnal-pembelian.index')}}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3" >
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="dateFrom" type="datetime" value="{{$datefrom? $datefrom : ''}}" name="date_from">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" >
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="dateTo" type="datetime" value="{{$dateto? $dateto : ''}}" name="date_to">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="payment" id="payment">
                          <option value="" >Pembelian</option>
                          <option value="paid off" {{ $pembayaran ==  'paid off'? 'selected':''}}>Lunas</option>
                          <option value="debt" {{ $pembayaran ==  'debt'? 'selected':''}}>Hutang</option>
                        </select>
                      </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class=" table table-striped table-bordered" id="export-pembelian">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <h3>Jurnal Pembelian</h3>
                            </th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th colspan="6">: <span> </span>{{ $datefrom }} - {{ $dateto }} </th>
                        </tr>
                        <tr>
                            <th width="120px">Tanggal</th>
                            <th>Nama Penjual</th>
                            <th colspan="2">Tonase</th>
                            <th>Harga</th>
                            <th>Pembayaran</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($seller_item == null && $seller == null)
                        @else
                        @foreach($seller_item as $item)
                        @foreach($seller->where('id', $item->seller_id) as $sl)
                        <tr>
                            <td>{{ $item->date_reporting($item->created_at) }}</td>
                            <td>{{ $sl->name }}</td>
                            <td>{{ $item->tonase }}</td>
                            <td>Kg</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                @if($item->payment == 'paid off')
                                    Lunas
                                @else
                                    Hutang
                                @endif
                            </td>
                            <td>{{ $item->note_id }}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        <tr></tr>
                        @endif

                    </tbody>
                </table>
                <button class="export-costume btn btn-primary btn-block" id="exportPembelian">
                    Export
                </button>
            </div>
        </div>
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