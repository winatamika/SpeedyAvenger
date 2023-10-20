<?php
/* Template Name:  Pages Template Login */
?>
<?php get_header(); ?>
<div id="content"> <div class="clear1"></div>
    <div class="entry">	 
<div style="width:360px; margin:30px auto 0; text-align:left">
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
                    
                    wp_login_form($args);
                    ?> 

                </div>
</div>
            <?php endwhile;
        endif;
        ?>
        <div class="clear"></div>
<?php //edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    </div>

    <div class="clear"></div>
</div>
<?php get_footer(); ?>