<?php
/* Template Name:  Pages Template Kejujuran */
?>

<?php get_header(); ?>
<style type="text/css">
<!--
table td {
	padding: 0 5px 2px 2px!important;
	background-color:#f8f8f8!important;
	color: #2d2419;
	border: none !important;
	width:auto!important;
}
table {margin: 0!important;width: auto!important;}

.bg{ background:#f2f2f2!important;}
select {width:150px!important;}
-->
</style>

<div id="content"> 
<div class="clear1"></div>
<h3>History Penjualan Perbulan</h3>
<form action="kejujuran" method="get">
<table width="300" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td class="bg" width="150"><strong>Rata - rata</strong></td>
    <td class="bg" width="150"><strong>Tahun</strong></td>
  </tr>
  <tr>
    <td><input type="text" name="rata1" id="rata1" /></td>
    <td><label>
      <select name="ratath1" id="ratath1">
      </select>
    </label></td>
  </tr>
  <tr>
    <td><input type="text" name="rata2" id="rata2" /></td>
    <td><label>
        <select name="ratath1" id="ratath2">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input type="text" name="rata3" id="rata3" /></td>
    <td><label>
        <select name="ratath1" id="ratath3">
        </select>
      </label></td>
  </tr>
</table>

<hr>
<h3>Tertinggi Bulan Tahun</h3>
<table width="450" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td class="bg" width="150"><strong>Tertinggi</strong></td>
    <td class="bg" width="150"><strong>Bulan</strong></td>
    <td class="bg" width="150"><strong>Tahun</strong></td>
  </tr>
  <tr>
    <td><input type="text" name="tinggi1" id="tinggi1" /></td>
    <td><label>
        <select name="tinggibl1" id="rendahth">
        </select>
      </label></td>
    <td> <label>
        <select name="tinggith1" id="tinggith1">
        </select>
      </label>
    </td>
  </tr>
  <tr>
    <td><input type="text" name="tinggi2" id="tinggi2" /></td>
    <td><label>
        <select name="tinggibl2" id="tinggibl2">
        </select>
      </label></td>
    <td> <label>
        <select name="tinggibl3" id="tinggibl3">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input type="text" name="tinggi3" id="tinggi3" /></td>
    <td><label>
        <select name="rendahth" id="rendahth">
        </select>
      </label></td>
    <td> <label>
        <select name="tinggith3" id="tinggith3">
        </select>
      </label></td>
  </tr>
  <tr>
    <td class="bg"><strong>Terendah</strong></td>
    <td class="bg"><strong>Bulan</strong></td>
    <td class="bg"><strong>Tahun</strong></td>
  </tr>
    <tr>
    <td><input type="text" name="rendah" id="rendah" /></td>
    <td><label>
        <select name="rendahbl" id="rendahbl">
        </select>
      </label></td>
    <td> <label>
        <select name="rendahth" id="rendahth">
        </select>
      </label></td>
  </tr>
</table>
<hr>
<h3>Training & Sertifikasi</h3>
<table width="700" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td class="bg" width="250"><strong>Nama Traing / sertifikasi</strong></td>
    <td class="bg" width="150"><strong>Peyelenggaraan</strong></td>
    <td class="bg" width="150"><strong>Bulan</strong></td>
    <td class="bg" width="150"><strong>Tahun </strong></td>
  </tr>
  <tr>
    <td><input name="training1" type="text" id="training1" size="34" /></td>
    <td><input type="text" name="peyelenggara1" id="peyelenggara1" /></td>
    <td><label>
        <select name="trainingbulan1" id="trainingbulan1">
        </select>
      </label></td>
    <td><label>
        <select name="trainingth1" id="trainingth1">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input name="training2" type="text" id="peyelenggara1" size="34" /></td>
    <td><input type="text" name="peyelenggara1" id="peyelenggara1" /></td>
    <td><label>
        <select name="trainingbulan2" id="trainingbulan2">
        </select>
      </label></td>
    <td><label>
        <select name="trainingth2" id="trainingth2">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input name="training3" type="text" id="training3" size="34" /></td>
    <td><input type="text" name="peyelenggara1" id="peyelenggara1" /></td>
    <td><label>
        <select name="trainingbulan3" id="trainingbulan3">
        </select>
      </label></td>
    <td><label>
        <select name="trainingth3" id="trainingth3">
        </select>
      </label></td>
  </tr>
</table>
<hr>
<h3>Riwayat Kerja</h3>
<table width="900" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td class="bg"><strong>Mitra</strong></td>
    <td class="bg" width="150"><strong>Dari</strong></td>
    <td class="bg" width="150">&nbsp;</td>
    <td  width="50">&nbsp;</td>
    <td class="bg" width="150"><strong>Sampai</strong></td>
    <td class="bg" width="150">&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td ><strong>Bulan</strong></td>
   <td ><strong>Tahun</strong></td>
   <td >&nbsp;</td>
    <td ><strong>Bulan</strong></td>
    <td ><strong>Tahun </strong></td>
  </tr>
  <tr>
    <td><input name="riwayat1" type="text" id="riwayat1" size="34" /></td>
    <td><label>
        <select name="daribl1" id="daribl1">
        </select>
      </label></td>
    <td><input type="text" name="trainingbulan4" id="trainingbulan4" /></td>
    <td>&nbsp;</td>
    <td><label>
        <select name="sampaibl1" id="sampaibl1">
        </select>
      </label></td>
    <td><label>
        <select name="sampaith1" id="sampaith1">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input name="riwayat2" type="text" id="riwayat2" size="34" /></td>
    <td><label>
        <select name="daribl2" id="daribl2">
        </select>
      </label></td>
    <td><input type="text" name="trainingbulan4" id="trainingbulan5" /></td>
    <td>&nbsp;</td>
    <td><label>
        <select name="sampaibl2" id="sampaibl2">
        </select>
      </label></td>
    <td><label>
        <select name="sampaith2" id="sampaith2">
        </select>
      </label></td>
  </tr>
  <tr>
    <td><input name="riwayat3" type="text" id="riwayat3" size="34" /></td>
    <td><label>
        <select name="daribl3" id="daribl3">
        </select>
      </label></td>
    <td><input type="text" name="trainingbulan4" id="trainingbulan6" /></td>
    <td>&nbsp;</td>
    <td><label>
        <select name="sampaibl3" id="sampaibl3">
        </select>
      </label></td>
    <td><label>
        <select name="sampaith3" id="sampaith3">
        </select>
      </label></td>
  </tr>
</table>
</form>
<div class="clear"></div>
</div>
<?php get_footer(); ?>
