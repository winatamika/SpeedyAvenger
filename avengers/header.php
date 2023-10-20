<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="main">
 * @package WordPress
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Favicons -->
        <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/icons.png">
            <title><?php wp_title(''); ?><?php
                if (wp_title('', false)) {
                    echo ' |';
                }
                ?> <?php bloginfo('name'); ?></title>
            <!--[if IE]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie.css" type="text/css" media="screen, projection"><![endif]-->

            <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
            <?php if (get_theme_option('featured_posts') != '' && is_home()) { ?>
            <?php } ?>

            <!--[if IE 6]>
                    <script src="<?php bloginfo('template_url'); ?>/js/pngfix.js"></script>
                    <script>
                      DD_belatedPNG.fix('#container');
                    </script>
            <![endif]--> 

            <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
            <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
            <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
            <script type="application/x-javascript">
                addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
                function hideURLbar(){
                window.scrollTo(0,1);
                }
            </script>


            <!-- CSS -->
            <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/base.css">
                <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/sbj.css">
                    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css">
                        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/fonts/stylesheet.css">	
                            <link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>

                                <!-- To Top scripts -->
                                <script src="<?php bloginfo('stylesheet_directory'); ?>/js/smoothscroll.js" type="text/javascript" ></script>
                                <script src="http://jqueryjs.googlecode.com/files/jquery-1.3.js" type="text/javascript"></script>

                                <script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.ui.totop.js" type="text/javascript"></script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                    $().UItoTop({ easingType: 'easeOutQuart' });
                                    });
                                </script>
                                <?php
                                echo get_theme_option("head") . "\n";
                                wp_head();
                                ?>

                                <link type="text/css" rel="stylesheet" href="<?php echo STYLESHEET_URI; ?>/js/simplePagination/simplePagination.css"/>
                                <script src="<?php echo STYLESHEET_URI; ?>/js/simplePagination/jquery.simplePagination.js" type="text/javascript"></script>




                                </head>
                                <body>
                                    <div class="top"></div>
                                    <div class="row">
                                        <div id="header">
                                            <div class="grid_13 logobox"> 
                                                <div class="logox">
                                                    <?php
                                                    $get_logo_image = get_theme_option('logo');
                                                    if ($get_logo_image != '') {
                                                        ?>
                                                        <a href="<?php bloginfo('url'); ?>"><img src="<?php echo $get_logo_image; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a>
                                                        <!--div class="logodes"><?php bloginfo('description'); ?></div-->
<?php } else { ?>
                                                        <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1><h2><?php bloginfo('description'); ?></h2><?php } ?>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="grid_13menu"> 
                                                <div class="menux" >
                                                    <div id="horiz_m" >
                                                        <div id="main_menu" class="slidemenu">
                                                            <?php
                                                            global $current_user;
                                                            if (is_user_logged_in()) {
                                                                if (user_can($current_user, "administrator")) {
                                                                    wp_nav_menu(array('theme_location' => 'header_administrator', 'container' => false, 'fallback_cb' => false));
                                                                }elseif (user_can($current_user, "subscriber")) {
                                                                    $tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
                                                                    switch ($tipe_user){
                                                                        case 'pra-avengers':
                                                                            $jadwals = sa_getJadwal();
                                                                            if($jadwals==false){
                                                                                wp_nav_menu(array('theme_location' => 'header_pra_avengers', 'container' => false, 'fallback_cb' => false));
                                                                            }else{
                                                                                wp_nav_menu(array('theme_location' => 'header_pra_avengers_tes', 'container' => false, 'fallback_cb' => false));
                                                                            }
                                                                            break;
                                                                        case 'avengers':
                                                                            wp_nav_menu(array('theme_location' => 'header_avengers', 'container' => false, 'fallback_cb' => false));
                                                                            break;
                                                                        case 'pra-aam':
                                                                            wp_nav_menu(array('theme_location' => 'header_pra_aam', 'container' => false, 'fallback_cb' => false));
                                                                            break;
                                                                        case 'aam':
                                                                            wp_nav_menu(array('theme_location' => 'header_aam', 'container' => false, 'fallback_cb' => false));
                                                                            break;
                                                                        case 'webadmin':
                                                                            wp_nav_menu(array('theme_location' => 'header_admin', 'container' => false, 'fallback_cb' => false));
                                                                            break;
                                                                    }
                                                                    /*
                                                                    if (get_the_author_meta('twitter')) {
                                                                        wp_nav_menu(array('theme_location' => 'header_subscriber', 'container' => false, 'fallback_cb' => false));
                                                                    }
                                                                     * 
                                                                     */
                                                                    
                                                                } else {
                                                                    wp_nav_menu(array('theme_location' => 'header_admin', 'container' => false, 'fallback_cb' => false));
                                                                }
                                                            } else {
                                                                wp_nav_menu(array('theme_location' => 'header_umum', 'container' => false, 'fallback_cb' => false));
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid_13icon">
                                                <div class="iconsicons"><?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Icons")) : endif; ?></div>
                                            </div>
                                        </div>