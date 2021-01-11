@extends('layouts.master')
@section('title')Penjualan Detail @endsection
@section('content')
@if(session('status'))
  <div class="alert alert-warning alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <i class="fa fa-check-circle"></i> {{session('status')}}
  </div>
@endif
<div class="panel panel-profile">
  <div class="clearfix" style=" min-height: 450px">
    <!-- LEFT COLUMN -->
    <div class="profile-left">
      <!-- PROFILE HEADER -->
      <div class="profile-header">
        <div class="overlay"></div>
        <div class="profile-main">
          <img src="" class="img-circle" alt="Avatar" style="object-fit: cover; height: 100px; width: 100px;">
          <h3 class="name"></h3>
          <span class="online-status status-available">Available</span>
        </div>
        <div class="profile-stat">
          <div class="row">

          </div>
        </div>
      </div>
      <!-- END PROFILE HEADER -->
      <!-- PROFILE DETAIL -->
      <div class="profile-detail">
        <div class="profile-info">
          <h4 class="heading">Basic Info</h4>
          <ul class="list-unstyled list-justify">
            <li>Nama <span>{{ $buyyers->name}}</span></li>
            <li>Pasar <span>{{ $buyyers->market }}</span></li>
            <li>No Telp <span>{{ $buyyers->no_telp }}</span></li>
            <li>Alamat <span>{{ $buyyers->address }}</span></li>
          </ul>
        </div>
        <div class="text-center"><a href="{{ route('penjualan.edit',$buyyers->id) }}" class="btn btn-primary">Edit Profile</a></div>
      </div>
      <!-- END PROFILE DETAIL -->
    </div>
    <!-- END LEFT COLUMN -->
    <!-- RIGHT COLUMN -->
    <div class="profile-right">
      <h4 class="heading">{{$buyyers->name}}</h4>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="margin-bottom: 10px;">
          Kirim Barang <i class="fa fa-shopping-cart"></i>
      </button>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Baru</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="" action="{{ route('penjualan.add.item') }}" method="post">
                @csrf
                <p>Barang Siap Jual</p>
                <div class="row">
                    <div class="col-md-3">
                        <label for="tonase">Tonase</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled id="tonaseValue" value="@if ($dvitem == null) 0 @else {{$dvitem->tonase}} @endif">
                            <span class="input-group-addon">Kg</span>
                        </div>
                        <input type="text" class="form-control" name="old_tonase" style="display: none" id="oldTonase" value="">
                        <input type="text" class="form-control" style="display: none" id="totalTonase" value="@if($dvitem == null) 0 @else {{$dvitem->tonase}} @endif">
                    </div>
                </div>
                <hr>
                <input type="hidden" name="buyyer_id" value="{{ $buyyers->id }}">
                <label for="tonase">Tonase</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="valtonase" name="new_tonase" value="">
                  <span class="input-group-addon">Kg</span>
                </div>
                <a href="#" class="btn btn-primary" style="margin-top: 10px" id="getTotal">Hitung</a>
                <br>
                <label for="price">Harga</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" id="price" name="price" value="">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Kirim <i class="fa fa-shopping-cart"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Tansaksi Pembelian</h3>
        </div>
        <div class="panel-body">
          @if($errors->has('item'))
          <span class="help-block" >{{ $errors->first('item') }}</span>
          @endif
          <div class="{{ $errors->has('item')? 'has-error':'' }} "></div>
          <form action="{{ route('print.item.buyer') }}" method="post">
            @csrf
            <input type="hidden" name="buyer_id" value="{{ $buyyers->id }}">
            <button type="submit" class="btn btn-info"><span class="lnr lnr-printer"></span> Print</button>
            <table class="table table-striped">
            <thead>
              <tr>
                <th> <input class="form-check-input" type="checkbox" id="checkall" value="option2"> </th>
                <th>TANGGAL</th>
                <th>TONASE</th>
                <th>HARGA</th>
                <th>NO NOTA</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $buyyerItem as $item )
              <tr>
                <td> <input class="form-check-input itemchecked" type="checkbox" name="item[{{ $item->id }}]" value="{{ $item->id }}"> </td>
              </form>
                  <td> {{ $item->date_time }} </td>
                  <td> {{ $item->new_tonase }} </td>
                  <td> Rp. {{ number_format($item->price, 2, ',', '.') }} </td>
                  <td>
                    <form action="{{ route('print.note.buyer') }}" id="note" method="post">
                      @csrf
                      <input type="hidden" name="buyer_id" value="{{ $buyyers->id  }}">
                      <input type="hidden" name="note" value="{{ $item->note_id}}">
                      @if($item->note_id)
                      <button type="submit" class="btn btn-light"><span class="lnr lnr-printer"></span> {{ $item->note_id}}</button>
                      @endif
                    </form>
                  </td>
                  <td>
                    <a href="{{ route('barang.edit',$item->id) }}" class="btn btn-warning"><i class="lnr lnr-pencil"></i></a>
                    <a href="{{ route('item.delete.pembelian',$item->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- END RIGHT COLUMN -->
  </div>
</div>

@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    const user_id = {{$user}}
    $(document).ready(function() {
        $('#valtonase').click(function(){
            $.ajax({
                url:"http://localhost/skripsi/api/setting/"+user_id,
                type:"GET",
                async : true,
                success:function(result)
                {
                    let price = result.data[0].sell_price;
                    let getPrice = $('#totalPrice').val()
                    let totalTonase = $('#totalTonase').val()
                    $('#getTotal').click(function() {
                        let total = Number(totalTonase)- $('#valtonase').val()
                        if (total < 0 ){
                            alert('berat yang anda masukan berlebih')
                        }else{
                            let getPriceTotal = price * $('#valtonase').val()
                            $('#price').val(getPriceTotal)
                            $('#tonaseValue').val(total)
                            $('#oldTonase').val(total)
                        }
                    })
                }
            });
        })
        $('#checkall').click(function() {
          if($('#checkall').prop('checked')== true){
            $('.itemchecked').prop('checked',true)
          }else{
            $('.itemchecked').prop('checked',false)
          }
        })
        $('.itemchecked').click(function() {
          $('#checkall').prop('checked',false)
        })
    })
</script>
@endsection