<?php get_header(); ?>
<div id="content"> 
<div class="slider1">
<?php if (function_exists('vslider')) { vslider('Slider_Promo'); }?>
</div>
<div class="clear"></div>

	<?php get_sidebar(); ?>

    <div class="grid_13content">
    <div class="entry">
    <?php if (have_posts()) : ?>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_category()) { ?>
    <h2 class="title"><?php single_cat_title(); ?></h2>
    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h2 class="title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2 class="title">Archive for <?php the_time('Y'); ?></h2>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2>Author Archive</h2>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="title">Blog Archives</h2>
    <?php } ?>
    
    <?php while (have_posts()) : the_post(); ?>
    
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <div class="list">
    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(180,1000), array("class" => "alignleft post_thumbnail")); } ?>
    <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
    <?php the_excerpt(); ?>
    
    <div class="readmorecontent">
    <a class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">Read More</a>
    </div>
    <div class="clear"></div>
    </div>
    </div>
    <?php endwhile; ?>
    <div class="navigation">
    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
    <div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
    <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
    <?php } ?>
    </div>
    <?php else :
    if ( is_category() ) { // If this is a category archive
    printf("<h2 class='pagetitle'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
    } else if ( is_date() ) { // If this is a date archive
    echo("<h2 class='pagetitle'>Sorry, but there aren't any posts with this date.</h2>");
    } else if ( is_author() ) { // If this is a category archive
    $userdata = get_userdatabylogin(get_query_var('author_name'));
    printf("<h2 class='pagetitle'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
    } else {
    echo("<h2 class='pagetitle'>No posts found.</h2>");
    }
    get_search_form(); endif;?>
    </div>
    </div>
    
    <div class="clear"></div>
</div>
<?php get_footer(); ?>