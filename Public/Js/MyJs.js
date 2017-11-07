/**
 * Created by mgtx on 2017/9/11.
 */

$(function(){
		var oLenght = $('.carousel_content_message').length;
		var iNow = 0;
		function move(a,b,c){
			setInterval(function(){
				setTimeout(function(){
					iNow++;
				},5000);
				if(iNow < oLenght){
					a.animate({'marginTop':-b*(iNow)+'px'},1000);
				}
				if(iNow == oLenght){
					setTimeout(function(){
					    a.animate({'marginTop':0+'px'},1000);
					},3000);
					setTimeout(function(){
						iNow=0;
					},3000)
				}
			},c);
		}
	    move($('.carousel_middle_right_content'),732,4500);
		var iNow2 = 0;
		var table2_height = $('.table2').height();
		var table_lenght = $('.team_div>div').length;
		for(var i=0;i<table_lenght;i++){
			if($('.team_div>div').eq(i).height()<730){
				$('.team_div>div').eq(i).css({'height':730+'px'});
			}else{
				var aHeight = $('.team_div>div').eq(i).height();
//				alert(aHeight)
				function move2(){
			    	setInterval(function(){
			    		if(iNow2 == 0){
			    			if($('.team_div>div').eq(i).height()<730){
			    				$('.team_div').animate({'marginTop':-720+'px'},1000);
			    			}else{
			    				$('.team_div').animate({'marginTop':-720+'px'},1200);
			    				setTimeout(function(){
			    				$('.team_div').animate({'marginTop':-740-(aHeight-730)+'px'},1000);
			    				},3000);
			    			}
				    		setTimeout(function(){
				    			iNow2=1;
				    		},10000)
				    	}
				    	if(iNow2 == 1){
				    		$('.team_div').animate({'marginTop':10+'px'},1000);
					    	setTimeout(function(){
					    		iNow2 =0;
					    	},10000);
				    	}
			    	},12000);
			    }
				move2();
			}
		}
		 
	})
	//获取当前屏幕高度
    var oHeight = window.screen.availHeight;
    var text_height = $('.box').height();
    $('body').css({'height':oHeight});
    $('.box').css({'marginTop':(oHeight-text_height)/4+'px'});