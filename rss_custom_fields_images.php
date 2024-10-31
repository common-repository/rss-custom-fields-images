<?php
/*
Plugin Name: RSS Custom Field Images
Version: 0.2
Plugin URI: http://mbecher.com/archive/2009/07/16/rss-custom-fields-image-plugin/
Description: Puts large sized image attached to posts in front of rss feeds. Useful for images in custom fields.
Author: Marc Becher
Author URI: http://mbecher.com/
*/

/*
 * USAGE:
 *
 * Just have your images attached in custom fields.
 *
 */

// get all of the images attached to the current post
function get_images($size = 'thumbnail') {
	global $post;

	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

	return $photos;
}

function check_image($content) {
  if(is_feed()) {
      $images = get_images();
      if ( empty($images) ) {
          // no attachments here
      } else {
          foreach($images as $x) {
            $y = $x->ID;
          }
          $image=wp_get_attachment_image($y, "large", false);
      }
      $content = $image . $content;	
  } else {
      $content = $content;	
  }
  return $content;
}

add_filter('the_content', 'check_image');

?>
