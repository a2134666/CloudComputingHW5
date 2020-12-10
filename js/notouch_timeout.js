var doRefresh = '畫面自動更新活動15秒';
		var doNotRefresh = '偵測 Keyboard 活動,重新計時!!'
		var doNotRefreshI = '偵測 Mouse,活動,重新計時!!'
		var doNotRefreshII = '偵測 Window scroll,重新計時!!'
  
		var idelTimer=setTimeout(function(){window.location.replace('1_index_index.html');},15000);  //第一次進入畫面後，如果超過十秒鐘沒任何動作(滑鼠、鍵盤)，網頁會進行重整
		var timer;  

		$(document).ready(function() {
			$("#msg").html(doRefresh);
		});  
  
		// 偵測 Keyboard
		document.onkeydown = function(e) {
			$("#msg").html(doNotRefresh);	  
			timerReset();		  
		}
    
		//偵測 Mouse
		$(document).click(function(event) { 
			$("#msg").html(doNotRefreshI);	
			timerReset();		  
		});
  
		//偵測 Window scroll
		function scrollFunc() {
			$("#msg").html(doNotRefreshII);
			timerReset();	  
		}
  
		//偵測到滑鼠及鍵盤動作，計時器重新Reset
		function timerReset() {
			clearTimeout(timer);
			clearTimeout(idelTimer); 	  
			timer=setTimeout(function(){location.reload();},15000);    
		}  
  
		function doPageRefesh() {
			location.reload();
		}
  
		window.onscroll = scrollFunc;