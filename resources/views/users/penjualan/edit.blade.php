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
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-primary">Tambah +</button>
    </form>
    </div>
  </div>
@endsection
