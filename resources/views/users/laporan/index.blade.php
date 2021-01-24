@extends('layouts.master')
@section('title') barang @endsection
@section('header')
<link rel="stylesheet" href="{{asset('public/css/laporan.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Laporan</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('reporting.month.search')}}" method="GET">
            <div class="row">
                <div class="col-md-2">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" id="datepicker" type="datetime" name="cari">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <br>
        <table class="table table-striped table-bordered" style="counter-reset: rowNumber;">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Pasar</th>
                    <th>Tonase</th>
                    <th>Price</th>
                    <th>Income</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dvitem as $item)
                @foreach($buyer->where('id',$item->buyer_Id) as $by)
                <tr>
                    <td class="number"></td>
                    <td>{{$item->date_time}}</td>
                    <td>{{$by->name}}</td>
                    <td>{{$by->market}}</td>
                    <td>{{$item->new_tonase}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->income}}</td>
                    <td>{{$item->note_id}}</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('footer')
<script src="{{asset('public/js/jquery-3.5.1.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( "#datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
</script>
@endsection