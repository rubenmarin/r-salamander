<?php

/* INLINE JS */
add_filter('removefromurl/protocol' , function($url = ''){
	$url = preg_replace('(^https?://)', '', $url ); // removes protocol
	return $url;	
},10,1);
add_filter('removefromurl/query' , function($url = ''){
	$url = preg_replace('/\?.*/', '', $url); //removes query
	return $url;	
},10,1);
add_filter('removefromurl/www' , function($url = ''){
	$url = preg_replace('/www./i' , '' , $url ); // removes 'www.' from url
	return $url;	
},10,1);
add_filter('removefromurl/protocol-www' , function($url = ''){
	$url = preg_replace('(^https?://)', '', $url ); // removes protocol
	$url = preg_replace('/www./i' , '' , $url ); // removes www
	return $url;	
},10,1);
add_filter('removefromurl/protocol-www-query' , function($url = ''){
	$url = preg_replace('(^https?://)', '', $url ); // removes protocol
	$url = preg_replace('/www./i' , '' , $url ); // removes wwww
	$url = preg_replace('/\?.*/', '', $url); //removes query
	return $url;	
},10,1);