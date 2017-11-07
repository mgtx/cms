
 	$(function(){
		var oWidth = $(window).height();  //屏幕宽度
		var oLenght = $('.content_right_l_m .content_right_l_ul_m').length;
		var oHeight1 = $('.carousel_content1_m').height();
		var iNow = 0;
		function move(a,b,c){
			var timer1 = setInterval(show1,c);
			    function show1(){
			    	iNow++;
			    	if(iNow < oLenght){
						a.animate({'marginTop':-b*iNow+'px'},1000);
					}
					if(iNow == oLenght){
						a.animate({'marginTop':0+'px'},1000);
					    iNow=0;
					}
			    }
			return show1();
		}
	     //恭喜  轮播 
	     setTimeout(function(){
	     	 move($('.content_right_l_m'),oHeight1,6000);
	     },5000)
	    
//	    var oLength2 = $('.table_div_m li').length;
//	    function move2(){
//	    	setInterval(show2,10000);
//	    	 var iNow2 = -1;
//	    	function show2(){
//	    		iNow2++;
//	    		if(iNow2<oLength2){
//	    			$('.table_header_m p strong').html('个人');
//	    			$('.table_div_m li').eq(iNow2).addClass('show').siblings().removeClass('show');
//	    		}
//	    		if(iNow2 == oLength2-1){
//	    			$('.table_header_m p strong').html('团队');
//	    			iNow2 =-1;
//	    		}
//	    	}
//	    	return show2();
//	    }
//	    move2();  //集体
//	    
//	    $('.table_div_m li').eq(0).addClass('show');	
//	    var oLenght_li = $('.content_bottom_m li').length;  
//	    var iNow3=0;
//		    function show3(){
//				if(iNow3<oLenght_li){
//		    	    $('.content_bottom_m li').eq(iNow3).addClass('show').siblings().removeClass('show');
//		    	    iNow3++;
//		       }
//				if(iNow3 == oLenght_li){
//					iNow3=0;
//				}
//		    }
//		   setInterval(show3,8000);  //底部
	}) 