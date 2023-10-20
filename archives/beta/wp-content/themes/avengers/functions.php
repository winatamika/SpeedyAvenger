<?php
define("SITE_URL", site_url());
define("LOGIN_URL", SITE_URL . "/login/");
define("OT_URL", SITE_URL . "/category/belajar/");
define("PRA_AAM_AL_URL", SITE_URL . "/tes-online-aam/");
define("STYLESHEET_URI", get_stylesheet_directory_uri());


define("LIMIT_HARD", 5);
define("LIMIT_MEDIUM", 5);

$themename = "Avengers";
$shortname = str_replace(' ', '_', strtolower($themename));

remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator', 10, 0);
remove_action('wp_head', 'rel_canonical', 10, 0);

add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');

function my_show_extra_profile_fields($user) {
    global $current_user;
    $tipe_user = esc_attr(get_the_author_meta('tipe_user', $user->ID));
    ?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="tipe_user">Tipe</label></th>
            <td>
                <?php if (user_can($current_user, "administrator")): ?>
                    <select name="tipe_user" id="tipe_user">
                        <option value="pra-avengers" <?php echo ($tipe_user == "pra-avengers") ? "selected" : ""; ?> >Pra Avengers</option>
                        <option value="avengers" <?php echo ($tipe_user == "avengers") ? "selected" : ""; ?> >Avengers</option>

                        <option value="pra-aam" <?php echo ($tipe_user == "pra-aam") ? "selected" : ""; ?> >Pra AAM</option>
                        <option value="aam" <?php echo ($tipe_user == "aam") ? "selected" : ""; ?> >AAM</option>

                        <option value="sosiality_area" <?php echo ($tipe_user == "sosiality_area") ? "selected" : ""; ?> >Sociality Area</option>

                        <option value="webadmin" <?php echo ($tipe_user == "webadmin") ? "selected" : ""; ?> >Web Admin</option>
                    </select>
                <?php else: ?>
                    <?php echo $tipe_user; ?><input name="tipe_user" id="tipe_user" value="<?php echo $tipe_user; ?>" type="hidden">
                <?php endif; ?>
                <!--
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description">Please enter your Twitter username.</span>
                -->
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

function my_save_extra_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id))
        return false;

    update_usermeta($user_id, 'tipe_user', $_POST['tipe_user']);
}

function sa_redirect_page() {
    global $current_user;
    //$tipe_user = get_the_author_meta('tipe_user'); // esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
    $tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));

    $subscriber_pages = array(10, 12, 18, 20, 21);
    $subscriber_categories = array(5);

    $pra_avengers_pages = array(10, 12, 18, 20, 21);
    $pra_avengers_categories = array(5);

    $avengers_pages = array(10, 12, 18, 20, 21);
    $avengers_categories = array(5);

    $pra_aam_pages = array(96);
    $pra_aam_categories = array(5);

    $aam_pages = array(10, 12, 18, 20, 21);
    $aam_categories = array(5);

    if (!is_page_template("page-login.php") AND !is_user_logged_in() AND ( is_page() OR is_single() OR is_home() )) {
        wp_redirect(LOGIN_URL);
        exit();
    }

    if (user_can($current_user, "subscriber")) {

        if ($tipe_user == "pra-avengers") {
            if (!is_page($pra_avengers_pages)) {
                if (!in_category($pra_avengers_categories)) {
                    if (!is_category($pra_avengers_categories)) {
                        wp_redirect(OT_URL);
                        exit();
                    }
                }
            }
        } elseif ($tipe_user == "avengers") {
            if (!is_page($avengers_pages)) {
                if (!in_category($avengers_categories)) {
                    if (!is_category($avengers_categories)) {
                        wp_redirect(OT_URL);
                        exit();
                    }
                }
            }
        } elseif ($tipe_user == "pra-aam") {
            if (!is_page($pra_aam_pages)) {
                if (!in_category($pra_aam_categories)) {
                    if (!is_category($pra_aam_categories)) {
                        wp_redirect(PRA_AAM_AL_URL);
                        exit();
                    }
                }
            }
        } elseif ($tipe_user == "aam") {
            if (!is_page($aam_pages)) {
                if (!in_category($aam_categories)) {
                    if (!is_category($aam_categories)) {
                        wp_redirect(OT_URL);
                        exit();
                    }
                }
            }
        }
    }


    if (is_user_logged_in() AND is_page_template("page-login.php")) {
        wp_redirect(SITE_URL);
        exit();
    }

    if (user_can($current_user, "administrator")):
        return;
    endif;

    /*
      if (user_can($current_user, "administrator")):
      return;
      endif;

      if( !is_page_template("page-login.php") AND !is_user_logged_in() AND ( is_page() OR is_single() OR is_home() ) ){
      wp_redirect(LOGIN_URL);
      }

      if( is_page_template("page-login.php") AND is_user_logged_in() ){
      wp_redirect(SITE_URL);
      }

      if (user_can($current_user, "subscriber") AND !is_page_template("page-ot.php") ):
      wp_redirect(OT_URL);
      endif;
     */

    /*
      if (!user_can($current_user, "administrator")):
      if (( is_page() OR is_single() OR is_home() ) AND !is_page_template("page-login.php")) {
      if (!is_user_logged_in()) {
      wp_redirect(LOGIN_URL);
      //echo LOGIN_URL;
      die();
      } elseif (user_can($current_user, "subscriber")) {
      wp_redirect(OT_URL);
      //echo OT_URL;
      die();
      }
      } else {
      if (is_user_logged_in()) {
      wp_redirect(SITE_URL);
      //echo SITE_URL;
      die();
      }
      }
      endif;
     * 
     */
}

//add columns to User panel list page
function add_user_columns($defaults) {
    $defaults['tipe_user'] = __('Tipe', 'user-column');
    return $defaults;
}

function add_custom_user_columns($value, $column_name, $id) {
    if ($column_name == 'tipe_user') {
        return get_the_author_meta('tipe_user', $id);
    }
}

add_action('manage_users_custom_column', 'add_custom_user_columns', 15, 3);
add_filter('manage_users_columns', 'add_user_columns', 15, 1);

add_action('wp', 'sa_redirect_page');

function sa_login_page() {
    wp_redirect(LOGIN_URL);
    die();
}

add_filter('login_redirect', 'sa_login_page', 10, 3);

function sa_login_fail() {
    wp_redirect(LOGIN_URL . '/?fail=true');
    die();
}

add_action('wp_login_failed', 'sa_login_fail');

function wps_admin_bar() {
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    //bagian menambahkan link
    $wp_admin_bar->add_menu(array(
        'id' => 'wp-logo',
        'title' => '<img src="' . SITE_URL . '/wp-content/themes/avengers/images/logod.png" />',
        'href' => self_admin_url(''),
        'meta' => array(
            'title' => __('WWW'),
        ),
    ));
}

add_action('wp_before_admin_bar_render', 'wps_admin_bar');

register_nav_menus(array(
    'header_umum' => __('Header Umum', 'promotion'),
    'header_pra_avengers' => __('Header Pra Avengers', 'promotion'),
    'header_avengers' => __('Header Avengers', 'promotion'),
    'header_pra_aam' => __('Header Pra AAM', 'promotion'),
    'header_aam' => __('Header AAM', 'promotion'),
    'header_admin' => __('Header Admin', 'promotion'),
));

function example_remove_dashboard_widgets() {
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;

    // Remove the incomming links widget
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);

    // Remove right now
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

// Hoook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');

//__('Appearance'),
function remove_menus() {
    global $menu;
    $restricted = array(__(''));
    end($menu);
    while (prev($menu)) {
        $value = explode(' ', $menu[key($menu)][0]);
        if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {
            unset($menu[key($menu)]);
        }
    }
}

add_action('admin_menu', 'remove_menus');

function bbcode($attr, $content = null) {
    $content = clean_pre($content); // Clean pre-tags
    return '<pre"><code>' .
            str_replace('<', '&lt;', $content) . // Escape < chars
            '</code></pre>';
}

add_shortcode('code', 'bbcode');

// Hide admin help tab
function hide_help() {
    echo '';
}

add_action('admin_head', 'hide_help');


if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Sidebar',
        'before_widget' => '<lu>',
        'after_widget' => '</lu>',
        'before_title' => '<h3 >',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Icons',
        'before_widget' => '<lu>',
        'after_widget' => '</lu>',
        'before_title' => '<h3 >',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => 'Welcome',
        'before_widget' => '<lu>',
        'after_widget' => '</lu>',
        'before_title' => '<h3 >',
        'after_title' => '</h3>',
    ));
}

function get_theme_option($option) {
    global $shortname;
    return stripslashes(get_option($shortname . '_' . $option));
}

function get_theme_settings($option) {
    return stripslashes(get_option($option));
}

function cats_to_select() {
    $categories = get_categories('hide_empty=0');
    $categories_array[] = array('value' => '0', 'title' => 'Select');
    foreach ($categories as $cat) {
        if ($cat->category_count == '0') {
            $posts_title = 'No posts!';
        } elseif ($cat->category_count == '1') {
            $posts_title = '1 post';
        } else {
            $posts_title = $cat->category_count . ' posts';
        }
        $categories_array[] = array('value' => $cat->cat_ID, 'title' => $cat->cat_name . ' ( ' . $posts_title . ' )');
    }
    return $categories_array;
}

$options = array(
    array("type" => "open"),
    array("name" => "Logo Image",
        "desc" => "Enter the logo image full path (Width 220 px , Height 135 px). Leave it blank if you don't want to use logo image.",
        "id" => $shortname . "_logo",
        "std" => get_bloginfo('template_url') . "/images/logo.png",
        "type" => "text"),
    array("name" => "Footer Address",
        "desc" => "Footer Address.",
        "id" => $shortname . "_ad_sidebar_bottom",
        "type" => "textarea",
        "std" => ''
    ),
    array("type" => "close")
);

function mytheme_add_admin() {
    global $themename, $shortname, $options;

    if ($_GET['page'] == basename(__FILE__)) {

        if ('save' == $_REQUEST['action']) {

            foreach ($options as $value) {
                update_option($value['id'], $_REQUEST[$value['id']]);
            }

            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }

            echo '<meta http-equiv="refresh" content="0;url=themes.php?page=functions.php&saved=true">';
            die;
        }
    }

    add_theme_page($themename . " Options", "" . $themename . " Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

if (function_exists('get_sidebars'))
    register_sidebar(array('name' => 'get_sidebars',
        'before_widget' => '<div id="featured" class="box">',
        'after_widget' => '<div class="cap"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ($_REQUEST['saved'])
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    ?>
    <div class="wrap">
        <h2><?php echo $themename; ?> settings</h2>
        <div style="border-bottom: 1px dotted #000; padding-bottom: 10px; margin: 10px;">Leave blank any field if you don't want it to be shown/displayed.</div>
        <form method="post">



            <?php
            foreach ($options as $value) {

                switch ($value['type']) {

                    case "open":
                        ?>
                        <table width="100%" border="0" style=" padding:10px;">



                            <?php
                            break;

                        case "close":
                            ?>

                        </table><br />


                        <?php
                        break;

                    case "title":
                        ?>
                        <table width="100%" border="0" style="padding:5px 10px;"><tr>
                                <td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
                            </tr>


                            <?php
                            break;

                        case 'text':
                            ?>

                            <tr>
                                <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="80%"><input style="width:100%;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo get_theme_settings($value['id']); ?>" /></td>
                            </tr>

                            <tr>
                                <td><small><?php echo $value['desc']; ?></small></td>
                            </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

                            <?php
                            break;

                        case 'textarea':
                            ?>

                            <tr>
                                <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:100%; height:140px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php echo get_theme_settings($value['id']); ?></textarea></td>

                            </tr>

                            <tr>
                                <td><small><?php echo $value['desc']; ?></small></td>
                            </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

                            <?php
                            break;

                        case 'select':
                            ?>
                            <tr>
                                <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="80%">
                                    <select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                        <?php foreach ($value['options'] as $option) { ?>
                                            <option value="<?php echo $option['value']; ?>" <?php
                                            if (get_theme_settings($value['id']) == $option['value']) {
                                                echo ' selected="selected"';
                                            }
                                            ?>><?php echo $option['title']; ?></option>
                                                <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td><small><?php echo $value['desc']; ?></small></td>
                            </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

                            <?php
                            break;

                        case "checkbox":
                            ?>
                            <tr>
                                <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="80%"><?
                                    if (get_theme_settings($value['id'])) {
                                        $checked = "checked=\"checked\"";
                                    } else {
                                        $checked = "";
                                    }
                                    ?>
                                    <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                                </td>
                            </tr>

                            <tr>
                                <td><small><?php echo $value['desc']; ?></small></td>
                            </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

                            <?php
                            break;
                    }
                }
                ?>

                <!--</table>-->
                <p class="submit">
                    <input name="save" type="submit" value="Save changes" />    
                    <input type="hidden" name="action" value="save" />
                </p>
        </form>

        <?php
    }

    add_action('admin_menu', 'mytheme_add_admin');

    function sidebar_ads_125() {
        global $shortname;
        $option_name = $shortname . "_ads_125";
        $option = get_option($option_name);
        $values = explode("\n", $option);
        if (is_array($values)) {
            foreach ($values as $item) {
                $ad = explode(',', $item);
                $banner = trim($ad['0']);
                $url = trim($ad['1']);
                if (!empty($banner) && !empty($url)) {
                    echo "<a href=\"$url\" target=\"_new\"><img class=\"ad125\" src=\"$banner\" /></a> \n";
                }
            }
        }
    }
    ?>
    <?php
    if (function_exists("add_theme_support")) {
        add_theme_support("post-thumbnails");
    }
    ?>