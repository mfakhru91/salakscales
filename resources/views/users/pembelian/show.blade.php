@extends('layouts.master')
@section('title')Pembelian show {{$seller->name}} @endsection
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
            <div class="col-md-6 stat-item">
              Rp. {{ number_format($paidOff->item->sum('price')), 2,',', '.' }} <span>Profit</span>
            </div>
            <div class="col-md-6 stat-item">
              {{ $paidOff->item->count() }} <span>Barang</span>
            </div>
          </div>
        </div>
      </div>
      <!-- END PROFILE HEADER -->
      <!-- PROFILE DETAIL -->
      <div class="profile-detail">
        <div class="profile-info">
          <h4 class="heading">Basic Info</h4>
          <ul class="list-unstyled list-justify">
            <li>Nama <span>{{ $seller->name}}</span></li>
            <li>No Telp <span>{{ $seller->no_telp }}</span></li>
            <li>Alamat <span>{{ $seller->address }}</span></li>
          </ul>
        </div>
        <div class="text-center"><a href="{{ route('pembelian.edit',$seller->id) }}" class="btn btn-primary">Edit Profile</a></div>
      </div>
      <!-- END PROFILE DETAIL -->
    </div>
    <!-- END LEFT COLUMN -->
    <!-- RIGHT COLUMN -->
    <div class="profile-right">
      <h4 class="heading">{{$seller->name}}</h4>
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Tambah Barang <i class="lnr lnr-plus-circle"></i>
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
              <form class="" action="{{ route('pembelian.add.item') }}" method="post">
                @csrf
                <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                <label for="tonase">Tonase</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="tonase" name="tonase" value="">
                  <span class="input-group-addon">Kg</span>
                </div>
                <a href="#" class="btn btn-primary" style="margin-top: 10px" id="get-tonase">Timbang</a>
                <br>
                <label for="price">Harga</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" id="price" name="price" value="">
                </div>
                <div class="form-group">
                  <label for="payment">Pembayaran</label>
                  <select class="form-control" name="payment">
                    <option value="" selected>Pembayaran</option>
                    <option value="debt">Hutang</option>
                    <option value="paid off">Lunas</option>
                  </select>
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
          <h3 class="panel-title">Tansaksi Pembelian</h3>
        </div>
        <div class="panel-body">
          @if($errors->has('item'))
          <span class="help-block" >{{ $errors->first('item') }}</span>
          @endif
          <div class="{{ $errors->has('item')? 'has-error':'' }} "></div>
          <form action="{{ route('print.item.seller') }}" method="post">
            @csrf
            <input type="hidden" name="saller_id" value="{{ $seller->id }}">
            <button type="submit" class="btn btn-info"><span class="lnr lnr-printer"></span> Print</button>
            <table class="table table-striped">
            <thead>
              <tr>
                <th> <input class="form-check-input" type="checkbox" id="checkall" value="option2"> </th>
                <th>TANGGAL</th>
                <th>TONASE</th>
                <th>HARGA</th>
                <th>PEMBAYARAN</th>
                <th>NO NOTA</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $seller->item as $item )
              <tr>
                <td> <input class="form-check-input itemchecked" type="checkbox" name="item[{{ $item->id }}]" value="{{ $item->id }}"> </td>
              </form>
                  <td> {{ $item->date($item->created_at) }} </td>
                  <td> {{ $item->tonase }} </td>
                  <td> Rp. {{ number_format($item->price, 2, ',', '.') }} </td>
                  <td> {{ $item->payment }} </td>
                  <td>
                    <form action="{{ route('print.note') }}" id="note" method="post">
                      @csrf
                      <input type="hidden" name="saller_id" value="{{ $seller->id }}">
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
  function noteSubmit() {
    document.getElementById("note").submit();
  }
  $(document).ready(function() {
    $('#get-tonase').click(function(){
      $.ajax({
        url:"http://localhost/salakscales/api/tonase",
        type:"GET",
        async : true,
        success:function(result)
        {
          let getTonaseData = JSON.stringify(result.data[0].tonase)
          let tonase = getTonaseData / '1000'
          $('#tonase').val(tonase)
        }
      });
    })
    $('#price').click(function(){
      $.ajax({
        url:"http://localhost/salakscales/api/setting/"+user_id,
        type:"GET",
        async : true,
        success:function(result)
        {
          let priceData = JSON.stringify(result.data[0].price)
          let getTonase = $('#tonase').val()
          let sumPrice = getTonase * priceData
          $('#price').val(sumPrice)
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
