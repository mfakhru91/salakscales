@extends('layouts.master')
@section('title') Laporan Laba Rugi @endsection
@section('content')
@section('header')
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Data keuntungan perbulan</h3>
        </div>
        <div class="panel-body">
            <table class="table table-stiped" id="note">
                <tr>
                    <th colspan="13">
                        <div class="text-center"><h3>Laporan Detail Keuntungan 1 Tahun</h2></div>
                    </th>
                </tr>
                <tr>
                    <th>Bulan</th>                    
                    <td>Januari</td>
                    <td>Februari</td>
                    <td>Maret</td>
                    <td>April</td>
                    <td>Mei</td>
                    <td>Juni</td>
                    <td>Juli</td>
                    <td>Agustus</td>
                    <td>September</td>
                    <td>Oktober</td>
                    <td>November</td>
                    <td>Desember</td>
                </tr>
                <tr>
                    <th>Keuntungan</th>
                    @foreach ($income as $in)
                        <td>Rp. {{ number_format($in, 2, ',', '.') }}</td>
                    @endforeach
                </tr>
            </table>
            <button type="button"  class="btn btn-info" onclick="printJS({ printable: 'note', type: 'html', style: '@page { size: A4 landscape; }', css:'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', })">
            <span class="lnr lnr-printer"></span> Print
            </button>
        </div>
    </div>
@endsection
@section('footer')
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
@endsection
