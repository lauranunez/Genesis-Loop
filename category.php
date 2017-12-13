/**
 * Template Name: Category Page
 *
 * @package WordPress
 * @subpackage Metro Pro
 * @since Metro Pro
 */

function tdw_custom_loop() {
  global $post;
  // WP_Query arguments.
    $category = get_the_category($post->ID);
    $category = $category[0]->cat_ID;
    $args = array(
        'post_type' => array( 'post' ),
        'category__in' => array($category),
        'posts_per_page' => 20,
        'order' => 'DESC',
        'paged'          => get_query_var( 'paged' )
    );

  /* 
  Overwrite $wp_query with our new query.
  The only reason we're doing this is so the pagination functions work,
  since they use $wp_query. If pagination wasn't an issue, 
  use: https://gist.github.com/3218106
  */
  global $wp_query;
  $wp_query = new WP_Query( $args );
  if ( have_posts() ) : 
    echo '<div class="portfolio-posts"><h1 class="archive-title">' . post_type_archive_title( '', false ) . '</h1>';
    while ( have_posts() ) : the_post(); 
     printf('<p class="entry-title"><span class="entry-date">'. get_the_time('d/m'). ' - </span><a href="%s">%s</a></p>', esc_url( get_permalink() ), get_the_title() );
    endwhile;
    echo '</div>';
    genesis_posts_nav();
  endif;
  wp_reset_query();
}
add_action( 'genesis_loop', 'tdw_custom_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
genesis();
