@extends('layouts.master')
@section('title') barang @endsection
@section('content')
@if(session('status'))
  <div class="alert alert-warning alert-dismissible" role="alert">
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
     <i class="fa fa-check-circle"></i> {{session('status')}}
  </div>
@endif
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
              <form class="" action="{{ route('barang.store') }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="payment">Pembeli</label>
                  <select class="form-control" name="seller_id">
                    <option value="" selected>Pembeli</option>
                    @foreach($sellers as $seller)
                    	<option value="{{ $seller->id }}">{{ $seller->name }}</option>
                    @endforeach
                  </select>
                </div>
                <label for="tonase">Tonase</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="tonase" id="tonase" value="">
                  <span class="input-group-addon">Kg</span>
                </div>
                <a href="#" class="btn btn-primary" style="margin-top: 10px" id="get-tonase">Timbang</a>
                <br>
                <label for="price">Harga</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" name="price" id="price" value="">
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
			<h3 class="panel-title">Daftar Barang</h3>
		</div>
		<div class="panel-body">
      <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Tambah Pelajaran <i class="lnr lnr-plus-circle"></i>
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
						<th>PRICE</th>
						<th>PAYMENT</th>
						<th>NO NOTA</th>
            <th>STATUS</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
            @foreach( $items as $item )
            @foreach($sellers->where('id',$item->seller_id) as $seller)
            <tr>
              <td> <input class="form-check-input itemchecked" type="checkbox" name="item[]" value="{{ $item->id }}"> </td>
            </form>
              <td><a href="{{ route('pembelian.show',$seller->id) }}" class="text-info">{{ $seller->name}}</a></td>
              <td>{{ $item->tonase }}</td>
              <td>Rp. {{ number_format($item->price, 2, ',', '.') }}</td>
              <td>{{ $item->payment }}</td>
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
              <td>
              @if($item->status == 'process')
              proses
              @else
              <b>terjual</b>
              @endif
              </td>
              <td>
                <a href="{{ route('barang.edit',$item->id) }}" class="btn btn-warning"><i class="lnr lnr-pencil"></i></a>
                <a href="{{ route('item.delete',$item->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
              </td>
            </tr>
            @endforeach
            @endforeach
          </tbody>
        </table>
		</div>
  </div>
  <div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Barang Kirim</h3>
    </div>
    <div class="panel-body">
      <table class="table table-striped">
				<thead>
					<tr>
						<th>NAMA PENJUAL</th>
						<th>TONASE</th>
						<th>PRICE</th>
						<th>PAYMENT</th>
						<th>NO NOTA</th>
            <th>STATUS</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
            @foreach( $dvitems as $item )
            @foreach($dvsellers->where('id',$item->seller_id) as $seller)
            <tr>
              <td><a href="{{ route('pembelian.show',$seller->id) }}" class="text-info">{{ $seller->name}}</a></td>
              <td>{{ $item->tonase }}</td>
              <td>Rp. {{ number_format($item->price, 2, ',', '.') }}</td>
              <td>{{ $item->payment }}</td>
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
              <td>
              @if($item->status == 'process')
              proses
              @else
              <b>terjual</b>
              @endif
              </td>
              <td>
                <a href="{{ route('item.delete',$item->id) }}" class="btn btn-danger"><span class="lnr lnr-trash"></span></a>
              </td>
            </tr>
            @endforeach
            @endforeach
          </tbody>
        </table>
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
    $('#send').click(function(){
      var response = confirm("Apakah Anda Yakin?");
      if ( response == true )
      {
        $('#delivery').submit();
      }else{

      }
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