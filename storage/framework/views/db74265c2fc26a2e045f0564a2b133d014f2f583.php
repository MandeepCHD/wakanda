<?php $trade = app('App\Http\Controllers\BuySellController'); ?>
<div class="row" style="margin:0px 0px 0px 58px;">


<div class="col-lg-12 col-md-12 col-sm-12">
                        
                        <div class="tradingview-widget-container" style="margin:5px 0px 10px 0px;">
  <div id="tradingview_f933e"></div>
  <div class="tradingview-widget-copyright"><a href="#" rel="noopener" target="_blank"><span class="blue-text"></span> <span class="blue-text"></span></a></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">

//change chart asset
function getMarketAsset(asset){
  var cont = asset.textContent;
  var m = asset.id;
  updatemarketform(cont);
  Market(m+cont);
}

//get market price
function getMarketPrice(masset){
  $.ajax({
    url: "<?php echo e(url('/dashboard/getMarketPrice')); ?>/"+masset,
    type: 'GET',
    data:$("#getMarketPrice").serialize(),
    success: function (response) {
        if(response.status ===2000){
            swal({
        icon: "success",
        text: response.message,
        timer:6000,
        });
        }
        if(response.status ===201){
            swal({
        icon: "error",
        text: response.message,
        timer:6000,
        });
        }
       $("#price_c").html(response.data);    
    },
    error: function (data) {
        swal({
        icon: "error",
        text: "Something went wrong", 
        timer:6000,
        });
    },
});
}

//pass the market price to buy/sell form
function updatemarketform(masset){
  //get market price and send data to buy/sell forms
  getMarketPrice(masset);
  document.getElementById("market").value = masset;
}

//get chart market
function getTradeAssets(market){
  $.ajax({
    url: "<?php echo e(url('/dashboard/getTradeAssets')); ?>/"+market,
    type: 'GET',
    data:$("#tradingassets").serialize(),
    success: function (response) {
        if(response.status ===2000){
            swal({
        icon: "success",
        text: response.message,
        timer:6000,
        });
        }
        if(response.status ===201){
            swal({
        icon: "error",
        text: response.message,
        timer:6000,
        });
        }
       $("#tradeassets").html(response.data);    
    },
    error: function (data) {
        swal({
        icon: "error",
        text: "Something went wrong", 
        timer:6000,
        });
    },
});

}

//change chart market
function Market(market) {
    
        	new TradingView.widget(
              {
              "width": "100%",
              "height": "650",
              "symbol": market,
              "interval": "1",
              "timezone": "Etc/UTC",
              "theme": "dark",
              "style": "9",
              "locale": "en",
              "toolbar_bg": "#f1f3f6",
              "enable_publishing": false,
              "withdateranges": true,
              "range": "all",
              "hide_side_toolbar": false,
              "allow_symbol_change": true,
              "details": true,
              "hotlist": true,
              "calendar": true,
              "news": [
              "stocktwits",
              "headlines"
            ],
            "studies": [
              //"BB@tv-basicstudies",
              //"MACD@tv-basicstudies",
              //"MF@tv-basicstudies"
            ],
              "container_id": "tradingview_f933e"
            }
              );
    
		$(".chartmarket").click(function() {
		
      var cont = $(this).html();
      // Add active class to the current button (highlight it)
      $(".chartmarket").removeClass("actives");
      $(this).addClass("actives");   

			if (cont == "Forex") {
          Market("FX:EURUSD");
          getTradeAssets('Forex');
			} else if (cont == "Stock") {
        Market("NASDAQ:AAPL");
        getTradeAssets('Stock');
			} else if (cont == "CFD") {
        Market("TVC:USOIL");
        getTradeAssets('CFD');
			}else if(cont == "Indices"){
        Market("CURRENCYCOM:US30");
        getTradeAssets('Indices');
			}else if(cont == "Cryptocurrency"){
        Market("COINBASE:BTCUSD");
        getTradeAssets('Cryptocurrency');
			}
    });

  };
  
  //load chart
  Market("COINBASE:BTCUSD");
  //load assets
  getTradeAssets("Cryptocurrency");
  getMarketPrice('BTCUSD');
  

  </script>
</div>


      <script type="text/javascript">
      
      </script>   
                    </div>
    
                    
               
        
                </div>
