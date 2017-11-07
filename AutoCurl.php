<?php
@ini_set('date.timezone','Asia/Shanghai');

$ch = curl_init ();
$url = "http://tongji.mgtx.cn/index.php/home/Index/Syn_business";
curl_setopt ($ch, CURLOPT_HEADER, 0);
//curl_setopt ($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);   // get the response as a string from curl_exec(), rather than echoing it
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);       // don't use a cached version of the url
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_exec ($ch);
curl_close ($ch);


