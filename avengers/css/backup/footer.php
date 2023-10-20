<!--Footer-->
	 <div id="footer">
    <div class="footerbanner">
     <div class="grid_13suport"> Supported by 
     </div>
      <div class="grid_13banner">
 <a href="http://www.useetv.com/" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/utv50.png" width="166" height="93" /></a>
      </div>
      <div class="grid_13banner">
<a href="http://telkomspeedy.com/" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/speedy50.png" width="166" height="93" /></a>
      </div>
      <div class="grid_13banner">
         <a href="http://www.indonesiawifi.com/" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/indihome.png" width="166" height="93" /></a>
      </div>
      <div class="grid_13banner">
 <a href="http://www.telkom.co.id/" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/telkom.png" width="166" height="93" border="0" /></a>
      </div>
    
    
    </div>
        <div class="footercopy">
        <div class="alamat"><?php echo get_theme_option('ad_sidebar_bottom'); ?></div>
        Copyright &copy; 2013 <a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?></a>, <?php bloginfo('description'); ?>
        </div>
    </div>
</div>

</body>
<?php
	 wp_footer();
	echo get_theme_option("footer")  . "\n";
?>
</html>
			