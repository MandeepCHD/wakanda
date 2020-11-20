@include('header')
@inject('trade', 'App\Http\Controllers\BuySellController')
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Your Buy/Sell Orders</h3>
				
				@if(Session::has('message'))
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i> {{ Session::get('message') }}
                        </div>
                    </div>
                </div>
                @endif

				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ORDER ID</th> 
								<th>TYPE</th>
                                <th>OPEN AT</th>
								<th>VOLUME</th> 
								<th>MARKET</th>
								<th>SYMBOL</th> 
                                <th>S/L</th>
                                <th>T/P</th>
                                <th>STATUS</th>
								<th>CLOSE AT</th> 
                                <th>PROFIT</th>
                                <th>LOSS</th>
							</tr> 
						</thead> 
						<tbody> 
							@foreach($orders as $deposit)
							<tr> 
								 <td>{{$deposit->order_type}}</td> 
								 <td>{{$deposit->type}}</td> 
                                 <td>{{$deposit->created_at}}</td> 
								 <td>{{$settings->currency}}{{$deposit->orders}}</td> 
								 <td>{{$deposit->market}}</td> 
                                 <td>{{$deposit->symbol}}</td> 
								 <td>{{$deposit->stoploss}}</td> 
                                 <td>{{$deposit->takeprofit}}</td> 
								 <td>{{$deposit->status}}</td> 
                                 <td>{{$deposit->closed_at}}</td> 
								 <td>{{$settings->currency}}{{$deposit->profit}}</td> 
                                 <td>{{$settings->currency}}{{$deposit->loss}}</td> 
							</tr> 
							@endforeach
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        
		@include('footer')