@extends('layouts.master')
@section('title')Pembelian edit @endsection
@section('content')
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">edit pembeli</h3>
    </div>
    <div class="panel-body">
      <form class="" action="{{ route('penjualan.update',$buyer->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
          <label for="name">Nama</label>
          <input type="text" class="form-control " name="name" value="{{ $buyer->name }}" placeholder="Nama Pembeli">
        </div>
        @if($errors->has('name'))
          <span class="help-block">{{ $errors->first('name') }}</span>
        @endif
        <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
          <label for="name">Pasar</label>
          <input type="text" class="form-control " name="market" value="{{ $buyer->market }}" placeholder="Nama Pasar">
        </div>
        @if($errors->has('market'))
          <span class="help-block">{{ $errors->first('market') }}</span>
        @endif
        <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
          <label for="address">Alamat</label>
          <input type="text" class="form-control" name="address" value="{{ $buyer->address }}" placeholder="Alamat">
        </div>
        @if($errors->has('address'))
          <span class="help-block" >{{ $errors->first('name') }}</span>
        @endif
        <label for="no_telp">No Telp</label>
        <div class="input-group {{ $errors->has('no_telp')? 'has-error':'' }} ">
          <span class="input-group-addon">+62</span>
          <input type="text" class="form-control" name="no_telp" value="{{ $buyer->no_telp }}" placeholder="No Telp">
        </div>
        <small>* contoh no telp 8233628373 <b>tanpa 0</b>.</small>
        @if($errors->has('no_telp'))
          <span class="help-block" >{{ $errors->first('no_telp') }}</span>
        @endif
        <hr>
        <h4>AKOMODASI</h4>
        <div class="row">
          <div class="col-md-6">
            <label for="selling_price">Harga Jual</label>
            <div class="input-group {{ $errors->has('selling_price')? 'has-error':'' }} ">
              <span class="input-group-addon">Rp</span>
              <input type="number" class="form-control" name="selling_price" value="{{ $buyer->selling_price }}" placeholder="harga jual">
            </div>
            @if($errors->has('selling_price'))
              <span class="help-block" >{{ $errors->first('selling_price') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="no_telp">Pengepakan</label>
            <div class="input-group {{ $errors->has('packing')? 'has-error':'' }} ">
              <span class="input-group-addon">Rp</span>
              <input type="number" class="form-control" name="packing" value="{{ $buyer->packing }}" placeholder="Pengepakan">
            </div>
            @if($errors->has('packing'))
              <span class="help-block" >{{ $errors->first('packing') }}</span>
            @endif
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6">
            <label for="tools">Alat</label>
            <div class="input-group {{ $errors->has('tools')? 'has-error':'' }} ">
              <span class="input-group-addon">Rp</span>
              <input type="number" class="form-control" name="tools" value="{{ $buyer->tools }}" placeholder="Alat">
            </div>
            @if($errors->has('tools'))
              <span class="help-block" >{{ $errors->first('tools') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="shipping_charges">Ongkos Kirim</label>
            <div class="input-group {{ $errors->has('shipping_charges')? 'has-error':'' }} ">
              <span class="input-group-addon">Rp</span>
              <input type="number" class="form-control" name="shipping_charges" value="{{ $buyer->shipping_charges }}" placeholder="Ongkos Kirim">
            </div>
            @if($errors->has('shipping_charges'))
              <span class="help-block" >{{ $errors->first('shipping_charges') }}</span>
            @endif
          </div>
        </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-primary btn-block">Edit</button>
    </form>
    </div>
  </div>
@endsection
