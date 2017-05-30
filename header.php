<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
 	<meta name="viewport" content=" maximum-scale=1.0, user-scalable=0, width=device-width">
 	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<script> /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)?(document.getElementsByTagName("html")[0].className+=" is--device",/iPad/i.test(navigator.userAgent)&&(document.getElementsByTagName("html")[0].className+=" is--ipad")):document.getElementsByTagName("html")[0].className+=" not--device";</script>

	<?php 
		//this gets cached every 6 hrs (60*60*6)
		miniCSS::url( 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i'); 
	?>
	
	<?php wp_head(); ?>

	<?=(get_mythemeoption('content_types/after_wp_head'));?>

</head>
<body <?php body_class(); ?>>

<div class="the-page">


