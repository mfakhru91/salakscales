@extends('layouts.master')
@section('title') Edit Barang @endsection
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Data</h3>
        </div>
        <div class="panel-body">
            <form action="{{ route('dvitem.update', $item->id) }}" method="post">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" name="buyerId" value="{{ $item->buyer_Id }}">
                <label for="tonase">Tonase</label>
                <div class="input-group">
                    <input type="text" class="form-control" disabled name="tonase" id="tonase"
                        value="{{ $item->new_tonase }}">
                    <span class="input-group-addon">Kg</span>
                </div>
                <br>
                <label for="price">Harga</label>
                <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" name="price" id="price" value="{{ $item->price }}">
                </div>
                <label for="price">Penjualan (Rp)</label>
                <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" name="income" id="income" value="@if ($item->income == null) 0 @else {{ $item->income }} @endif">
                </div>
                <label for="price">Grading</label>
                <select class="form-control" name="grading" id="grading">
                    <option value="" disabled selected hidden>Grading</option>
                    @foreach ($grading as $gr)
                        <option value="{{ $gr->price }}|{{ $gr->id }}" @if ($item->grading_id == $gr->id) selected @endif>
                            {{ $gr->name }}</option>
                    @endforeach
                </select>
                <br>
                <button type=" submit " class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const user_id = {{ $user }}
        let getTonase = $('#tonase').val()
        $(document).ready(function() {
            $('#grading').on('change', function() {
              const tonase = $('#tonase').val()
              const getprice = this.value
              const newprice = getprice.split("|")
              $('#price').val(newprice[0]*tonase)
            });
            $('#send').click(function() {
                var response = confirm("Apakah Anda Yakin?");
                if (response == true) {
                    $('#delivery').submit();
                } else {

                }
            })
            $('#checkall').click(function() {
                if ($('#checkall').prop('checked') == true) {
                    $('.itemchecked').prop('checked', true)
                } else {
                    $('.itemchecked').prop('checked', false)
                }
            })
            $('.itemchecked').click(function() {
                $('#checkall').prop('checked', false)
            })
        })

    </script>
@endsection
