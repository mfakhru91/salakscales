@extends('layouts.master')
@section('title') barang @endsection
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
        <h3 class="panel-title">Pembelian Lainya</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('additional-item.export')}}" method="GET">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-2" >
                    @csrf
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="datefrom" type="datetime" name="from">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" >
                    @csrf
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="sampai tanggal" id="dateto" type="datetime" name="to">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-9">
                <table style="margin-top: 10px" class="table table-striped table-bordered"  id="export" style="counter-reset: rowNumber;">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <h3>Pembelian Lainya</h3>
                            </th>
                        </tr>
                        <tr>
                            <th width="150px">Tanggal</th>
                            <th>Nama</th>
                            <th width="10px">jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($month_item as $item)
                        <tr>
                            <td>{{$item->date}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->unit}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->unit * $item->price}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="export-costume btn btn-primary btn-block" id="exportAdditionalIten">
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
        $( "#datefrom" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $( "#dateto" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            dateFormat: 'yy-mm-dd'
        });
        $("#exportAdditionalIten").click(function(){
            var table2excel = new Table2Excel({
                defaultFileName: "Pembelian Lainnya",
                Number : true
            }
            );
            table2excel.export(document.getElementById("export"));
        })
    });
</script>
@endsection