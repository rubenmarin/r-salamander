<?php 

class RM_pageRelatedPosts{
	public function __construct(){
		add_action( 'add_meta_boxes', array(&$this , 'rp_mbx') ); 
		add_action('op__related_posts' , array(&$this , 'show_related_posts') ,10 , 2);
		add_action( 'save_post', array(&$this , 'rp_mbx_save') ); 
	}

	public function show_related_posts($args = null){
		$placeholder_img =  get_template_directory_uri().'/includes/prp/placeholder-img.jpg';
		include dirname(__FILE__) . '/view.php';
	}
	public function rp_mbx($post){
		add_meta_box( 'my-meta-box-id', 'Related Post Categories', array( &$this , 'rp_mbx_view' ), 'page', 'side', 'low' );  
	}

	public function rp_mbx_view($post){
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'category',
			'pad_counts'               => false 
		); 

		// LOOP THRU Felines
		
		// GET STUFF AND DO STUFF DB
		global $post;  
		$newPID = $post->ID;
		$values = get_post_custom( $post->ID );
		$selected = isset( $values['relatedMetaBox'] ) ? esc_attr( $values['relatedMetaBox'][0] ) : '';

		$faubrau = explode(',', $selected)?:array(); //I TOTTALLY STARTED TYPING CRAP TO GET THE $FAUBRAU

		$categories = get_categories($args);
		echo '<div style="overflow-y:scroll;">';
		foreach ($categories as $category) {
			$checked = (in_array( $category->cat_ID , $faubrau )) ? ' checked="checked" ' : '';
			echo '<p style="padding:5px;text-indent:10px;" >
				<input '.$checked.' type="checkbox" id="relatedMetaBox" name="relatedMetaBox[]" value="'. $category->cat_ID .'">&nbsp;&nbsp;'. $category->name . ' <small>(ID:'.$category->cat_ID. ')</small>
			</p>';
		}
		echo '</div>';
	}
	public function rp_mbx_save( $newPID ){  
		$newR = (isset($_POST['relatedMetaBox'])) ? $_POST['relatedMetaBox'] : array();
		if(empty($newR)):
			delete_post_meta( $newPID, 'relatedMetaBox' );  	
			return;
		endif;

		for($i=0; $i < count($newR) ; $i++):
			$commaList = implode(', ', $newR);
			update_post_meta( $newPID, 'relatedMetaBox', $commaList );
		endfor;
	}


}
$RM_pageRelatedPosts = new RM_pageRelatedPosts();