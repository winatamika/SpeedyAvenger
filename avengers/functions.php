<?php
date_default_timezone_set('Asia/Jakarta');
add_action('wp_enqueue_scripts', 'scripts');
function scripts() {
	if (!is_admin()) {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.7.1.min.js');
    wp_enqueue_script( 'jquery' );
	}
	//Menu
	wp_enqueue_script('menu_drop', get_bloginfo('template_url') . '/js/slidemenu.js', array('jquery'), '', false);
}
define("SITE_URL", site_url());
define("DASHBOARD_URL", SITE_URL . "/dashboard/");
define("REG_SUCCESS_URL", SITE_URL . "/regsuccess/");
define("LOGIN_URL", SITE_URL . "/login/");
define("BIODATA_URL", SITE_URL . "/update-biodata/");
define("DETAIL_PESERTA_URL", SITE_URL . "/biodata/");
define("BELAJAR_URL", SITE_URL . "/belajar/");
define("OT_URL", SITE_URL . "/tes-online/"); //define("OT_URL", SITE_URL . "/category/belajar/");
define("PRA_AAM_AL_URL", SITE_URL . "/tes-online-aam/");
define("AVG_URL", SITE_URL . "/category/info-produk-harga/");
define("AAM_URL", SITE_URL . "/category/info-produk-harga/");
define("STYLESHEET_URI", get_stylesheet_directory_uri());
define("LIMIT_HARD", 10);
define("LIMIT_MEDIUM", 15);
define("LIMIT_HARD_2", 5);
define("LIMIT_MEDIUM_2", 15);
define("LIMIT_HARD_3", 5);
define("LIMIT_MEDIUM_3", 15);
include "includes/functions.php";
$themename = "Avengers";
$shortname = str_replace(' ', '_', strtolower($themename));
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator', 10, 0);
remove_action('wp_head', 'rel_canonical', 10, 0);
add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');
function my_show_extra_profile_fields($user) {
    global $current_user, $wpdb;
    $tipe_user = esc_attr(get_the_author_meta('tipe_user', $user->ID));
    //$biodata_user = get_the_author_meta('biodata_user', $user->ID);
    //$biodata = json_decode($biodata_user, true);
    $witelid = get_the_author_meta('av_witel_id', $user->ID);
    $datelid = get_the_author_meta('av_datel_id', $user->ID);
    $witeldetail = get_term_by( 'id',  $witelid, 'widatel');
    $dateldetail = get_term_by( 'id',  $datelid, 'widatel');
    //$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
    //$witels = get_terms('widatel', $args);
    $witels = sa_getAll_witel();
    //$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>$witelid );
    //$datels = get_terms('widatel', $args);
    $datels = sa_get_datels($witelid);
    $tempat_lahir = get_the_author_meta('av_tempat_lahir', $user->ID);
    $tgl_lahir = get_the_author_meta('av_tanggal_lahir', $user->ID);
    $no_ktp = get_the_author_meta('av_no_ktp', $user->ID);
    $jenis_kelamin = get_the_author_meta('av_jenis_kelamin', $user->ID);
    $alamat_rumah = get_the_author_meta('av_alamat_rumah', $user->ID);
    $nomor_telepon_rumah = get_the_author_meta('av_nomor_telepon_rumah', $user->ID);
    $nomor_telepon_hp = get_the_author_meta('av_nomor_telepon_hp', $user->ID);
    $register_id = get_the_author_meta('av_register_id', $user->ID);
    ?>
    <h3>Biodata</h3>
    <table class="form-table">
        <tr>
            <th><label for="tipe_user">Witel</label></th>
            <td>
                <select name="witel" id="witel">
                <?php 
                foreach($witels as $witel){
                    $selected = ($witel->ID==$witelid)?"selected":"";
                    echo "<option value='".$witel->ID."' ".$selected.">".$witel->nama."</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Datel</label></th>
            <td>
                <select name="datel" id="datel">
                <?php 
                foreach($datels as $datel){
                    $selected = ($datel->ID==$datelid)?"selected":"";
                    echo "<option value='".$datel->ID."' ".$selected.">".$datel->nama."</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Tempat/Tanggal Lahir</label></th>
            <td>
                <input name="tempat_lahir" type="text" value="<?php echo isset($tempat_lahir)? $tempat_lahir:'';?>" >/
                <input name="tanggal_lahir" id="tanggal_lahir" type="text" size="12" value="<?php echo isset($tgl_lahir)? $tgl_lahir:'';?>" readonly="readonly">
            </td>
        </tr>
        <tr>
            <th><label for="no_ktp">No KTP</label></th>
            <td>
                <input name="no_ktp" id="no_ktp" type="text" maxlength="12" value="<?php echo isset($no_ktp)? $no_ktp:'';?>">
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Jenis Kelamin</label></th>
            <td>
                <select name="jenis_kelamin">
                    <option value="Laki-laki" <?php echo ($jenis_kelamin=="Laki-laki") ? 'selected':'';?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($jenis_kelamin=="Perempuan") ? 'selected':'';?>>Perempuan</option>
                </select>
                
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Alamat Rumah</label></th>
            <td>
                <input name="alamat_rumah" id="alamat_rumah" type="text" value="<?php echo isset($alamat_rumah)? $alamat_rumah:'';?>">
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Nomor Telepon Rumah</label></th>
            <td>
                <input name="nomor_telepon_rumah" id="nomor_telepon_rumah" type="text" value="<?php echo isset($nomor_telepon_rumah)? $nomor_telepon_rumah:'';?>">
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Nomor Telepon HP</label></th>
            <td>
                <input name="nomor_telepon_hp" id="nomor_telepon_hp" type="text" value="<?php echo isset($nomor_telepon_hp)? $nomor_telepon_hp:'';?>">
            </td>
        </tr>
        <tr>
            <th><label for="tipe_user">Register ID</label></th>
            <td>
                <?php echo isset($register_id)? $register_id:'';?>
            </td>
        </tr>

    </table>
    <h3>Histories Test</h3>
    <table class="form-table">
        <tr>
            <td>Tanggal</td>
            <td>Jenis Ujian</td>
            <td>Hasil</td>
        </tr>
    <?php
    $histories = sa_wpsqt_get_histories($user);
    if($histories<>false){
        foreach($histories as $history){
            $qname = sa_wpsqt_get_test_name($history->item_id);
            $fieldsetting = unserialize($qname->settings);
            //print_r($fieldsetting);
        ?>
        <tr>
            <td><?php echo date("Y-m-d",$history->datetaken); ?></td>
            <td><?php echo ($qname==false) ? 'Unknown':$qname->name; ?></td>
            <td><?php echo ($history->percentage>=$fieldsetting['pass_mark']) ? "Lulus":"Tidak Lulus" ; ?></td>
        </tr>
        <?php
        }
    }
    ?>
    </table>
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
                    <option value="superadmin" <?php echo ($tipe_user == "superadmin") ? "selected" : ""; ?> >SuperAdmin</option>
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
<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery( "#tanggal_lahir" ).datepicker({
          dateFormat: "yy-mm-dd",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          maxDate: '-17Y',
          yearRange: "-60:+0",
        });
  jQuery("#witel").change(function(){
    var _selected = jQuery("#witel").val();
    jQuery.ajax({
      type: "POST",
      url: "<?php echo SITE_URL;?>/api/api.php",
      data: { method:'getDatel', parentID: _selected },
      dataType: "json",
    })
    .done(function( msg ) {
      jQuery('#datel').empty(); 
      if(msg.status=true){
        jQuery("#witel option[value=0]").remove();
        datel = jQuery("#datel");
        var returnedArray = msg.data;
        for (var i = 0; i < returnedArray.length; ++i) {
          datel.append("<option value='" + returnedArray[i].ID + "'>" + returnedArray[i].nama + "</option>");
        }
      }
    });
  });
});
</script>
<?php
}
add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');
function my_save_extra_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id))
        return false;
    update_usermeta($user_id, 'tipe_user', $_POST['tipe_user']);
    update_usermeta($user_id, 'av_witel_id', $_POST['witel']);
    update_usermeta($user_id, 'av_datel_id', $_POST['datel']);
    update_usermeta($user_id, 'av_tempat_lahir', $_POST['tempat_lahir']);
    update_usermeta($user_id, 'av_tanggal_lahir', $_POST['tanggal_lahir']);
    update_usermeta($user_id, 'av_jenis_kelamin', $_POST['jenis_kelamin']);
    update_usermeta($user_id, 'av_alamat_rumah', $_POST['alamat_rumah']);
    update_usermeta($user_id, 'av_nomor_telepon_rumah', $_POST['nomor_telepon_rumah']);
    update_usermeta($user_id, 'av_nomor_telepon_hp', $_POST['nomor_telepon_hp']);
    update_usermeta($user_id, 'av_no_ktp', $_POST['no_ktp']);
}
function sa_redirect_page() {
    global $current_user;
    //$tipe_user = get_the_author_meta('tipe_user'); // esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
    $tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
    $subscriber_pages = array(10, 12, 18, 20, 21);
    $subscriber_categories = array(5);
    $pra_avengers_pages = array(10, 12, 18, 20, 21, 110, 158, 160, 177, 253, 274, 288, 285, 303, 329, 337, 348, 350, 518);
    $pra_avengers_categories = array(5);
    $avengers_pages = array(2, 10, 12, 18, 20, 21);
    $avengers_categories = array(6,7,8,9,10);
    $pra_aam_pages = array(96);
    $pra_aam_categories = array(5);
    $aam_pages = array(10, 12, 18, 20, 21);
    $aam_categories = array(5);
    if ( (is_page_template("page-register.php") AND !is_user_logged_in()) OR 
         (is_page_template("page-lupa.php")  AND !is_user_logged_in() ) ) {
    //AND ( is_page() OR is_single() OR is_home() )
        //wp_redirect(LOGIN_URL);
        return;
    }
    if ( !is_page_template("page-login.php") AND !is_user_logged_in() ) {
    //AND ( is_page() OR is_single() OR is_home() )
        wp_redirect(LOGIN_URL);
        exit();
    }
    if (user_can($current_user, "subscriber")) {
        if ($tipe_user == "pra-avengers") {
            if (!is_page($pra_avengers_pages)) {
                if (!in_category($pra_avengers_categories)) {
                    if (!is_category($pra_avengers_categories)) {
                        //$testhistories = sa_wpsqt_get_histories($current_user);
                        //print_r($testhistories);
                        //exit();
                        //$biodata_user = esc_attr(get_the_author_meta('biodata_user', $current_user));
                        //if($testhistories<>false){
                        //    wp_redirect(BIODATA_URL);
                        //    exit();
                        //}else{
                        $jadwals = sa_getJadwal();
                        if($jadwals==false)
                            wp_redirect(BELAJAR_URL);
                        else
                            wp_redirect(OT_URL);
                        exit();
                        //}
                    }
                }
            }
        } elseif ($tipe_user == "avengers") {
            if (!is_page($avengers_pages)) {
                if (!in_category($avengers_categories)) {
                    if (!is_category($avengers_categories)) {
                        wp_redirect(AVG_URL);
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
                        wp_redirect(AAM_URL);
                        exit();
                    }
                }
            }
        } elseif ($tipe_user == "webadmin") {
            //return;
        }
    }
    if (is_user_logged_in() AND is_page_template("page-login.php")) {
        wp_redirect(SITE_URL);
        exit();
    }
    if (user_can($current_user, "administrator")):
        //wp_redirect(DASHBOARD_URL);
        //exit();
        return;
    endif;
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
//if( WP_API_ACCESS==FALSE ){
    add_action('wp', 'sa_redirect_page');
//}
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
    $wp_admin_bar->remove_menu('site-name');
    $wp_admin_bar->remove_menu('updates');  
    //$wp_admin_bar->remove_menu('my-account');
    //bagian menambahkan link
    $wp_admin_bar->add_menu( array( 'parent' => $id, 'title' => __( '<strong class="log">LOG KELUAR</strong>' ), 'href' => wp_logout_url() ) );
    $wp_admin_bar->add_menu(array(
        'id' => 'wp-logo',
        'title' => '<img src="' . SITE_URL . '/wp-content/themes/avengers/images/logod.png" />',
        'href' => self_admin_url(''),
        'meta' => array(
            'title' => __('http://www.speedyavengers.com/'),
            ),
        ));
}
add_action('wp_before_admin_bar_render', 'wps_admin_bar');
register_nav_menus(array(
    'header_umum' => __('Header Umum', 'promotion'),
    'header_pra_avengers' => __('Header Pra Avengers', 'promotion'),
    'header_pra_avengers_tes' => __('Header Pra Avengers Tes', 'promotion'),
    'header_avengers' => __('Header Avengers', 'promotion'),
    'header_pra_aam' => __('Header Pra AAM', 'promotion'),
    'header_aam' => __('Header AAM', 'promotion'),
    'header_admin' => __('Header Admin', 'promotion'),
    'header_administrator' => __('Header Administrator', 'promotion'),
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
                            <table width="100%" border="0" style="padding:5px 10px;">
                                <tr>
                                    <td colspan="2">
                                        <h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3>
                                    </td>
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
                            </tr>
                            <tr>
                                <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
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
                            </tr>
                            <tr>
                                <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
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
                            </tr>
                            <tr>
                                <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
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
                            </tr>
                            <tr>
                                <td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
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
if (function_exists("add_theme_support")) {
    add_theme_support("post-thumbnails");
}
function enqueue_date_picker(){
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.js', array('jquery') );
    wp_enqueue_script( 'jquery-flexigrid', get_template_directory_uri() . '/jQueryPlugins/flaxigrid/js/flexigrid.js', array('jquery') );
    //wp_enqueue_style( 'jquery-ui-datepicker' );
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('style-flexigrid', get_template_directory_uri() . '/jQueryPlugins/flaxigrid/css/flexigrid.css');
}
add_action( 'admin_enqueue_scripts', 'enqueue_date_picker' );
add_action( 'wp_enqueue_scripts', 'enqueue_date_picker' );
//add_action( 'admin_footer', array( $this, 'admin_footer' ) );
add_action('admin_menu','wphidenag');
function wphidenag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('init', 'create_witel_taxonomies', 0);
function create_witel_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Widatel', 'taxonomy general name'),
        'singular_name' => _x('Widatel', 'taxonomy singular name'),
        'search_items' => __('Search Widatel'),
        'all_items' => __('All Widatel'),
        'parent_item' => __('Parent Widatel'),
        'parent_item_colon' => __('Parent Widatel:'),
        'edit_item' => __('Edit Widatel'),
        'update_item' => __('Update Widatel'),
        'add_new_item' => __('Add New Widatel'),
        'new_item_name' => __('New Widatel Name'),
        'menu_name' => __('Widatel'),
    );
    register_taxonomy('widatel', array('page'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'widatel'),
    ));
}
?>