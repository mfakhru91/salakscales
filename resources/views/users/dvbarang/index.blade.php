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
                    <th>NAMA PENJUAL</th>
                    <th>TONASE</th>
                    <th>NO NOTA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->seller_id }}</td>
                    <td>{{ $item->tonase }}</td>
                    <td>
                        <form action="{{ route('print.note') }}" id="note" method="post">
                            @csrf
                            <input type="hidden" name="saller_id" value="{{ $item->seller_id }}">
                            <input type="hidden" name="note" value="{{ $item->note_id}}">
                            @if($item->note_id)
                            <button type="submit" class="btn btn-light"><span class="lnr lnr-printer"></span> {{ $item->note_id}}</button>
                            @endif
                        </form>
                    </td>
                </tr>
                @endforeach
                <form action="{{route('barang.dvitem')}}" method="POST">
                    @csrf
                    <tr>
                        <th class="bg-primary">Total</th>
                        <th class="bg-primary">{{$tonase}} Kg</th>
                        <th class="bg-primary"></th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center">
                            <input type="hidden" value="{{$tonase}}" name="tonase">
                            <button type="submit" class="btn btn-primary">Confrim</button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</div>

@endsection