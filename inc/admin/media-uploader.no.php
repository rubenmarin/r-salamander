<?php
add_filter( 'attachment_fields_to_edit',  'model_tag_field', 10, 2 );
function model_tag_field( $fields, $post ) {
	ob_start();
		?>
			<style>
				.clearfix:before, .clearfix:after {
				content: "";
				display: table;
				}

				.clearfix:after {
				clear: both;
				}

				.clearfix {
				*zoom: 1;
				}
				.custom-media-settings{
					padding:5px;
				}
				.custom-media-settings *{
					box-sizing: border-box;
				}
			</style>
			<div class="custom-media-settings">
				<fieldset>
					<legend>Wraps img in a <em>p</em> tag<br>With a Class of <em>p-imgwrap</em></legend>
					<label class="setting" style="padding:4px;background:#efefef;border:1px solid #cccccc;">
					<span class="name" style="text-align:left;"><b>P</b> Wrap</span>
					<select id="p_wrapper" class="p_wrapper" name="p_wrapper">
					<option value="0">False</option>
					<option value="1">True</option>
					</select>
				</fieldset>
				
				<fieldset style="margin-top:10px;">
				<legend>Wraps img in a <em>span</em> tag <br>With custom class</legend>				
				<div class="clearfix" style="padding:4px;background:#efefef;border:1px solid #cccccc;">
					<label class="setting" style="padding-bottom: 4px;border-bottom:1px solid #cccccc;">
						<span class="name" style="text-align:left;">Tag</span><select id="model_tag" class="model_tag" name="model_tag">
						<option value="0">False</option>
						<option value="1">True</option>
					</select>
					</label>
					<label class="setting" style="padding-top: 4px">
						<span class="name" style="text-align:left;">Class</span><input class="model_tag_class" type="text" name="model_tag_class" value="model_tag">
					</label>
					<div class="clearfix"></div>
					<center style="margin-top:4px;display:block;"><span class="name" style="text-align:left;"><b>Default is 'model_tag'</b></span></center>
				</div>
				</fieldset>	
				
			</div>

			
		<?
	$_html = ob_get_contents();
	ob_end_clean();
	$fields['model_tag'] = array(
		'label' => '<h3>Img Wrapping</h3>',
		'input' => 'html',
		'html'	=> $_html,
		'show_in_edit' => true,
	);
	return $fields;
}