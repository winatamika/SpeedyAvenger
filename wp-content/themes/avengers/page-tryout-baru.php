<?php
/* Template Name:  Pages Tryout Baru*/ 
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
                        '10'=>'<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-setter/">Tryout Setting Skill </a></p> ',
                        '9'=>'<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-seller/">Tryout Selling Skill</a></p>',
                        '7'=>'<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-service/">Tryout Service Skill</a></p> '
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
                            }else{
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
Dokumentasi page tryout
<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-setter/">Tryout Setting Skill </a></p>
<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-seller/">Tryout Selling Skill</a></p>
<p style="text-align: center;"><a class="button" style="width: 330px;" href="http://localhost/avengerdeslast/tryout/tryout-service/">Tryout Service Skill</a></p>
<p><!--wpsqt name="Try Out 19 September 2013" type="quiz"--></p>


-->