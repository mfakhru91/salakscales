@extends('layouts.master')
@section('title') barang @endsection
@section('header')
<link rel="stylesheet" href="{{asset('public/css/laporan.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
@endsection
@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Laporan</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('laporan.index')}}" method="GET">
            <div class="row">
                <div class="col-md-2" >
                    @csrf
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="from" type="datetime" name="from">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="sampai tanggal" id="to" type="datetime" name="to">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" name="market_id">
                          <option value="" >Pasar</option>
                          @foreach($select_buyer as $by)
                          <option value="{{$by->id}}">{{$by->market}}</option>
                          @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <br>
        @if($profit == null)
        @else
            @php
            $income_total = [];
            @endphp
            @foreach($profit as $pr)
                @php
                    $akomodasi = $pr->tools + $pr->packing + $pr->shipping_charges;
                    $total_akomodasi = $akomodasi * $pr->tonase;
                    $sum_income = $pr->income - $pr->price - $total_akomodasi;
                    array_push($income_total, $sum_income);
                    @endphp
            @endforeach
            @php
                    $sum_profit = array_sum($income_total);
            @endphp
        @endif
        <table class="table table-striped table-bordered" style="counter-reset: rowNumber;">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Pasar</th>
                    <th>Tonase</th>
                    <th>Price</th>
                    <th>Nota</th>
                    <th>Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @if($dvitem == null)
                @else
                @foreach($dvitem as $item)
                @foreach($buyer->where('id',$item->buyer_Id) as $by)
                <tr>
                    <td class="number"></td>
                    <td>{{$item->date_time}}</td>
                    <td>{{$by->name}}</td>
                    <td>{{$by->market}}</td>
                    <td>
                        {{$item->new_tonase}}
                        <span>Kg</span>
                    </td>
                    <td>Rp.{{ number_format($item->price, 2, ',', '.')}}</td>
                    <td>{{$item->note_id}}</td>
                    <td>Rp.{{ number_format($item->income, 2, ',', '.')}}</td>
                </tr>
                @endforeach
                @endforeach
                @endif
                <tr>
                    <th colspan="7">Total</th>
                    <th>
                        @if($profit == null)
                        @else
                            Rp.{{ number_format($profit->sum('income'), 2, ',', '.')}}
                        @endif
                    </th>
                </tr>
            </tbody>
        </table>
        <table style="margin-top: 10px" class="table table-striped table-bordered" style="counter-reset: rowNumber;">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @if($items == null)
                @else
                @php
                 $additional_items = []
                @endphp
                @foreach($items as $item)
                <tr>
                    <td class="number"></td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->unit}}</td>
                    <td>Rp.{{ number_format($item->price, 2, ',', '.')}}</td>
                    <td>Rp.{{ number_format($item->unit * $item->price, 2, ',', '.')}}</td>
                    @php
                        $sum_total = $item->unit * $item->price;
                        array_push($additional_items, $sum_total);
                    @endphp
                </tr>
                @endforeach
                @php
                    $sum_additional_items = array_sum($additional_items);
                @endphp
                @endif
                <tr>
                    <th colspan="5">Total</th>
                    <th>
                        @if($items == null)
                        @else
                            Rp.{{ number_format($sum_additional_items, 2, ',', '.')}}
                        @endif
                    </th>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-5">
                <table style="margin-top: 10px" class="table table-striped table-bordered" style="counter-reset: rowNumber;">
                    <thead>
                        <tr>
                            <th>Pasar</th>
                            <th>Akomodasi</th>
                            <th>Harga</th>
                            <th>Penjualan</th>
                            <th>Kenutungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($profit == null)
                        @else
                        @foreach($profit as $by)
                        @php
                        $addakomodasi = $by->tools + $by->packing + $by->shipping_charges;
                        $addtotal_akomodasi = $addakomodasi * $by->tonase;
                        $addsum_income = $by->income - $by->price - $addtotal_akomodasi;
                        @endphp
                        <tr>
                            <td>{{ $by->market }}</td>
                            <td>Rp.{{ number_format($addtotal_akomodasi, 2, ',', '.')}}</td>
                            <td>Rp.{{ number_format($by->price, 2, ',', '.')}}</td>
                            <td>Rp.{{ number_format($by->income, 2, ',', '.')}}</td>
                            <td>
                                @if($addtotal_akomodasi == 0)
                                    Rp.0,00
                                @else
                                Rp.{{ number_format($by->income - $by->price - $addtotal_akomodasi, 2, ',', '.')}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="4">Lain-Lain</th>
                            <th>
                                @if($items == null)
                                @else
                                    Rp.{{ number_format($sum_additional_items, 2, ',', '.')}}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">Total</th>
                                <th>
                                    Rp.{{ number_format( $sum_profit - $sum_additional_items, 2, ',', '.')}}
                            </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Pembelian Lainya</h3>
    </div>
    <div class="panel-body">
        <form action="{{route('laporan.index')}}" method="GET">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-2" >
                    @csrf
                    <div class="input-group">
                        <input class="form-control datepicker" placeholder="dari tanggal" id="date" type="datetime" name="date_additional_item">
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

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah Barang
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('laporan.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tanggal Pembelian</label>
                            <input type="text" class="form-control" name="date" data-toggle="datepicker" placeholder="tanggal pembelian">
                            @if($errors->has('date'))
                                <span class="help-block">{{ $errors->first('date') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="itemName" name="item_name" placeholder="nama barang">
                            @if($errors->has('item_name'))
                                <span class="help-block">{{ $errors->first('item_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="unit">Jumlah Barang</label>
                            <input type="number" class="form-control" id="itemUnit" name="item_unit" placeholder="jumlah barang">
                            @if($errors->has('item_unit'))
                                <span class="help-block">{{ $errors->first('item_unit') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="unit">Harga Barang</label>
                            <input type="number" class="form-control" id="itemUnit" name="item_price" placeholder="harga barang">
                            @if($errors->has('item_price'))
                                <span class="help-block">{{ $errors->first('item_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <table style="margin-top: 10px" class="table table-striped table-bordered" style="counter-reset: rowNumber;">
            <thead>
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($month_item as $item)
                <tr>
                    <td class="number"></td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->unit}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->unit * $item->price}}</td>
                    <td>
                        {{--  <a href="{{ route('barang.edit',$item->id) }}" class="btn btn-warning"><i class="lnr lnr-pencil"></i></a>  --}}
                        <a href="{{ route('bookkeeping.delete',$item->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $month_item->links() }}
    </div>
</div>
@endsection
@section('footer')
<script src="{{asset('public/js/jquery-3.5.1.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( document ).ready(function() {
        console.log( "ready!" );
        $( "#from" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $( "#to" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#date").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
@endsection