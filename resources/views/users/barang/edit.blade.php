@extends('layouts.master')
@section('title') Edit Barang  @endsection
@section('content')
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Edit Data</h3>
		</div>
		<div class="panel-body">
			<form action="{{ route('barang.update',$item->id) }}" method="post">
				@csrf
				{{ method_field('PUT') }}
				<input type="hidden" name="seller_id" value="{{ $item->seller_id }}">
                <label for="tonase">Tonase</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="tonase" id="tonase" value="{{$item->tonase}}">
                  <span class="input-group-addon">Kg</span>
                </div>
                <a href="#" class="btn btn-primary" style="margin-top: 10px; margin-bottom: 10px" id="get-tonase">Timbang</a>
                <label for="price">Harga</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" name="price" id="price" value="{{$item->price}}">
                </div>
                <div class="form-group">
                  <label for="payment">Pembayaran</label>
                  <select class="form-control" name="payment">
                    <option value="" >Pembayaran</option>
                    <option value="debt" @if($item->payment == 'debt')selected @endif >Hutang</option>
                    <option value="paid off" @if($item->payment == 'paid off')selected @endif>Lunas</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="payment">Status</label>
                  <select class="form-control" name="status">
                    <option value="">Pembayaran</option>
                    <option value="process" @if($item->status == 'process')selected @endif >proses</option>
                    <option value="sold" @if($item->status == 'sold')selected @endif>terjual</option>
                  </select>
                </div>
                <button type=" submit " class="btn btn-primary">Save</button>
			</form>
		</div>
	</div>
@endsection
@section('footer')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  const user_id = {{$user}}
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