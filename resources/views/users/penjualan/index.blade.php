@extends('layouts.master')
@section('title')Penjualan @endsection
@section('content')
@if(session('status'))
  <div class="alert alert-warning alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <i class="fa fa-check-circle"></i> {{session('status')}}
  </div>
@endif
  <div class="panel">
    <div class="panel-heading">
      <div class="row">
        <div class="col">
          <h3 class="panel-title">Penjual</h3>
        </div>
        <div class="col">
          <div class="text-right">
            <a class="btn btn-primary" data-toggle="modal" data-target="#addSeller" >Tambah Pembeli + </a>
          </div>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Pasar</th>
            <th>Name</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Transaki</th>
            <th>Action</th>
          </tr>
        </thead>
        @foreach ($buyers as $by)
        <tbody>
          <td>{{ $by->market }}</td>
          <td>{{ $by->name }}</td>
          <td>{{ $by->address }}</td>
          <td>{{ $by->no_telp }}</td>
          <td>null</td>
          <td>
            <a href="{{ route('penjualan.edit',$by->id) }}" class="btn btn-warning"><span class="lnr lnr-pencil"></span></a>
            <a href="{{ route('penjualan.delete',$by->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
            <a href="{{ route('penjualan.show',$by->id) }}" class="btn btn-info"><span class="lnr lnr-eye"></span></a>
          </td>
        </tbody>
        @endforeach
      </table>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addSeller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{ route('penjualan.store') }}" method="post">
            @csrf
            <div class="form-group @error('name') has-error @enderror">
              <label for="name">Nama</label>
              <input type="text" class="form-control " name="name" value="" placeholder="Nama Penerima">
            </div>
            @error('name')
              <span class="help-block">{{ $message }}</span>
            @enderror
            <div class="form-group @error('market') has-error @enderror">
              <label for="market">Pasar</label>
              <input type="text" class="form-control " name="market" value="" placeholder="Nama Pasar">
            </div>
            @error('market')
              <span class="help-block">{{ $message }}</span>
            @enderror
            <div class="form-group @error('address') has-error @enderror">
              <label for="address">Alamat</label>
              <input type="text" class="form-control" name="address" value="" placeholder="Alamat">
            </div>
            @error('address')
              <span class="help-block" >{{ $message }}</span>
            @enderror
            <label for="no_telp">No Telp</label>
            <div class="input-group @error('no_telp') has-error @enderror ">
              <span class="input-group-addon">+62</span>
              <input type="text" class="form-control" name="no_telp" value="" placeholder="No Telp">
            </div>
            <small>* contoh no telp 8233628373 <b>tanpa 0</b>.</small>
            @error('no_telp')
              <span class="help-block" >{{ $message }}</span>
            @enderror
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah +</button>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection
