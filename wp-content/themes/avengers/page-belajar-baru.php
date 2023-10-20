<?php
/* Template Name:  Pages Belajar Baru*/ 
?>
<?php get_header(); ?>
<div id="content"> <?php include(TEMPLATEPATH."/scroll.php");?>
<?php //include(TEMPLATEPATH."/slider.php");?>
    <div class="clear1"></div>
             <div class="entry">	 
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="post" id="post-<?php the_ID(); ?>">
                    <h2 class="title"><?php the_title(); ?></h2>
                    <?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(300,225), array("class" => "alignleft post_thumbnail")); } ?>
                    <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                    
					             <?php
                    $jadwals = sa_getJadwal();
                   //print_r($jadwals);
                    $links = array(
                        '10'=>'<a class="button-inactive" href="#">Tes Setting Skill</a> ',
                        '9'=>'<a class="button-inactive" href="#">Tes Selling Skill</a> ',
                        '7'=>'<a class="button-inactive" href="#">Tes Service Skill</a>'
                        );
                    
                    $links_active = array(
                        '10'=>'<div class="row">
<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Setting Skill</h3>
<a class="button" href="http://speedyavengers.com/materi/Materi-Setter.pdf" target="_blank">e-learning Setting Skill</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-setter/">Video Setting Skill</a>

</div> ',
                        '9'=>'<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Selling Skill</h3>
<a class="button" href="http://localhost/avengerdeslast/wp-content/uploads/2013/04/Selling-Skill-SF.pptx">e-learning Selling Skill</a>

<a class="button" href="http://localhost/avengerdeslast/wp-content/uploads/2013/04/Code-of-Conduct-SF.pptx">Code of Conduct SF</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-sales/">Video Selling Skill</a>

</div> ',
                        '7'=>'<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Service Skill</h3>
<a class="button" href="#" target="_blank">e-learning Service Skill</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-service/">Video Service Skill
</a>

</div> '
                        );
						
					$links_nonactive = array(
                        '10'=>'',
                        '9'=>'',
                        '7'=>'',
						
                        );
                    ?>
                    <p style="text-align: center;">
                        <?php
							
                        foreach($links as $key=>$value){
												
                            if($jadwals){
								$links[$key] = $links_nonactive[$key];	

                                foreach($jadwals as $row){
                                    if($row->wpsqt_id==$key){
                                        $links[$row->wpsqt_id] = $links_active[$row->wpsqt_id];
                                    }
                                }
                            }
							else{
							$links[$key] = $links_nonactive[$key];	
							}
						
							
                        }

                        echo '<p style="text-align: center;">'.implode(" ", $links).'</p>';
                        /*
                        foreach($jadwals as $row){
                            echo '<a class="button active" href="http://www.speedyavengers.com/tes-online/setting/">Tes Setting Skill</a> '
                            echo $links[$row->wpsqt_id];
                        }
                        */
                        ?>
                    </p>
					
					
					<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                </div>
                <?php endwhile; endif; ?>
                <div class="clear"></div>
                <?php //edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
            </div>
    
    <div class="clear"></div>
</div>
<?php get_footer(); ?>

<!--
dokumentasi belajar 
<h3>Halo Avengers!</h3>
Selamat bergabung dengan <strong>PT. TELKOM INDONESIA</strong>, perusahaan telekomunikasi terbesar di Indonesia.
<strong>Avengers</strong> adalah tim sales force dan tim setting yang berada dalam salah satu divisi Telkom Indonesia.
Website ini disediakan untuk para Avenger <strong>sebagai media untuk belajar, saling berbagi</strong> sekaligus untuk <strong>mengukur kompetensi</strong> Anda, baik sebagai <strong>Sales</strong>, <strong>Setter</strong> maupun <strong>Service Skill</strong>.

Penjelasan mengenai setting skill dapat klik di bawah ini:

<div class="row">

<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Setting Skill</h3>
<a class="button" href="http://speedyavengers.com/materi/Materi-Setter.pdf" target="_blank">e-learning Setting Skill</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-setter/">Video Setting Skill</a>

</div>
<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Selling Skill</h3>
<a class="button" href="http://localhost/avengerdeslast/wp-content/uploads/2013/04/Selling-Skill-SF.pptx">e-learning Selling Skill</a>

<a class="button" href="http://localhost/avengerdeslast/wp-content/uploads/2013/04/Code-of-Conduct-SF.pptx">Code of Conduct SF</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-sales/">Video Selling Skill</a>

</div>
<div class="grid_4" style="text-align: center;">
<h3>Materi Pembelajaran Service Skill</h3>
<a class="button" href="#" target="_blank">e-learning Service Skill</a>

<a class="button" href="http://localhost/avengerdeslast/belajar/materi-video-service/">Video Service Skill
</a>

</div>

</div>


-->