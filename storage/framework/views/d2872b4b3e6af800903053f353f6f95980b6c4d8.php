<div class="row" style="margin:0px 0px 0px 58px;">


<div class="col-lg-12 col-md-12 col-sm-12">
                        
                        <div class="tradingview-widget-container" style="margin:30px 0px 10px 0px;">
  <div id="tradingview_f933e"></div>
  <div class="tradingview-widget-copyright"><a href="#" rel="noopener" target="_blank"><span class="blue-text"></span> <span class="blue-text">Personal trading chart</span></a></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">

function Market(market) {
    
        	new TradingView.widget(
              {
              "width": "100%",
              "height": "550",
              "symbol": market,
              "interval": "1",
              "timezone": "Etc/UTC",
              "theme": "dark",
              "style": "9",
              "locale": "en",
              "toolbar_bg": "#f1f3f6",
              "enable_publishing": false,
              "hide_side_toolbar": false,
              "allow_symbol_change": true,
              "calendar": false,
              "studies": [
                "BB@tv-basicstudies"
              ],
              "container_id": "tradingview_f933e"
            }
              );
    
    
		$(".chartmarket").click(function() {
		
			var cont = $(this).html();

			if (cont == "Forex") {
			    Market("FX:EURUSD");
			} else if (cont == "Stock") {
				Market("NASDAQ:AAPL");
			} else if (cont == "CFD") {
				Market("TVC:USOIL");
			}else if(cont == "Indices"){
			    Market("CURRENCYCOM:US30");
			}else if(cont == "Cryptocurrency"){
                Market("COINBASE:BTCUSD");
			}
		});
	};
	
	Market("COINBASE:BTCUSD");

  </script>
</div>


      <script type="text/javascript">
      
      </script>   
                    </div>
    
  
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="white-box" style="height: 450px;">
                            <h4 style="margin-bottom:5px;"> Forex Market Fundamental Data</h4>
<!-- TradingView Widget BEGIN -->

<span id="tradingview-copyright"><a ref="nofollow noopener" target="_blank" href="http://www.tradingview.com" style="color: rgb(173, 174, 176); font-family: &quot;Trebuchet MS&quot;, Tahoma, Arial, sans-serif; font-size: 13px;"></a></span>
<script src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js">{
  "currencies": [
    "EUR",
    "USD",
    "JPY",
    "BTC",
    "ETH",
    "LTC",
    "GBP",
    "CHF",
    "AUD",
    "CAD",
    "NZD",
    "CNY"
  ],
  "width": "100%",
  "height": "100%",
  "locale": "en"
}</script>

                        </div>

<!-- TradingView Widget END -->
                </div>
                    
               
        
                </div>