<?php if (is_page(array(10))): ?>
<div class="text-scroll">
<MARQUEE SCROLLDELAY=200>
<?php //echo get_theme_option('ad_sidebar_bottom'); 
$saOptions = sa_getOptions();
echo $saOptions["pengumuman"];
?>
</MARQUEE>
</div>
<?php else  : ?>
<?php endif; ?>
