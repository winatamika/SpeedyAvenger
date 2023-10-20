<?php
/* Template Name:  Pages Update Profile */ 

global $current_user;
//print_r($current_user);
if ( (isset($_POST['biodata_kirim_nonce_field']) && wp_verify_nonce($_POST['biodata_kirim_nonce_field'], 'biodata_kirim_action')) ){
   $_POST['tgl_lahir'] = $_POST['tanggal'] . "-" .$_POST['bulan']. "-" . $_POST['tahun'];

   if(
         $_POST['nama_lengkap']=="" || $_POST['tempat_lahir']=="" || 
         $_POST['tgl_lahir']=="" || $_POST['no_ktp']=="" || 
         $_POST['jenis_kelamin']=="" || $_POST['agama']=="" ||
         $_POST['alamat_rumah']=="" || $_POST['nomor_telepon_hp']=="" || $_POST['email']=""
       ){
     
     $error = "*** Semua masukan harus diisi";
     
   }else{

     $biodata = array(
        'nama_lengkap'=>$_POST['nama_lengkap'],
        'tempat_lahir'=>$_POST['tempat_lahir'],
        'tgl_lahir'=>$_POST['tgl_lahir'],
        'no_ktp'=>$_POST['no_ktp'],
        'jenis_kelamin'=>$_POST['jenis_kelamin'],
        'agama'=>$_POST['agama'],
        'alamat_rumah'=>$_POST['alamat_rumah'],
        'nomor_telepon_hp'=>$_POST['nomor_telepon_hp'],
        'email'=>$_POST['email'],
        );
     //if (!current_user_can('edit_user', $user_id))
     //    return false;
     update_usermeta($current_user->ID, 'biodata_user', json_encode($biodata));
     wp_redirect(OT_URL);
     exit();
     
    }
}


?>
<?php //get_header(); ?>
<!-- DARI SINI-->
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
                                <script src="<?php echo STYLESHEET_URI; ?>/js/simplePagination/jquery.simplePaginationn.js" type="text/javascript"></script>




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
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid_13icon">
                                                <div class="iconsicons"><?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Icons")) : endif; ?></div>
                                            </div>
                                        </div>
<!-- SAMPAI SINI-->
<div id="content"> 
<?php //include(TEMPLATEPATH."/slider.php");?>
<div class="clear1"></div>
<div class="entry">	 
    <div class="post" id="post-profile">
        <form name="updateBiodata" method="post" action="#">
            <h2 class="title">Biodata</h2>
            <!-- = -->
            <p>
                Sebelum memulai tes, lengkapilah data pribadi Anda dengan mengisi form di bawah ini. 
                Biodata Anda akan tersimpan otomatis di database Speedy Avenger dan dijamin kerahasiaannya.
            </p>
            <?php
            if(isset($error)){
               echo "<p class='error'>".$error."</p>";
            }
            ?>
            <?php
            $biodata_user = get_the_author_meta('biodata_user', $current_user->ID);
            $biodata = json_decode($biodata_user, true);
            //print_r($biodata);
            $tgl_lahir = explode("-",$biodata['tgl_lahir']);
            $tanggal = $tgl_lahir[0];
            $bulan = $tgl_lahir[1];
            $tahun = $tgl_lahir[2];
            
            ?>
            <p class="login-password"><div class="grid_3 png"> Nama Lengkap </div> <div class="grid_8 png">: <input name="nama_lengkap" type="text" value="<?php echo isset($biodata['nama_lengkap']) ? $biodata['nama_lengkap']:'';?>"></div></p>

            <p class="login-password"><div class="grid_3 png"> Tempat/Tanggal Lahir </div> <div class="grid_8 png">: <input name="tempat_lahir" type="text" value="<?php echo isset($biodata['tempat_lahir'])? $biodata['tempat_lahir']:'';?>"> /            
            
            <input name="tanggal" type="text" size="3" value="<?php echo isset($tanggal)? $tanggal:'';?>">
            <select name="bulan">
               <!--<option value="januari">Januari</option>
               <option value="februari">Februari</option>
               <option value="maret">Maret</option>
               <option value="april">April</option>
               <option value="mei">Mei</option>
               <option value="juni">Juni</option>
               <option value="juli">Juli</option>
               <option value="agustus">Agustus</option>
               <option value="september">September</option>
               <option value="oktober">Oktober</option>
               <option value="nopember">Nopember</option>
               <option value="desember">Desember</option>-->
			   <?php
			
			$januari  = 'januari';
			$februari = 'februari';
			$maret = 'maret';
			$april = 'april';
			$mei = 'mei';
			$juni = 'juni';
			$juli = 'juli';
			$agustus = 'agustus';
			$september = 'september';
			$oktober = 'oktober';
			$nopember = 'nopember';
			$desember = 'desember';

			echo "
               <option value='januari' ".(($januari == $bulan)? ' selected="selected"' : '').">Januari</option>
               <option value='februari' ".(($februari == $bulan)? ' selected="selected"' : '').">Februari</option>
               <option value='maret' ".(($maret == $bulan)? ' selected="selected"' : '').">Maret</option>
               <option value='april' ".(($april == $bulan)? ' selected="selected"' : '').">April</option>
               <option value='mei' ".(($mei == $bulan)? ' selected="selected"' : '').">Mei</option>
               <option value='juni' ".(($juni == $bulan)? ' selected="selected"' : '').">Juni</option>
               <option value='juli' ".(($juli == $bulan)? ' selected="selected"' : '').">Juli</option>
               <option value='agustus' ".(($agustus == $bulan)? ' selected="selected"' : '').">Agustus</option>
               <option value='september' ".(($september == $bulan)? ' selected="selected"' : '').">September</option>
               <option value='oktober' ".(($oktober == $bulan)? ' selected="selected"' : '').">Oktober</option>
               <option value='nopember' ".(($nopember == $bulan)? ' selected="selected"' : '').">Nopember</option>
			   <option value='desember' ".(($desember == $bulan)? ' selected="selected"' : '').">Desember</option>";
			   ?>
            </select>
            <input name="tahun" type="text" size="6" value="<?php echo isset($tahun)? $tahun:'';?>">
            
            <!--<input name="tgl_lahir" type="text" value="<?php echo isset($biodata['tgl_lahir'])? $biodata['tgl_lahir']:'';?>">--></div></p>
            
            <p class="login-password"><div class="grid_3 png"> No KTP </div> <div class="grid_8 png">: <input name="no_ktp" type="text" value="<?php echo isset($biodata['no_ktp'])? $biodata['no_ktp']:'';?>"></div></p>

            <p class="login-password"><div class="grid_3 png"> Jenis Kelamin </div> <div class="grid_8 png">: <select name="jenis_kelamin"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div></p>

            <p class="login-password"><div class="grid_3 png"> Agama </div> <div class="grid_8 png">: <input name="agama" type="text" value="<?php echo isset($biodata['agama'])? $biodata['agama']:'';?>"></div></p>

            <p class="login-password"><div class="grid_3 png"> Alamat Rumah </div> <div class="grid_8 png">: <input name="alamat_rumah" type="text" value="<?php echo isset($biodata['alamat_rumah'])? $biodata['alamat_rumah']:'';?>"></div></p>

            <p class="login-password"><div class="grid_3 png"> Nomor Telepon / HP </div> <div class="grid_8 png">: <input name="nomor_telepon_hp" type="text" value="<?php echo isset($biodata['nomor_telepon_hp'])? $biodata['nomor_telepon_hp']:'';?>"></div></p>

            <p class="login-password"><div class="grid_3 png"> Email </div> <div class="grid_8 png">: <input name="email" type="text" value="<?php echo isset($biodata['email'])? $biodata['email']:'';?>"></div></p>
<div class="clear"></div>
            <div class="row"><div class="grid_11">
<?php echo '<input name="submit_book_button" id="button" class="button-primary3" value="Simpan" type="submit" >';
            wp_nonce_field('biodata_kirim_action','biodata_kirim_nonce_field');
            ?></div></div>
        </form>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>