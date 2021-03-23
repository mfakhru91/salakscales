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
        <form action="{{route('additional-item.index')}}" method="GET">
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

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah Barang
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pembelian lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('additional-item.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tanggal Pembelian</label>
                            <input type="text" class="form-control" name="date" data-toggle="datepicker" placeholder="tanggal pembelian">
                            @if($errors->has('date'))
                                <span class="help-block">{{ $errors->first('date') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Penanggung Jawab</label>
                            <input type="text" class="form-control" id="responsiblePerson" name="responsible_person" placeholder="nama penanggung jawab">
                            @if($errors->has('responsible_person'))
                                <span class="help-block">{{ $errors->first('responsible_person') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="itemName" name="item_name" placeholder="nama barang">
                            @if($errors->has('item_name'))
                                <span class="help-block">{{ $errors->first('item_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="unit">Jumlah Barang</label>
                            <input type="number" class="form-control" id="itemUnit" name="item_unit" placeholder="jumlah barang">
                            @if($errors->has('item_unit'))
                                <span class="help-block">{{ $errors->first('item_unit') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="unit">Harga Barang</label>
                            <input type="number" class="form-control" id="itemUnit" name="item_price" placeholder="harga barang">
                            @if($errors->has('item_price'))
                                <span class="help-block">{{ $errors->first('item_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <table style="margin-top: 10px" class="table table-striped table-bordered"  id="export" style="counter-reset: rowNumber;">
            <thead>
                <tr>
                    <th colspan="7">
                        <h3>Pembelian Lainya</h3>
                    </th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Penanggung jawab</th>
                    <th>jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($month_item as $item)
                <tr>
                    <td>{{$item->date}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->responsible_person}}</td>
                    <td>{{$item->unit}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->unit * $item->price}}</td>
                    <td>
                        <a href="{{ route('additional-item.edit',$item->id) }}" class="btn btn-warning"><i class="lnr lnr-pencil"></i></a>
                        <a href="{{ route('additional-item.delete',$item->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ Route('additional-item.export') }}" class="btn btn-primary btn-block">Export</a>
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
                defaultFileName: "Bookkeeping Costume",
                Number : true
            }
            );
            table2excel.export(document.getElementById("export"));
        })
    });
</script>
@endsection