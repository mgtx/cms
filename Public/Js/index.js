$(function(){		
    //获取当前屏幕高度
    var oWidth = $('.row1').width();
    var oHeight = $(window).height();
    $('.box').css({'height':oHeight+1+'px'});
    $('.star').css({'height':oHeight+1+'px'});
    $('.carousel_content').css({'height':(oHeight*0.85)+'px'});
    $('.carousel_content_left').css({'height':(oHeight*0.75)+3+'px'});
    $('.content_right_l_ul').css({'height':(oHeight*0.75)+'px'});
    $('.carousel_content_right').css({'height':(oHeight*0.75)+3+'px'});
    $('.content_bottom').css({'height':oHeight*0.2+'px'});
    $('.content_bottom li').css({'lineHeight':oHeight*0.1+'px'});
    var oLenght_li = $('.content_bottom li').length;  
    var iNow3=0;
	    function show3(){
			if(iNow3<oLenght_li){
	    	    $('.content_bottom li').eq(iNow3).addClass('show').siblings().removeClass('show');
	    	    iNow3++;
	       }
			if(iNow3 == oLenght_li){
				iNow3=0;
			}
	    }
	   setInterval(show3,8000);
	   
	var table_div_height =  $('.table_div').height();
	var table_header_height = $('.table_header').height();  //头部
	var oHeight2 = oHeight*0.75-table_header_height;
	var tb_nub1 = $('.table_height').length ;
    var iNow2 = 0;
	function move2(a,b,c){
		var timer =	setInterval(show2,b);
		function show2(){
			a++;
			if(a < Math.round(table_div_height)){ //到最下面时
				$('.table_div').css({'marginTop':-a+'px'});
			}else{
				a = -Math.round(oHeight2);
			}
			if(a == 0){
				$('.table_header p strong').html('个人');
				clearInterval(timer);
				setTimeout(function(){
					timer =	setInterval(show2,b);
				},c)
			}
			if(a == Math.round($('.table_height').eq(0).height())){
				$('.table_header p strong').html('团队');
				clearInterval(timer);
				setTimeout(function(){
					timer =	setInterval(show2,b);
				},c)
			}
		}
		return show2();
	}
	
	setTimeout(function(){
		move2(iNow2,30,8000);  //b： 行走速度   c：停留时间
	},8000)
		var oLenght = $('.content_right_l .content_right_l_ul').length;
		var iNow = 0;
		function move(a,b,c){
			setInterval(function(){
				setTimeout(function(){
					iNow++;
				},4000);
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
		var content_left_ul_height = $('.content_right_l_ul').height()+2;
	    move($('.content_right_l'),content_left_ul_height,4000);  //恭喜  轮播 
})