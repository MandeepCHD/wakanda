@include('header')
@inject('trade', 'App\Http\Controllers\BuySellController')
		<!-- main content start-->
		<div id="page-wrapper" style="padding-left:0px; padding-right:5px;">
			<div class="main-page mp">
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

                @if(count($errors) > 0)
		        <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            @foreach ($errors->all() as $error)
                            <i class="fa fa-warning"></i> {{ $error }}
                            @endforeach
                        </div>
                    </div>
                </div>
				@endif
				
				
				<div class="row" style="background-color:#171e2b; padding:20px 20px 10px 10px;">

							<div class="col-lg-6 col-md-6 col-sm-6" style="padding-top:10px">
							    <h4 class="mybtn">
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket" style="margin: 10px">Forex</a>
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket" style="margin: 10px">Stock</a>
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket" style="margin: 10px">Cryptocurrency</a>
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket " style="margin: 10px">Indices</a>
    							<a href="javascript:void(0)" class="d-inline mr-4 chartmarket " style="margin: 10px">CFD</a>
    							</h4>
							</div>
							
							
							<div class="col-lg-6 col-md-6 col-sm-6">
    							<div class="wrap-section">
									
										<button class="btn btn-success d-inline" data-toggle="modal" data-target="#buyModal" style="margin-right:10px;padding:9px 30px; text-align:center;"><h4><i class="fa fa-level-up"> &nbsp;</i>Buy</h4></button>
										<button class="btn btn-danger by d-inline" data-toggle="modal" data-target="#sellModal" style="margin-right:10px; padding:9px 30px;"><h4><i class="fa fa-level-down"> &nbsp;</i>Sell</h4></button>
									
    
								</div>
    							{{-- <a class="d-inline m-4 badge badge-primary" style="margin: 10px; font-size: 15px">
    							<strong>Account Type:</strong> {{$pname}} 
    							@if(Auth::user()->acnt_type_active == "no")
    							<i class="fa fa-exclamation-triangle text-danger" data-toggle="tooltip" data-placement="top" title="Account Not Active"></i>
    							@else
    							 <i class="fa fa-check-square text-success"  data-toggle="tooltip" data-placement="top" title="Account is Active"></i>
    							  @endif
    							</a>
    							<a href="#" data-toggle="modal" data-target="#switchtypeModal" class="d-inline btn btn-sm btn-primary rounded-pill">Switch Type</a> --}}
    							
							{{-- <strong class="btn btn-success bal" style="float:right;"><h3>Bal: {{$settings->currency}}{{ number_format(Auth::user()->account_bal, 2, '.', ',')}}</h3></strong> --}}
							
						</div>
					<div class="clearfix"> </div>
				</div>

				{{-- <div class="row-one" style="background-color:#171e2b; margin-top:10px; text-align:center;">
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-briefcase fa-stack-1x"></i>
                        </span>
					    DEPOSITED
					    </h4>
						<h3 style=" margin-top:20px;" title="Your account balance">
						    @foreach($deposited as $deposited)
						    @if(!empty($deposited->count))
							{{$settings->currency}}{{$deposited->count}}
							@else
							{{$settings->currency}}0.00
							@endif
							@endforeach
						</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon2-background"></i>
                          <i class="fa fa-lock fa-stack-1x"></i>
                        </span>
					    PROFIT
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							{{$settings->currency}}{{ number_format(Auth::user()->roi, 2, '.', ',')}}
						</h3>
					</div>
					
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-gift fa-stack-1x"></i>
                        </span>
					    BONUS
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							{{$settings->currency}} {{ number_format($total_bonus->bonus, 2, '.', ',')}}
						</h3>
					</div>
					<div class="col-md-3 col-sm-6 rp t-b">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon3-background"></i>
                          <i class="fa fa-bullhorn fa-stack-1x"></i>
                        </span>
					    REF. BONUS
					    </h4>
						<h3 style="margin-top:20px; text-align:center;" title="Your account balance">
							{{$settings->currency}}{{ number_format(Auth::user()->ref_bonus, 2, '.', ',')}}
						</h3>
					</div>

					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-money fa-stack-1x"></i>-->
     <!--                   </span>-->
					<!--    BALANCE-->
					<!--	</h4>-->
					<!--	<div class="row"  style="display:inline;">-->
					<!--	<div class="col-lg-6 col-md-6"  style="display:inline;">-->
					<!--	<h3 style="text-align:center;" title="Your account balance">-->
					<!--	<small>Main balance<br>-->
					<!--		{{$settings->currency}}{{ number_format(Auth::user()->account_bal, 2, '.', ',')}}</small>-->
					<!--	</h3>-->
					<!--	</div>-->
					<!--	<div class="col-lg-6 col-md-6" style="display:inline;">-->
					<!--	<h3 style="text-align:center;" title="Your trading balance">-->
					<!--	<small>Trading account<br>-->
					<!--		{{$settings->currency}}{{ number_format($trade->get_bal(Auth::user()->id,"USD"), 2, '.', ',')}}</small>-->
					<!--	</h3>-->
					<!--	</div>-->
					<!--	</div>-->
					<!--</div>-->

					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-unlock fa-stack-1x"></i>-->
     <!--                   </span>-->
					<!--    TOTAL PACKAGES-->
					<!--    </h4>-->
					<!--	<h3 style=" margin-top:20px;" title="Your account balance">-->
					<!--	@if(count($user_plan)>0)-->
					<!--	   {{$user_plan->count()}}-->
					<!--	@else-->
					<!--		0-->
					<!--	@endif-->
					<!--	</h3>-->
					<!--</div>-->
					<!--<div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">-->
					<!--    <h4>-->
					<!--    <span class="fa-stack">-->
     <!--                     <i class="fa fa-circle fa-stack-2x icon1-background"></i>-->
     <!--                     <i class="fa fa-unlock-alt fa-stack-1x" ></i>-->
					<!--	</span>-->
					<!--	ACTIVE PACKAGES-->
					<!--    </h4>-->
					<!--	<h3 style=" margin-top:20px;" title="Your account balance">-->
					<!--		@if(count($user_plan_active)>0)-->
					<!--	   {{$user_plan_active->count()}}-->
					<!--		@else-->
					<!--			0-->
					<!--		@endif-->
					<!--	</h3>-->
					<!--</div>-->
					<!-- <div class="col-md-4 col-sm-6 rp t-b" style="margin-top: 8px;">
					    <h4>
					    <span class="fa-stack">
                          <i class="fa fa-circle fa-stack-2x icon1-background"></i>
                          <i class="fa fa-money fa-stack-1x"></i>
                        </span>
					    FEES
						</h4>
						<div class="row"  style="display:inline;">
						<div class="col-lg-6 col-md-6"  style="display:inline;">
						<h3 style="text-align:center;" title="Last fee paid">
						<small>Last Fee<br>
							{{$settings->currency}}{{ number_format($last_fee, 2, '.', ',')}}</small>
						</h3>
						</div>
						<div class="col-lg-6 col-md-6" style="display:inline;">
						<h3 style="text-align:center;" title="Total fees paid">
						<small>Total Fee<br>
						{{$settings->currency}}{{ number_format($total_fee, 2, '.', ',')}} </small>
						</h3>
						</div>
						</div>
					</div> -->
					<!--
					@if(empty($uplan))
					<div class="col-md-3 rp" style="text-align:center; color:#fa3425;">
					<h4>Activate account!<br>
					<small>
					<a style="background-color:#fa3425; color:#fff; padding:4px;" href="{{ url('dashboard/mplans') }}">Join a plan</a> 
					</small>
					</h4>
					</div>
					@else
					<div class="col-md-3 rp">
						<h4>
						    <small>Current plan</small><br>
						    <strong>{{$uplan->name}}</strong>
							 
						</h4>
					</div>
					@endif	
					-->
					


				
				<div class="clearfix"> </div>
			</div> --}}
					

			<div class="row">
				<div class="col-lg-12 col-md-6 col-sm-6" style="padding:0">
					<div class="assets">
						<ul class="list-unstyled">
							<li class="asset">
								<a href="#" class="active">USD/AUD</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">USD/CHF</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">NGN/USD</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class="active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class="active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class=" active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class="active">GBD/URD</a>
							</li>
							<li class="asset">
								<a href="#" class="active">GBD/URD</a>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
			<div id="chart-page">
                @include('chart')
			</div>
			
			{{-- 
	closed order tables Data --}}
	<div class="row ">
              
		<div class="col-lg-12 col-md-6 col-sm-6">

			<div class="close-orders">
				<div class="heady">
					<div id="material-tabs" class="material__tabs">
						<a id="tab1-tab active" href="#tab1" >Active orders</a>
						<a id="tab2-tab" href="#tab2" >Closed orders</a>
						<a id="tab3-tab" href="#tab3" >Balance</a>
						<span class="yellow-bar"></span>
					</div>
				  </div>
			
				<div class="tab-content">
					<div id="tab1">
						<div class="shadow table-responsive">
						  <table id="dtBasicExample" class="table table-striped">
							<thead class="bg-light">
								{{-- Table header for Active Orders --}}
							  <tr>
								<th scope="col" >Opened at</th>
								<th scope="col">Buy/sell</th>
								<th scope="col">Baseprice</th>
								<th scope="col">quoteprice</th>
								<th scope="col">Asset</th>
								<th scope="col">Now</th>
								<th scope="col">Operation</th>
							  </tr>
							</thead>
							<tbody>
							<tr>
							  <td scope="row">1</td>
							  <td>2</td>
							  <td>3</td>
							  <td>4</td>
							  <td>5</td>
							  <td>6</td>
							  <td>7</td>
							</tr>
							</tbody>
						  </table>
						</div>
					</div>
					<div id="tab2">
						<div class="shadow table-responsive">
						  <table id="dtBasicExample" class="table table-hover table-borderless">
							<thead class="bg-light">
								<tr>
									<th scope="col" >Opened at</th>
									<th scope="col">Buy/sell</th>
									<th scope="col">Baseprice</th>
									<th scope="col">quoteprice</th>
									<th scope="col">Asset</th>
									<th scope="col">Now</th>
									<th scope="col">Operation</th>
								  </tr>
							</thead>
							<tbody>
							  <tr>
								<td scope="row"></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							  </tr>
							 
							</tbody>
						  </table>
						</div>
					</div>
	
					<div id="tab3">
						<div class="shadow table-responsive">
						  <table id="dtBasicExample" class="table table-hover table-borderless">
							<thead class="bg-light">
								<tr>
									<th scope="col" >wallet</th>
									<th scope="col">balance</th>
									<th scope="col">Lastupdate</th>
									
								  </tr>
							</thead>
							<tbody>
							  <tr>
								<td scope="row"></td>
								<td></td>
								<td></td>
							  </tr>
							 
							</tbody>
						  </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	


	<!-- Modal -->
	<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Buy Order <span style="display:none;" id="price_c"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form  id="buysellorder" role="form" method="post" action="javascript:void(0)">
						<div class="form-row">
							<div class="col-md-6"  style="margin-bottom: 5px">
								<label >Volume in base currency</label>
								<input type="number" min="0" step="any" id="pinput1" onkeyup="priceFunction1(this)" name="base_amount" class="form-control" placeholder="Amount to Buy" required>
							</div>

							<div class="col-md-6"  style="margin-bottom: 5px">
								<label>Amount in quote currency</label>
								<input type="number" min="0" step="any" id="pinput2" onkeyup="priceFunction2(this)" name="quote_amount" class="form-control" placeholder="Amount in quote currency">
							</div>

						</div>
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Instrument</label>
								<input type="text"  name="market_pair" id="bmarket" class="form-control" placeholder="market" value="BTCUSD" required>
							</div>
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 15px">
								<label>Type</label>
								<select name="ordertype" id="" class="form-control">
									<option value="Market Execution">Market Execution</option>
								</select>
							</div>
						</div>
						
						<div  style="padding:5px; margin-bottom: 5px">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="type" value="Buy">
						<button class="btn btn-success btn-block" type="submit">Buy Now</button>
						</div>
					</form>

					<!-- <script type="text/javascript">


                            //create investment
							$("#buyorder").on('submit',function(){
                                $.ajax({
                                    url: "{{url('/dashboard/addbuyorder')}}",
                                    type: 'POST',
                                    data:$("#buyorder").serialize(),
                                    success: function (response) {
                                        if(response.status ===200){
                                            swal({
                                        icon: "success",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                        if(response.status ===201){
                                            swal({
                                        icon: "error",
                                        text: response.message,
                                        timer:6000,
                                        });
										location.reload(true);
                                        }
                                    },
                                    error: function (data) {
                                        swal({
                                        icon: "error",
                                        text: "Something went wrong", 
                                        timer:6000,
                                        });
                                    },

                                });
                            });

					$(document).ready(function () {
						$("#market").change(function () {
							var val = $(this).val();
							if (val == "Cryptocurrency") {
								$("#asset").html("{!! $trade->getAssets('Cryptocurrency') !!}");
							} else if (val == "Stock") {
								$("#asset").html("{!! $trade->getAssets('Stock') !!}");
							} else if (val == "Currency") {
								$("#asset").html("{!! $trade->getAssets('Currency') !!}");
							} else if (val == "CFD") {
								$("#asset").html("{!! $trade->getAssets('CFD') !!}");
							}else if(val == "Indices"){
								$("#asset").html("{!! $trade->getAssets('Indices') !!}");
							}
						});
					});
				</script> -->
				</div>
			</div>
		</div>
	</div>



					
		<!-- Modal -->
		<div class="modal fade" id="sellModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Sell Market</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="buysellorder" role="form" method="post" action="javascript:void(0)">
						<div class="form-row">
							<div class="col-md-6"  style="margin-bottom: 5px">
								<label >Volume in base currency</label>
								<input type="number" min="0" step="any" id="sinput1" onkeyup="spriceFunction1(this)" name="base_amount" class="form-control" placeholder="Amount to Sell" required>
							</div>

							<div class="col-md-6"  style="margin-bottom: 5px">
								<label>Amount in quote currency</label>
								<input type="number" min="0" step="any" id="sinput2" onkeyup="spriceFunction2(this)" name="quote_amount" class="form-control" placeholder="Amount in quote currency">
							</div>

						</div>
						<div class="form-row mb-3" >
							<div class="col-md-6 mb-3"  style="margin-bottom: 5px">
							<label>Instrument</label>
								<input type="text"  name="market_pair" id="smarket" class="form-control" placeholder="market" value="BTCUSD" required>
							</div>
							</div>
							<div class="col-md-6 mb-3"  style="margin-bottom: 15px">
								<label>Type</label>
								<select name="ordertype" id="" class="form-control">
									<option value="Market Execution">Market Execution</option>
								</select>
							</div>
						</div>

							<div  style="padding:5px; margin-bottom: 5px">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="type" value="Sell">
							<button class="btn btn-danger btn-block" type="submit">Sell by Market</button>
							</div>
							
						</form>

						<!-- <script type="text/javascript">

							// $("#sellorder").on('submit',function(){
                            //     $.ajax({
                            //         url: "{{url('/dashboard/addsellorder')}}",
                            //         type: 'POST',
                            //         data:$("#sellorder").serialize(),
                            //         success: function (response) {
                            //             if(response.status ===200){
                            //                 swal({
                            //             icon: "success",
                            //             text: response.message,
                            //             timer:6000,
                            //             });
							// 			location.reload(true);
                            //             }
                            //             if(response.status ===201){
                            //                 swal({
                            //             icon: "error",
                            //             text: response.message,
                            //             timer:6000,
                            //             });
							// 			location.reload(true);
                            //             }
                            //         },
                            //         error: function (data) {
                            //             swal({
                            //             icon: "error",
                            //             text: "Something went wrong", 
                            //             timer:6000,
                            //             });
                            //         },

                            //     });
                            // });



							$(document).ready(function () {
								$("#mark").change(function () {
									var val = $(this).val();
									if (val == "Cryptocurrency") {
										$("#ass").html("{!! $trade->getAssets('Cryptocurrency') !!}");
									} else if (val == "Stock") {
										$("#ass").html("{!! $trade->getAssets('Stock') !!}");
									} else if (val == "Currency") {
										$("#ass").html("{!! $trade->getAssets('Currency') !!}");
									} else if (val == "CFD") {
										$("#ass").html("{!! $trade->getAssets('CFD') !!}");
									}else if(val == "Indices"){
										$("#ass").html("{!! $trade->getAssets('Indices') !!}");
									}
								});
							});
						</script> -->
					</div>
					
				</div>
			</div>
		</div>
						<!-- Bu modal -->

	@include('modals')		
	@include('footer')
	