<?php
/* Template Name:  Pages Template Login */
?>
<?php get_header(); ?>
<div id="content"><div class="loginbg"> 
<?php include(TEMPLATEPATH."/scroll.php");?>
<div class="clear1"></div>

<div class="grid_13login" >
.
</div>


<div class="grid_13sidebarlogin">	
<div class="sidebarlogin">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="post" id="post-<?php the_ID(); ?>">
                    <h2 class="title"><?php the_title(); ?></h2>
                    <!--
                    <label for="username">Username</label>
                    <input name="username" id="username" type="text" value="">
                    <label for="password">Password</label>
                    <input name="password" id="password" type="password" value="">
                    <input name="blogin" id="blogin" type="submit" value="Login">
                    -->
                    
                    <?php
                    if($_GET['fail']==true){
                        echo "<p class='warning'>Akun login salah! silahkan coba kembali.</p>";
                    }
                    ?>
                    <?php
                    $args = array(
                        'echo' => true,
                        'redirect' => SITE_URL,
                        'form_id' => 'loginform',
                        'label_username' => __('Username'),
                        'label_password' => __('Password'),
                        'label_remember' => __('Remember Me'),
                        'label_log_in' => __('Log In'),
                        'id_username' => 'user_login',
                        'id_password' => 'user_pass',
                        'id_remember' => 'rememberme',
                        'id_submit' => 'wp-submit',
                        'remember' => false,
                        'value_username' => NULL,
                        'value_remember' => false);
                    
                    wp_login_form($args);  ?> 


                </div>
            <?php endwhile; endif; ?>

</div>
<div class="clear"></div>

<div class="sdw"></div>
<a  href="http://www.speedyavengers.com/register/"><div class="button-primary2">Buat Account Baru</div></a>
<a  href="http://www.speedyavengers.com/lupa-kata-sandi/">Lupa Kata Sandi</a>
</div>

    <div class="clear"></div>
</div></div>
<?php get_footer(); ?>