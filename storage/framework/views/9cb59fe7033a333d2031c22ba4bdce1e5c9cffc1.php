	<!--footer-->
		<div class="footer">
		   <p>All Rights Reserved &copy; <?php echo e($settings->site_name); ?> <?php echo e(date('Y')); ?></p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->


	<!-- trading JS -->

	<script>
$('#switchbox').change('checked',function(){
        if(this.checked) {
			var url = "<?php echo e(url('/dashboard/autotrade/on')); ?>";
        }
        else{
			var url = "<?php echo e(url('/dashboard/autotrade/off')); ?>";
        }
        $.ajax({
            url: url,
            type: 'GET',
            data:$('#auto').serialize(),
            success: function (data) {
                swal({
                icon: "success",
                text: data.message,
                timer:6000,
                });
                //location.reload(true);
            },
            error: function (data) {
                swal({
                icon: "error",
                text: "Something went wrong", 
                timer:9000,
                });
            },
        });
	});
	
	//calculate real time price buy and sell form
	function priceFunction1(input1) {
		var c_price = document.getElementById('price_c').innerHTML;
		var input2 = document.getElementById('pinput2');
		input2.value = input1.value*c_price;
	}

	function priceFunction2(input2) {
		var c_price = document.getElementById('price_c').innerHTML;
		var input1 = document.getElementById('pinput1');
		input1.value = input2.value/c_price;
	}

	function spriceFunction1(input1) {
		var c_price = document.getElementById('price_c').innerHTML;
		var input2 = document.getElementById('sinput2');
		input2.value = input1.value*c_price;
	}

	function spriceFunction2(input2) {
		var c_price = document.getElementById('price_c').innerHTML;
		var input1 = document.getElementById('sinput1');
		input1.value = input2.value/c_price;
	}
</script>

	<script type="text/javascript">

                //Get P/L
                 function GetPL(){
    				$.ajax("<?php echo e(url('/dashboard/getpl').'/'.Auth::user()->id); ?>",{
    						type: 'GET', 
    						success: function(response){ 
    							var pl = document.getElementById('p_l');
    							
    							if(response <0){
								    $("#p_l").css("color",'red')
								}	
								if(response >0){
								    $("#p_l").css("color",'green')
								}
                                
                                pl.innerHTML="<?php echo e($settings->currency); ?>"+response;
    						}
    				});
    			}
    			
    			function GetOPL(){
    				$.ajax("<?php echo e(url('/dashboard/getopl').'/'.Auth::user()->id); ?>",{
    						type: 'GET', 
    						success: function(response){ 
    							var pl = document.getElementById('p_l');
    							
    							if(response <0){
								    $("#p_l").css("color",'red')
								}	
								if(response >0){
								    $("#p_l").css("color",'green')
								}
                                //alert(response);
                                
                                pl.innerHTML="<?php echo e($settings->currency); ?>"+response;
                                
    						}
    				});
    			}
    			
    			window.setInterval(function(){
                  //GetPL();
                  GetOPL()
                }, 2000);

				//submit buy/sell form
				$('#buysellorder').on('submit',function(){
        $.ajax({
            url: "<?php echo e(url('/trade/exchange')); ?>",
            type: 'POST',
            data:$('#buysellorder').serialize(),
            success: function (response) {
                if(response.status ===200){
                    swal({
                    icon: "success",
                    text: response.message,
                    timer:3000,
                    });
                    //location.reload(true);
                    }
                    else{
                    swal({
                    icon: "error",
                    text: response.message,
                    timer:3000,
                    });
                    //location.reload(true);
                }
            console.log(response)
            },
            error: function (data) {
                swal({
                icon: "error",
                text: "Something went wrong", 
                timer:3000,
                });
            },

        });
    });

            </script>
		<!-- /Trading JS -->



		<script src="<?php echo e(asset('js/classie.js')); ?>"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>


 <!-- Bootstrap Core JavaScript -->
 <script src="<?php echo e(asset('js/bootstrap.js')); ?>"> </script>

<script src="<?php echo e(asset('js/modernizr.custom.js')); ?>"></script>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
   
</body>
</html>