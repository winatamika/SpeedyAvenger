<?php get_header(); ?>
<div id="content">
	<div class="grid_13index">
  <img src="<?php bloginfo('stylesheet_directory'); ?>/images/index.jpg" width="400" height="368" />
  </div>
  <div class="grid_13indexcontent">
  <div class="entry"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Welcome") ) : endif; ?></div>
  
    <!--div class="entry">	 
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="post" id="post-<?php the_ID(); ?>">
            <h2 class="title"><?php the_title(); ?></h2>
            <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(300,225), array("class" => "alignleft post_thumbnail")); } ?>
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
        </div>
        <?php endwhile; endif; ?>
        <div class="clear"></div>
        <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    </div-->
  </div>
  <div class="clear"></div>
</div>

<?php get_footer(); ?>