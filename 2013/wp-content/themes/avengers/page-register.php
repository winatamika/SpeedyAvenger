<?php
/* Template Name:  Pages Template Register */
?>
<?php get_header(); ?>
<div id="content"> <div class="clear1"></div>
<div class="entry">	 
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
        <h2 class="title"><?php the_title(); ?></h2>

        <?php if(isset($_POST)){ } ?> 

        <form name="loginform" id="loginform" action="" method="post">
            <p class="login-first_name">
                <div class="grid_3 png">
                    <label for="first_name">Nama Depan</label>
                </div>
                <div class="grid_8 png">
                    <input type="text" name="first_name" id="first_name"  value="" size="20" />
                </div>
            </p>

            <p class="login-last_name">
                <div class="grid_3 png"><label for="last_name">Nama Belakang</label> </div>
                <div class="grid_8 png"><input name="last_name" id="last_name" type="text"> </div>
            </p>

            <p class="login-ttl">
             <div class="grid_3 png"> <label for="user_pass">Tempat / Tgl Lahir</label></div>
             <div class="grid_8 png">
                <input name="tempat_lahir" type="text" > / 
                <input name="tanggal" type="text" size="3">
                <select name="bulan">
                   <option value="januari">Januari</option>
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
                   <option value="desember">Desember</option>";
               </select>
               <input name="tahun" type="text" size="6">
           </div>
       </p>

       <p class="login-no_ktp">
         <div class="grid_3 png"><label for="no_ktp">No KTP</label></div>
         <div class="grid_8 png"><input name="no_ktp" id="no_ktp" type="text"></div>
     </p>

     <p class="login-jenis_kelamin">
         <div class="grid_3 png"><label for="jenis_kelamin">Jenis Kelamin</label></div>
         <div class="grid_8 png">
            <select name="jenis_kelamin">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
     </p>

     

    <p class="login-alamat_rumah">
     <div class="grid_3 png"><label for="alamat_rumah">Alamat Rumah</label></div>
     <div class="grid_8 png"><input name="alamat_rumah" id="alamat_rumah" type="text"></div>
 </p>

<p class="login-nomor_telepon_rumah">
        <div class="grid_3 png"><label for="nomor_telepon_rumah">Nomor Telepon Rumah</label></div>
        <div class="grid_8 png"><input name="nomor_telepon_rumah" id="nomor_telepon_rumah" type="text"></div>
    </p>

 <p class="login-nomor_telepon_hp">
    <div class="grid_3 png"> <label for="nomor_telepon_hp">Nomor Telepon Mobile / HP</label></div>
    <div class="grid_8 png"><input name="nomor_telepon_hp" id="nomor_telepon_hp" type="text"></div>
</p>

<p class="login-email">
 <div class="grid_3 png"><label for="email">Email </label></div>
 <div class="grid_8 png"><input name="email" id="email" type="text" ></div>
</p>

<p class="login-submit">
 <div class="row"><div class="grid_11 png"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Daftar" /> 
    <input type="hidden" name="redirect_to" value="http://www.speedyavengers.com" /></div></div>
</p>
</form> 

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