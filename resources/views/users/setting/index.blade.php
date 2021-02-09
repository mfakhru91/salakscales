@extends('layouts.master')
@section('title')Pembelian @endsection
@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Setting</h3>
    </div>
    <div class="panel-body">
        @if($user->avatar == null)
        <img src="{{asset('public/image/default-user-image.png')}}" alt="" style="object-fit: cover; width: 200px;height: 237px;">
        @else
        <img src="{{asset('storage/app/public/'.$user->avatar)}}" alt="" style="object-fit: cover; width: 200px;height: 237px;">
        @endif
        <br>
        <form class="" action="{{route('setting.update',$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="exampleFormControlFile1">Foto Profil</label>
                <input type="file" name="avatar" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <div class="form-group row">
                <label for="userName" class="col-sm-2 col-form-label">Nama Pengguna</label>
                <div class="col-sm-10">
                    <input type="Text" class="form-control" id="userName" name="username" placeholder="Nama Pengguna" value="{{$user->name}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="price" name="price" placeholder="Harga Pasar" value="{{$settings->price}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="tools" class="col-sm-2 col-form-label">ID Alat</label>
                <div class="col-sm-10">
                    @if($settings->tools_id == null)
                    <input type="text" class="form-control" id="tools" name="tools" placeholder="Id Alat" value="{{$uuid}}">
                    @else
                    <input type="text" class="form-control" id="tools" name="tools" placeholder="Id Alat" value="{{$settings->tools_id}}">
                    @endif
                    <small>*ID Alat untuk mengkoneksikan ke alat</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </form>
        <br>
        <small>*<b>Harap di perhatikan!, agar menyelesaikan semua transaksi sebelum merubah data <i>Harga Beli</i> karna akan mempengaruhi semua perhitungan</b> </small>
    </div>
</div>
@endsection
