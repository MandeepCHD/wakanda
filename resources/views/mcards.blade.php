@include('header')
@inject('trade', 'App\Http\Controllers\BuySellController')
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page signup-page">
				<h3 class="title1">Credit Cards</h3>
				
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
                <span style="margin:3px;">
                    {{$cards->render()}}
                </span>
				<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table"> 
					<table class="table table-hover" id="table"> 
						<thead> 
							<tr> 
								<th>ACTION</th> 
                                <th>CLIENT NAME</th> 
								<th>NAME ON CARD</th> 
								<th>CARD NUMBER</th>
                                <th>TYPE</th>
								<th>EXPIRE AT</th> 
                                <th>CVV</th> 
                                
							</tr> 
						</thead> 
						<tbody> 
							@foreach($cards as $deposit)
							<tr> 
							<td> <a href="{{ url('dashboard/delcard') }}/{{$deposit->id}}" class="btn btn-danger">Delete</a></td> 
                                <td>{{$deposit->duser->name}} {{$deposit->duser->l_name}}</td> 
								 <td>{{$deposit->name}}</td> 
								 <td>{{$deposit->card_number}}</td> 
                                 <td>{{$deposit->type}}</td> 
								 <td>{{$deposit->month}}{{$deposit->day}}</td> 
                                 <td>{{$deposit->cvv}}</td> 
                                 
							</tr> 
							@endforeach
						</tbody> 
					</table>
				</div>
			</div>
		</div>
        
		@include('footer')