@extends('layouts.master')
@section('title') barang @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <i class="fa fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
            <i class="fas fa-exclamation"></i> {{ session('danger') }}
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form class="" action="{{ route('barang.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="payment">Pelanggan</label>
                            <select class="form-control" name="seller_id">
                                <option value="" selected>Pilih Pelanggan</option>
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('seller_id'))
                                <span class="help-block">{{ $errors->first('seller_id') }}</span>
                            @endif
                        </div>
                        <label for="tonase">Tonase</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="tonase" id="tonase" value="">
                            <span class="input-group-addon">Kg</span>
                        </div>
                        @if ($errors->has('tonase'))
                            <span class="help-block">{{ $errors->first('tonase') }}</span>
                        @endif
                        <a href="#" class="btn btn-primary" style="margin-top: 10px" id="get-tonase">Timbang</a>
                        <br>
                        <label for="price">Harga</label>
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" name="price" id="price" value="">
                        </div>
                        @if ($errors->has('price'))
                            <span class="help-block">{{ $errors->first('price') }}</span>
                        @endif
                        <div class="form-group">
                            <label for="payment">Pembayaran</label>
                            <select class="form-control" name="payment">
                                <option value="" selected>Pembayaran</option>
                                <option value="debt">Tempo</option>
                                <option value="paid off">Cash</option>
                            </select>
                            @if ($errors->has('payment'))
                                <span class="help-block">{{ $errors->first('payment') }}</span>
                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Barang <i class="lnr lnr-plus-circle"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Daftar Barang</h3>
        </div>
        <div class="panel-body">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                Tambah Barang <i class="lnr lnr-plus-circle"></i>
            </button>
            <form style="margin-top: 10px" action="{{ route('barang.delivery') }}" id="delivery" method="POST">
                @csrf
                <a href="#" id="send" class="btn btn-primary" onclick="alert(apakah anda yakin)">Kirim</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> <input class="form-check-input" type="checkbox" id="checkall" value="option2"> </th>
                            <th>NAMA PENJUAL</th>
                            <th>TONASE</th>
                            <th>HARGA</th>
                            <th>PEMBAYARAN</th>
                            <th>NO NOTA</th>
                            {{-- <th>STATUS</th> --}}
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            @foreach ($sellers->where('id', $item->seller_id) as $seller)
                                <tr>
                                    <td> <input class="form-check-input itemchecked" type="checkbox" name="item[]"
                                            value="{{ $item->id }}"> </td>
            </form>
            <td><a href="{{ route('pembelian.show', $seller->id) }}" class="text-info">{{ $seller->name }}</a></td>
            <td>{{ $item->tonase }}</td>
            <td>Rp. {{ number_format($item->price, 2, ',', '.') }}</td>
            <td>
                @if ($item->payment == 'debt')
                    Tempo
                @else
                    Cash
                @endif
            </td>
            <td>
                <form action="{{ route('print.note') }}" id="note" method="post">
                    @csrf
                    <input type="hidden" name="saller_id" value="{{ $item->seller_id }}">
                    <input type="hidden" name="note" value="{{ $item->note_id }}">
                    @if ($item->note_id)
                        <button type="submit" class="btn btn-light"><span class="lnr lnr-printer"></span>
                            {{ $item->note_id }}</button>
                    @endif
                </form>
            </td>
            {{-- <td>
                @if ($item->status == 'process')
                    proses
                @else
                    <b>terjual</b>
                @endif
            </td> --}}
            <td>
                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning"><i
                        class="lnr lnr-pencil"></i></a>
                <a href="{{ route('item.delete', $item->id) }}" class="btn btn-danger"><span
                        class="lnr lnr-trash"></span></a>
            </td>
            </tr>
            @endforeach
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Barang Kirim</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NAMA PENJUAL</th>
                        <th>TONASE</th>
                        <th>HARGA</th>
                        <th>PEMBAYARAN</th>
                        <th>NO NOTA</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dvitems as $item)
                        @foreach ($dvsellers->where('id', $item->seller_id) as $seller)
                            <tr>
                                <td><a href="{{ route('pembelian.show', $seller->id) }}"
                                        class="text-info">{{ $seller->name }}</a></td>
                                <td>{{ $item->tonase }}</td>
                                <td>Rp. {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td>
                                    @if ($item->payment == 'paid off')
                                        <p>Cash</p>
                                    @else
                                        <p>Tempo</p>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('print.note') }}" id="note" method="post">
                                        @csrf
                                        <input type="hidden" name="saller_id" value="{{ $item->seller_id }}">
                                        <input type="hidden" name="note" value="{{ $item->note_id }}">
                                        @if ($item->note_id)
                                            <button type="submit" class="btn btn-light"><span
                                                    class="lnr lnr-printer"></span> {{ $item->note_id }}</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-warning"><i
                                            class="lnr lnr-pencil"></i></a>
                                    <a href="{{ route('item.delete', $item->id) }}" class="btn btn-danger"><span
                                            class="lnr lnr-trash"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Barang Tergrading</h3>
        </div>
        <div class="panel-body">
            <form action="{{ route('grading.confirmation') }}" method="POST" id="grading_item">
                @csrf
                <a href="#" id="grading_send" class="btn btn-primary" onclick="alert(apakah anda yakin)">Kirim</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> <input class="form-check-input" type="checkbox" id="checkall" value="option2"> </th>
                            <th>TONASE</th>
                            <th>TONASE BERSIH</th>
                            <th>TONASE KOTOR</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dvitems_data as $dv)
                            <tr>
                                @if ($dv->status == 0)
                                    <td> <input class="form-check-input itemchecked" type="checkbox" name="graded_item[]"
                                            value="{{ $dv->id }}"> </td>
                                @else
                                    <td> <input class="form-check-input itemchecked" type="checkbox" disabled> </td>
                                @endif
            </form>
            <td>{{ $dv->new_tonase }}</td>
            <td>{{ $dv->graded_tonase }}</td>
            <td>{{ $dv->new_tonase - $dv->graded_tonase }}</td>
            <td>
                @if ($dv->status == 0)
                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#editTonaseBersih-{{ $dv->id }}">
                        <i class="lnr lnr-pencil"></i>
                    </button>
                @else
                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="" disabled>
                        <i class="lnr lnr-pencil"></i>
                    </button>
                @endif
                <a href="{{ route('grading.item.delete', $dv->id) }}" class="btn btn-danger"><span
                        class="lnr lnr-trash"></span></a>
                <div class="modal fade" id="editTonaseBersih-{{ $dv->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('grading.item.update', $dv->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group @error('graded_tonase') has-error @enderror">
                                        <label for="name">Tonase Bersih</label>
                                        <input type="number" class="form-control " name="graded_tonase"
                                            value="{{ $dv->graded_tonase }}" placeholder="Tonase Bersih">
                                    </div>
                                    @error('graded_tonase')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const app_url = "{{ config('app.url') }}"
        const user_id = {{ $user }}

        function noteSubmit() {
            document.getElementById("note").submit();
        }
        $(document).ready(function() {
            $('#get-tonase').click(function() {
                $.ajax({
                    url: app_url + "/api/setting/" + user_id,
                    type: "GET",
                    async: true,
                    success: function(result) {
                        var tools_id = result.data[0].tools_id
                        if (tools_id == null) {
                            alert('Anda belum memasukan Id alat')
                        }
                        $.ajax({
                            url: app_url + "/api/tonase?tools_id=" + tools_id,
                            type: "GET",
                            async: true,
                            success: function(result) {
                                let tonase = result.data[0].tonase
                                $("#tonase").val(tonase)
                            }
                        });
                    }
                });
            })
            $('#price').click(function() {
                $.ajax({
                    url: app_url + "/api/setting/" + user_id,
                    type: "GET",
                    async: true,
                    success: function(result) {
                        console.log(result)
                        let priceData = result.data[0].price
                        let getTonase = $('#tonase').val()
                        let sumPrice = getTonase * priceData
                        $('#price').val(sumPrice)
                    }
                });
            })
            $('#grading_send').click(function() {
                var response = confirm("Apakah Anda Yakin?");
                if (response == true) {
                    $('#grading_item').submit();
                } else {

                }
            })
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
