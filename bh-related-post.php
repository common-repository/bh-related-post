<?php
/**
 * @package BH Related Post
 * @version 1.0
 */
/*
Plugin Name: BH Related Post
Plugin URI: http://wordpress.org/plugins/bh-related-post
Description: This plugin for Related post. This plugin will display your related post with jcarousel slider. It's build with jquery ui jcarsoul plugin.
Author: Masum Billah
Version: 1.0
Author URI: http://getmasum.com
*/



function bh_related_post_scripts_method() {
// including css file
 wp_enqueue_style('bh_related_post_jcarousel_css', plugins_url('/lib/jcarousel.responsive.css', __FILE__) );
 
// including js file
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'bh_related_post_jcarousel', plugins_url( '/lib/jquery.jcarousel.min.js', __FILE__ ), array( 'jquery' ) );
wp_enqueue_script( 'bh_related_post_jcarousel_responsive', plugins_url( '/lib/jcarousel.responsive.js', __FILE__ ), array( 'jquery' ));

}

add_action( 'wp_enqueue_scripts', 'bh_related_post_scripts_method' );

function bh_related_post (){
	?>
	<?php
	$backup = $post; // backup current object
	$current = $post->ID; // current page ID

	global $post;
	$thisCat = get_the_category(); // gets the current categori(es)
	$currentCategory = $thisCat[0]->cat_ID; // gets the primary category
	$stepper = 1; // default value for the counter
	$myposts = get_posts('numberposts=-1&order=DESC&orderby=ID&category=' . $currentCategory . '&exclude=' . $current); // gets the two most recent posts from the current category excluding the current post
	
	$check = count($myposts); // Checks how many posts were returned by the query above
	if ($check > 1 ) { // if there are two or more posts then...
	?> 
	 <h3>Related Posts</h3>	
	  <div class="jcarousel-wrapper">	 
		<div class="jcarousel">
			
			<ul>
			<?php 
				foreach($myposts as $post) : setup_postdata($post); // The Loop
			?>
				<li><a href="<?php the_permalink();?>"><span><?php the_title();?></span></a><a href="<?php the_permalink();?>"><?php the_post_thumbnail('small'); ?></a></li>
				<?php
				$stepper = ($stepper+1); // stepper + 1
				endforeach; 
			?> 
			<?php
				$post = $backup; //restore current object
				wp_reset_query();
			?>
			</ul>
		</div>

		<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
		<a href="#" class="jcarousel-control-next">&rsaquo;</a>
	</div>
	<?php } 
}