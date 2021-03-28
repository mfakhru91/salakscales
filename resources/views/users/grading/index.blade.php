@extends('layouts.master')
@section('title')Grading @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <i class="fa fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <div class="col">
                    <h3 class="panel-title">Grading</h3>
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
                        <th>Grading</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @foreach ($buyers as $by)
                    <tbody>
                        <td>{{ $by->market }}</td>
                        <td>{{ $by->name }}</td>
                        <td>{{ $by->address }}</td>
                        <td>{{ $by->no_telp }}</td>
                        <td>{{ $gradings->where('buyer_id',$by->id)->count() }}</td>
                        <td>
                            <a href="{{ route('grading.show',$by->id) }}" class="btn btn-primary">Daftar Grading</a>
                        </td>
                    </tbody>
                @endforeach
            </table>
            {{ $buyers->links() }}
        </div>
    </div>
@endsection
