@extends('layouts.master')
@section('title')Edit Grading List @endsection
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col">
                    <h3 class="panel-title">Edit Grading</h3>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form class="" action="{{ route('grading.update',$grading->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group @error('name') has-error @enderror">
                    <label for="name">Tipe</label>
                    <input type="text" class="form-control " name="grade_name" value="{{ $grading->name }}" placeholder="Tipe Grading">
                </div>
                @error('name')
                    <span class="help-block">{{ $message }}</span>
                @enderror
                <div class="form-group @error('market') has-error @enderror">
                    <label for="price">Harga</label>
                    <input type="number" class="form-control " name="price" value="{{  $grading->price }}" placeholder="Harga">
                </div>
                @error('price')
                    <span class="help-block">{{ $message }}</span>
                @enderror
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
