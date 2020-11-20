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
					<table class="table table-hover" id="table"> 
						<thead> 
							<tr> 
                                <th>ACTIONS</th>
                                <th>CLIENT NAME</th> 
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
                                <td><a href="#" data-toggle="modal" data-target="#editorder{{$deposit->id}}" class="btn btn-primary">Edit Order</a><br>
                                 <a class="btn btn-default" href="{{ url('dashboard/closeorder') }}/{{$deposit->id}}">Close</a>
                                 </td> 
                                <td>{{$deposit->duser->name}} {{$deposit->duser->l_name}}</td> 
								 <td>#{{$deposit->order_type}}</td> 
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


                            <!-- Edit user Modal -->
								<div id="editorder{{$deposit->id}}" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title" style="text-align:center;">Edit Order details.</strong></h4>
								</div>
								<div class="modal-body">
                                    <form  id="buyorder" role="form" method="post" action="{{action('Controller@editorder')}}">
                                        <div class="form-row">
                                            <div class="col-md-6"  style="margin-bottom: 5px">
                                                <label >Volume</label>
                                                <input type="number" value="{{$deposit->orders}}" name="amount" class="form-control" placeholder="Amount to Buy" required>
                                            </div>

                                            <div class="col-md-6"  style="margin-bottom: 5px">
                                                <label>Type</label>
                                                <select name="type" id="" class="form-control">
                                                <option value="{{$deposit->type}}">{{$deposit->type}}</option>
                                                    <option value="Market Execution">Market Execution</option>
                                                    <option value="Pending Order">Pending Order</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                                <label>Market</label>
                                                <select name="market" id="market" class="form-control">
                                                    <option value="{{$deposit->market}}">{{$deposit->market}}</option>
                                                    <option value="Cryptocurrency">Cryptocurrency</option> 
                                                    <option value="Stock">Stock</option> 
                                                    <option value="Currency">Currency</option> 
                                                    <option value="Commodity">CFD</option> 
                                                    <option value="Commodity">Indices</option> 
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                                <label>Asset</label>
                                                <select name="symbol" class="form-control">
                                                    <option value="{{$deposit->symbol}}">{{$deposit->symbol}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Stop Loss</label>
                                            <input type="text" value="{{$deposit->stoploss}}"  name="stoploss" class="form-control" placeholder="0.000" required>
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Take Profit</label>
                                            <input type="text" value="{{$deposit->takeprofit}}" name="takeprofit" class="form-control" placeholder="0.000" required>
                                            </div>
                                        </div>
                                        <div class="form-row mb-3" >
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Profit</label>
                                            <input type="text"  name="profitt" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-3"  style="margin-bottom: 5px">
                                            <label>Loss</label>
                                            <input type="text" name="losss" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mb-3" style="margin-bottom: 5px">
                                            <div class="col-md-12 mb-3">
                                            <label>Comment</label>
                                            <input type="text" name="comment" value="{{$deposit->comment}}" class="form-control"> <br>
                                            </div>
                                        </div>
                                        
                                        <div  style="padding:5px; margin-bottom: 5px">
                                        <input type="hidden" name="profit" value="{{$deposit->profit}}">
										<input type="hidden" name="loss" value="{{$deposit->loss}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="user_id" value="{{$deposit->user}}">
										<input type="hidden" name="id" value="{{$deposit->id}}">
                                        <button class="btn btn-success btn-block" type="submit">Update</button>
                                        </div>
                                    </form>
								</div>
								</div>
							</div>
							</div>
							<!-- /Edit user Modal -->
							@endforeach
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        
		@include('footer')