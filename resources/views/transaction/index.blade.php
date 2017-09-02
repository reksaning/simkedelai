@extends('layouts.master')

@section('content')
<!-- Page Header-->
<header class="page-header" style="box-shadow: none">
  <div class="container-fluid">
    {{-- <h2 class="no-margin-bottom">Daftar stok kedelai</h2> --}}
  </div>
</header>

<div class="content-wrapper">
	<!-- Dashboard Counts Section-->
	<section class="dashboard-counts p-0" style="background: white">
	  <div class="container">
	    <div class="row">
	      <div class="col-12">
	        @include('layouts.alerts')
	        <h1 class="text-light" style="font-size: 2rem;">Daftar kedelai Onfarm dan Pasca panen</h1>
	        <div class="text-muted">
	          <span class="pr-4"><i class="fa fa-user-o mr-3"></i> Total pembelian: {{ $transactions->sum('total_quantity') }} Kg</span>
	          <span class="pr-4"> <i class="fa fa-envira mr-3"></i> Panen terakhir: 7 Agustus 2017</span>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	    	<div class="col-12">
			    <div class="my-4 clearfix d-flex flex-wrap justify-content-between align-items-center">
				    <a class="btn btn-info" href="/transaction/create"><i class="fa fa-plus"></i> Pesan kedelai</a>
				    <form class="ml-auto">
				      <div class="input-group">
				        <input id="inlineFormInput" type="text" placeholder="Cari transaksi" class="form-control">
				        <span class="input-group-btn">
									<button type="button" class="btn btn-primary">Cari</button>
								</span>
				      </div>
				    </form>
			    </div>
			    <div class="table-responsive">
			      <table class="table table-hover">
			      	  <thead>
			      	    <tr>
			      	      <th>#</th>
			      	      <th>Transaksi</th>
			      	      <th>Jumlah kedelai</th>
			      	      <th class="hidden-sm-down">Total pembayaran</th>
			      	      <th>Status</th>
			      	    </tr>
			      	  </thead>
			      	  <tbody>
			      	  	@foreach ($transactions as $transaction)
			      	  		<tr>
			      	  		  <th scope="row" class="align-middle">{{ $loop->index+1 }}</th>
			      	  		  <td>
			      	  		  	<b class="text-primary">{{ $transaction->code }}</b><br>
			      	  		  	{{ $transaction->created_at->diffForHumans() }}
			      	  		  </td>
			      	  		  <td class="align-middle">{{ $transaction->total_quantity }} Kg</td>
			      	  		  <td class="align-middle hidden-sm-down">Rp. {{ $transaction->formattedTotalPayment() }} </td>
			      	  		  <td class="align-middle"><span class="badge badge-{{ $transaction->status->status_color }}" style="font-size: 100%">{{ $transaction->status->name }}</span></td>
			      	  		</tr>
			      	  	@endforeach
			      	  </tbody>
			      	</table>
			    </div>
	    	</div>
	    </div>
	  </div>
	</section>
</div>


@endsection