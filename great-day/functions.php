<?php
function my_theme_enqueue_styles() {

    $parent_style = 'hitchcock-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'great-day-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
    //load_child_theme_textdomain( 'great-day', get_stylesheet_directory() . '/languages' );
    // Add nav menu
	//register_nav_menu( 'footer', __('Footer Menu','gret-day') );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_filter('qw_fields', 'custom_qw_field');
 
function custom_qw_field($fields)
{
  $fields['custom_qw_field'] = array(
    'title' => 'Custom QW Field',
    'description' => 'Just an example of making your own custom fields with callbacks.',
    'output_callback' => 'get_custom_qw_field',
    'output_arguments' => true, // this provides the $post and $field parameters to the output_callback
  );
  return $fields;
}
 
/*
 * This is just a random custom function that returns some html.
 *
 * @param object $this_post - the WP post object
 * @param array $field - the QW field.  Useful if a field has custom settings (not shown in this example).
 * @param array $tokens - Available output values from other fields
 */
function get_custom_qw_field($this_post, $field, $tokens){
  // since this field is executed with "the loop", you can use most WP "template tags" as normal
  // you can do anything you need here, as long as you return (not echo) the HTML you want to display.
  
  $author = get_the_author();
  // this would provide the same results
  // $author = get_the_author_meta('display_name', $this_post->post_author);
  
  return "This post is authored by: ".$author;
}
/*
*
* Add a type of featured image URL to Query Wrangler plugi here, BUT IT WILL GET OVERWRITTEN by plugin updates
*
*/
add_filter( 'qw_fields', 'qw_field_featured_image_url' );
/*
 * Add field to qw_fields
 */
function qw_field_featured_image_url( $fields ) {

	$fields['featured_image_url'] = array(
		'title'            => 'Featured Image URL',
		'description'      => 'The Featured Image URL field, as defined in themes/great-day/functions.php',
		'output_callback'  => 'qw_theme_featured_image_url',
		'output_arguments' => TRUE,
		'form_callback'    => 'qw_field_featured_image_url_form',
	);

	return $fields;
}
/*
 * Image attachment URL settings Form
 */
function qw_field_featured_image_url_form( $field ) {
	//$image_styles = _qw_get_image_styles();
	$image_styles = get_intermediate_image_sizes();
	?>
	<p>
		<label class="qw-label">Image Display Style:</label>
		<select class='qw-js-title'
		        name='<?php print $field['form_prefix']; ?>[image_display_style]'>
			<?php
			foreach ( $image_styles as $key => $style ) {
				$style_selected = ( $field['values']['image_display_style'] == $style ) ? 'selected="selected"' : '';
				?>
				<option
					value="<?php print $style; ?>" <?php print $style_selected; ?>><?php print $style; ?></option>
			<?php
			}
			?>
		</select>
	</p>
<?php
}

/*
 * Return the images URL
 *
 * @param $post
 * @param $field
 */
function qw_theme_featured_image_url( $post, $field ) {
	$style = $field['image_display_style'];
	if ( has_post_thumbnail( $post->ID ) ) {
		$image_id = get_post_thumbnail_id( $post->ID, $style );
		return wp_get_attachment_image_src( $image_id, $style )[0];
	}
}


?>