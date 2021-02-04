@extends('layouts.master')
@section('title') Edit Barang  @endsection
@section('header')
<link rel="stylesheet" href="{{asset('public/css/laporan.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Data</h3>
		</div>
		<div class="panel-body">
            <form action="{{ route('additional-item.update',$item->id) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="name">Tanggal Pembelian</label>
                    <input type="text" class="form-control" id="date" name="date" data-toggle="datepicker" value="{{ $item->date }}" placeholder="tanggal pembelian">
                    @if($errors->has('date'))
                        <span class="help-block">{{ $errors->first('date') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Nama Barang</label>
                    <input type="text" class="form-control" id="itemName" name="item_name" value="{{$item->name}}" placeholder="nama barang">
                    @if($errors->has('item_name'))
                        <span class="help-block">{{ $errors->first('item_name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="unit">Jumlah Barang</label>
                    <input type="number" class="form-control" id="itemUnit" name="item_unit" value="{{$item->unit}}" placeholder="jumlah barang">
                    @if($errors->has('item_unit'))
                        <span class="help-block">{{ $errors->first('item_unit') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="unit">Harga Barang</label>
                    <input type="number" class="form-control" id="itemUnit" name="item_price" value="{{$item->price}}" placeholder="harga barang">
                    @if($errors->has('item_price'))
                        <span class="help-block">{{ $errors->first('item_price') }}</span>
                    @endif
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Update Barang</button>
            </form>
		</div>
	</div>
@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( document ).ready(function() {
        console.log( "ready!" );
        $( "#date" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
@endsection