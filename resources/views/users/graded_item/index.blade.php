@extends('layouts.master')
@section('title') barang @endsection
@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title text-center">Confirmasi Barang Siap Jual</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>TONASE</th>
                    <th>TONASE BERSIH</th>
                    <th>TONASE KOTOR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($graded_items as $gi)
                    <tr>
                        <td>{{ $gi->new_tonase }}</td>
                        <td>{{ $gi->graded_tonase }}</td>
                        <td>{{ $gi->new_tonase -$gi->graded_tonase }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #00A0F0; color:white;">
                    <td> <b></b> {{ $graded_items->sum('new_tonase') }}</td>
                    <td> <b></b> {{ $graded_items->sum('graded_tonase') }}</td>
                    <td> <b>{{ $graded_items->sum('new_tonase') - $graded_items->sum('graded_tonase') }}</b> </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <form action="{{ route('grading.confirmation.store') }}" method="POST">
            @csrf
            @foreach ( $graded_items as $gi)
            <input type="text" name="id[]" value="{{ $gi->id }}" hidden>
            @endforeach
            <input type="text" hidden name="tonase" value="{{ $graded_items->sum('graded_tonase') }}">
            <button type="submit" class="btn btn-primary btn-block">Confirm</button>
        </form>
    </div>
</div>

@endsection