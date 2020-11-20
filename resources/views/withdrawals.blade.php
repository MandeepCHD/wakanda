@include('header')
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				
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

               <!-- <a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal"><i class="fa fa-plus"></i> Request withdrawal</a>-->
			   

                <div class="row">
                    <h3 class="title1">Select a method</h3>
					<span class="badge badge-success"><h3>Available balance: {{$settings->currency}}{{ number_format(Auth::user()->account_bal, 2, '.', ',')}}</h3></span>
                    @foreach($wmethods as $method)
                    <div class="col-lg-12 well mt-3" style=" background-color:#171e2b; margin-top:20px;	max-height:400px; overflow: auto;">
						@if($method->name == "Credit Card")
						<a data-toggle="modal" data-target="#withdrawalModal{{$method->id}}" href="#">
						<strong>Credit card: 
							<img src="{{ asset('home/images/c3.jpg')}}" width="100px;" height="70px;"> 
							<img src="{{ asset('home/images/c2.jpg')}}" width="70px;" height="70px;">
						</strong>
						</a>
						@elseif($method->name == "Bitcoin")
						<a data-toggle="modal" data-target="#withdrawalModal{{$method->id}}" href="#">
							<strong>BTC:</strong>
							<img src="{{ asset('home/images/btc.png')}}" width="100px;" height="100px;">
						</a>
						@elseif($method->name == "Ethereum")
						<a data-toggle="modal" data-target="#withdrawalModal{{$method->id}}" href="#">
							<strong>ETH:</strong>
							<img src="{{ asset('home/images/eth.png')}}" width="100px;" height="100px;">
						</a>
						@elseif($method->name == "Litecoin")
						<a data-toggle="modal" data-target="#withdrawalModal{{$method->id}}" href="#">
							<strong>LTC:</strong>
							<img src="{{ asset('home/images/ltc.png')}}" width="100px;" height="100px;">
						</a>
						@elseif($method->name == "Bank transfer")
						<a data-toggle="modal" data-target="#withdrawalModal{{$method->id}}" href="#">
							<strong>Bank transfer:</strong>
							<img src="{{ asset('home/images/bank-transfer.png')}}" width="100px;" height="100px;">
						</a>
						@endif
                                    <!-- Panel Heading Starts
                        	<div class="panel-heading">
                                <h3>
                                    {{$method->name}}
                                </h3>
                        	</div>
                                   
                            <div class="panel-body">
    						<h4>Minimum amount: <strong style="float:right;"> {{$settings->currency}}{{$method->minimum}}</strong></h4><br>
    						
    						<h4>Maximum amount:<strong style="float:right;"> {{$settings->currency}}{{$method->maximum}}</strong></h4><br>
    						
    						<h4>Charges (Fixed):<strong style="float:right;"> {{$settings->currency}}{{$method->charges_fixed}}</strong></h4><br>
    						
    						<h4>Charges (%): <strong style="float:right;"> {{$method->charges_percentage}}%</strong></h4><br>
    						
    						<h4>Duration:<strong style="float:right;"> {{$method->duration}}</strong></h4><br>
    						
    						<a class="btn btn-default" href="#" data-toggle="modal" data-target="#withdrawalModal{{$method->id}}"><i class="fa fa-plus"></i> Request withdrawal</a>
    						</div> -->
                    </div>
                    
                    <!-- Withdrawal Modal -->
        			<div id="withdrawalModal{{$method->id}}" class="modal fade" role="dialog">
        			  <div class="modal-dialog">
        
        			    <!-- Modal content-->
        			    <div class="modal-content">
        			      <div class="modal-header">
        			        <button type="button" class="close" data-dismiss="modal">&times;</button>
        			        <h4 class="modal-title" style="text-align:center;">Payment will be sent through your selected method.</h4>
        			      </div>
        			      <div class="modal-body">
                                <form style="padding:3px;" role="form" method="post" action="{{action('SomeController@withdrawal')}}">
        					   		<input style="padding:5px;" class="form-control" placeholder="Enter amount here" type="text" name="amount" required><br/>
        					   		<input style="padding:5px;" class="form-control" value="{{$method->name}}" type="text" disabled><br/>
        					   		<input value="{{$method->name}}" type="hidden" name="payment_mode">
        					   		<input value="{{$method->id}}" type="hidden" name="method_id"><br/>
                                       
        					   		<input type="hidden" name="_token" value="{{ csrf_token() }}">
        					   		<input type="submit" class="btn btn-default" value="Submit" onclick="this.disabled = true; form.submit(); this.value='Please Wait ...';" />
        					   </form>
        			      </div>
        			    </div>
        			  </div>
        			</div>
        			<!-- /Withdrawals Modal -->
                    @endforeach
                </div>
				
                <h3 class="title1">Your Withdrawals</h3>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover"> 
						<thead> 
							<tr> 
								<th>ID</th> 
								<th>Amount requested</th>
								<th>Amount + charges</th>
                                <th>Recieving mode</th>
								<th>Status</th> 
                                <th>Date created</th>
							</tr> 
						</thead> 
						<tbody> 
							@foreach($withdrawals as $withdrawal)
							<tr> 
								<th scope="row">{{$withdrawal->id}}</th>
								 <td>{{$withdrawal->amount}}</td>
								 <td>{{$withdrawal->to_deduct}}</td> 
								 <td>{{$withdrawal->payment_mode}}</td> 
                                 <td>{{$withdrawal->status}}</td> 
								 <td>{{$withdrawal->created_at}}</td> 
							</tr> 
							@endforeach
						</tbody> 
					</table>
				</div>
			</div>
		</div>
		@include('footer')