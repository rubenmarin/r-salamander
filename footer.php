
</div><!--#the-footer-->

<?php wp_footer(); ?>
</body>
</html>
<?php
	//BrowserSync
	$bsPort 					= 8080;
	$browserSync 			= 'http://127.0.0.1:'.$bsPort;
	$browserSyncHdrs 		= @get_headers($browserSync);
	if($browserSyncHdrs):
		?>
		<script async src="<?php echo $browserSync;?>/browser-sync/browser-sync-client.js?v=2.18.8"></script>
		<?
	endif;

?>