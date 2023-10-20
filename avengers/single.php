<?php
/* Template Name:  Pages Template Full */ 
?>
<?php get_header(); ?>
<div id="content"> 
    <div class="clear1"></div>
    <div class="entry">	 
       <?php if (have_posts()) : ?>	
       <?php while (have_posts()) : the_post(); ?>
       <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <h2 class="title"><?php the_title(); ?></h2>
        <?php the_content('Read the rest of this entry &raquo;'); ?>
        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    <?php endwhile; endif; ?>

</div>
</div>

<div class="clear"></div>
</div>
<?php get_footer(); ?>