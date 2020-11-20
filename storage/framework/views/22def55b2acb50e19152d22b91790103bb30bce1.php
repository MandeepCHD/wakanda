	<!--footer-->
		<div class="footer">
		   <p>All Rights Reserved &copy; <?php echo e($settings->site_name); ?> <?php echo e(date('Y')); ?></p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
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