@extends('layouts.master')
@section('title')Grading List @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <i class="fa fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col">
                            <h3 class="panel-title">Daftar Grading</h3>
                        </div>
                        <div class="col">
                            <div class="text-right">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#addSeller">Tambah Grading +
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gradings as $gr)
                                <tr>
                                    <td>{{ $gr->name }}</td>
                                    <td>{{ $gr->price }}</td>
                                    <td>
                                        <a href="{{ route('grading.edit',$gr->id) }}" class="btn btn-warning"><span
                                                class="lnr lnr-pencil"></span></a>
                                        <a href="{{  route('grading.delete',$gr->id) }}" class="btn btn-danger"><span
                                                class="lnr lnr-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addSeller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="" action="{{ route('grading.store') }}" method="post">
                                @csrf
                                <div class="form-group @error('name') has-error @enderror">
                                    <label for="name">Tipe</label>
                                    <input type="text" class="form-control " name="grade_name" value=""
                                        placeholder="Tipe Grading">
                                </div>
                                @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                                <div class="form-group @error('market') has-error @enderror">
                                    <label for="price">Harga</label>
                                    <input type="number" class="form-control " name="price" value="" placeholder="Harga">
                                </div>
                                @error('price')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                                <input type="text" value="{{ $buyer_id }}" hidden name="buyer_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah +</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
