@extends('layouts.master')
@section('title')Print Data @endsection
@section('header')
  <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
@endsection
@section('content')
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">PRINT NOTA</h3>
    </div>
    <div class="panel-body" id="nota">
      <table class="" style="width: 400px">
        <tr>
          <td rowspan="5">
            <img src="{{asset('public/image/logo_nota.png')}}" height="100px" alt="logo">
          </td>
        </tr>
        <tr>
          <th colspan="3" style="width: 200px">
            <h3>Nota Salak Pondoh</h3>
          </th>
        </tr>
        <tr>
          <td style="width: 90px;">Date</td>
          <td style="width: 30px;">:</td>
          <td>{{ now()->format('d M Y') }}</td>
        </tr>
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td>{{ $seller->name }}</td>
        </tr>
        <tr>
          <td>No Nota</td>
          <td>:</td>
          <td>{{ $note_id }}</td>
        </tr>
      </table>
      <hr>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Pembayaran</th>
            <th>Tonase</th>
            <th>Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach($items as $item)
          <tr>
            <td>{{ $item->date($item->created_at) }}</td>
            <td>{{ $item->payment }}</td>
            <td>{{ $item->tonase }} Kg</td>
            <td>Rp.{{ number_format($item->price, 2, ',', '.') }}</td>
          </tr>
          @endforeach
          <tr >
            <td colspan="2" class="text-right">
              <b>Total</b>
            </td>
            <td> {{ $items->sum('tonase') }} Kg</td>
            <td>Rp.{{ number_format($items->sum('price') ,2 ,',', '.')}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-1">
          @if($item->note_id)
          <button type="button"  class="btn btn-info" onclick="printJS({ printable: 'nota', type: 'html', css:'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' })">
            <span class="lnr lnr-printer"></span> Print
          </button></div>
          @endif
        <div class="col-md-1">
          <form action="{{ route('note.store') }}" method="post">
            @csrf
            <input type="hidden" name="seller_id" value="{{ $seller->id }}">
            @foreach($items as $item)
              <input type="hidden" name="item_id[{{ $item->id }}]" value="{{ $item->id }}">
            @endforeach
          <input type="hidden" name="price_total" value="{{ $items->sum('price') }}">
            <input type="hidden" name="tonase_total" value="{{ $items->sum('tonase') }}">
            <button class="btn btn-primary"><span class="lnr lnr-file-empty"></span> Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('footer')
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
@endsection
