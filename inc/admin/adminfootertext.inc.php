<?php 

/**
 * Customize the admin footer text
 *
 */
function custom_admin_footer() {
	echo 'Website Design by <a href="http://www.rosemontmedia.com/" target="_blank">Rosemont Media</a>';
} 
add_filter('admin_footer_text', 'custom_admin_footer');