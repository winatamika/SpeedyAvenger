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
        <?php
        if ( is_super_admin() AND is_front_page() ) {
            ?>
            <p>Welcome, administrator</p>
            <p>
                <a href="<?php echo SITE_URL;?>/wp-admin/admin.php?page=wpsqt-menu&section=questions&subsection=quiz&id=7">Soal-soal</a>
            </p>
            <p>
                <a href="<?php echo SITE_URL;?>/wp-admin/admin.php?page=wpsqt-menu&section=results&subsection=quiz&id=7">Hasil</a>
            </p>
            
            <!--
            <p>
                Berita
            </p>
            <p>
                Info Produk &amp; Harga
            </p>
            <p>
                Materi Komunikasi
            </p>
            <p>
                Program Promo
            </p>
            <p>
                Pertanyaan
            </p>
            -->

            <?php
        }else{
            ?>
            <h2 class="title"><?php the_title(); ?></h2>
            <?php the_content('Read the rest of this entry &raquo;'); ?>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            <!--div class="postmeta"> Posted in <?php the_category(', ') ?> <?php if(get_the_tags()) { ?>  <?php  the_tags('Tags: ', ', '); } ?></div-->
            <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
                    // Both Comments and Pings are open ?>
                    <div class="clear"></div>
                    <?php } edit_post_link('Edit this entry','','.'); ?>
                    <?php comments_template(); ?>
                    <?php
                }
                ?>
            <?php endwhile; endif; ?>

        </div>
    </div>

    <div class="clear"></div>
</div>
<?php get_footer(); ?>