<div class="pre-content"></div>
<div class="quiz">
<h1><?php echo stripslashes($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['name']); ?></h1>

<?php if ( isset($_SESSION['wpsqt']['current_message']) ) { ?>
	<p><?php echo $_SESSION['wpsqt']['current_message']; ?></p>
<?php } ?>

<?php 
if (isset($GLOBALS['q_config']) && isset($GLOBALS['q_config']['url_info']['url'])) {
	$url = $GLOBALS['q_config']['url_info']['url'];
} else {
	$url = $_SERVER['REQUEST_URI'];
}
?>
<?php if($_SESSION['wpsqt']['current_step'] != 0 && isset($_SESSION['wpsqt'][$quizName]['details']['save_resume']) && $_SESSION['wpsqt'][$quizName]['details']['save_resume'] == 'yes') { ?>
	<form method="post" action="<?php echo esc_url($url); ?>" class="wpsqt-save-form" style="float: right;">
		<input type="submit" name="wpsqt-save-state" value="Save and quit" />
		<input type="hidden" name="step" value="<?php echo ( $_SESSION['wpsqt']['current_step']+1); ?>">
	</form>
<?php } ?>

<?php
if (isset($_POST['wpsqt_time_elapsed'])) {
	$time_elapsed = $_POST['wpsqt_time_elapsed'];
} else {
	$time_elapsed = 0;
}
?>
<form method="post" action="<?php echo esc_url($url); ?>">
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<input type="hidden" name="step" value="<?php echo ( $_SESSION['wpsqt']['current_step']+1); ?>" />
	<input type="hidden" name="wpsqt_time_elapsed" value="<?php echo $time_elapsed; ?>" class="wpsqt_time_elapsed" />
<?php
		$answers = ( isset($_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"]) ) ? $_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"] : array();
$nomor = 0;
$p = 0;
$qty = 5;
$all = sizeof($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions']);
//echo $all;
foreach ($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'] as $questionKey => $question) { ?>

<?php 
if($nomor % $qty==0):
	$p = $p + 1;
	$createpage = TRUE;
else:
	$createpage = FALSE;
endif;
?>


<?php if($createpage) : ?>
	<?php if($p==1){ ?>
		<!--<div id="p<?php echo $p;?>" class="pagedemo _current" style="">-->
		<div id="page<?php echo $p;?>" class="pagesoal" style="">
	<?php }else{ ?>
		</div>
		<!--<div id="p<?php echo $p;?>" class="pagedemo" style="display:none;">-->
		<div id="page<?php echo $p;?>" class="pagesoal" style="display:none;">
	<?php } ?>
<?php endif; ?>

	<div class="wpst_question">
		<?php 

			
		$nomor = $nomor + 1;
		echo "<span class='num'>".$nomor.".</span>";

		echo "<span class='soal'>";
			$questionId = $question['id'];		
			$givenAnswer = isset($answers[$questionId]['given']) ? $answers[$questionId]['given'] : array();
			
			if ( isset($question["required"]) &&  $question["required"] == "yes" ){ 
				?>
				<font color="#FF0000"><strong>*
				
			<?php			
				// See if the question has been missed and this a replay if not end the red text here.
				if ( empty($_SESSION['wpsqt']['current_message']) || in_array($questionId,$_SESSION['wpsqt']['required']['given']) ){
					?></strong></font><?php 
				}
			}			
						
			echo stripslashes($question['name']);
			
			// See if the question has been missed and this is a replay
			if ( !empty($_SESSION['wpsqt']['current_message']) && !in_array($questionId,$_SESSION['wpsqt']['required']['given']) ){
				?></strong></font><?php 
			}	
		
			if ( !empty($question['add_text']) ){
			?>
			<p><?php echo nl2br(stripslashes($question['add_text'])); ?></p>
			<?php } ?>
			
			<?php if ( isset($question['image']) && !empty($question['image'])) { ?>
				<p><?php echo stripslashes($question['image']); ?></p>
			<?php } ?>
			
			<?php do_action('wpsqt_quiz_question_section',$question); ?>
			
			<?php require Wpsqt_Question::getDisplayView($question); ?>

			<?php if (isset($question['explanation']) && !empty($question['explanation'])) {
				// Parse the explanation text with the token replacement method
				// 	- Set up the token object
				require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
				$objTokens = Wpsqt_Tokens::getTokenObject();
				$objTokens->setDefaultValues();
				//	- replace the tokens
				$explanation = $objTokens->doReplacement( $question['explanation'] );
				if (!isset($question['explanation_onlyatfinish']) || $question['explanation_onlyatfinish'] !== "yes" ) { 
					echo '<a href="#" class="wpsqt-show-answer" style="display: none;">'; _e('Show answer', 'wp-survey-and-quiz-tool'); echo '</a>';
					echo '<div class="wpsqt-answer-explanation" style="display: none;">'.nl2br(stripslashes($explanation)).'</div>';
				}
			} ?>
		<?php echo "</span>"; ?>
	</div>

<?php if($all == $nomor) : 
	if ($sectionKey == (count($_SESSION['wpsqt'][$quizName]['sections']) - 1)) {
		?><p><input type='submit' value='<?php _e('Submit', 'wp-survey-and-quiz-tool'); ?>' class='button-secondary' /></p><?php
	} else {
		?><p><input type='submit' value='<?php _e('Next', 'wp-survey-and-quiz-tool'); ?> &raquo;' class='button-secondary' /></p><?php
	}
	echo "<!-- END PAGing -->"; 
	echo "</div>";
endif; ?>


<?php } ?>

<?php
/*
if ($sectionKey == (count($_SESSION['wpsqt'][$quizName]['sections']) - 1)) {
	?><p><input type='submit' value='<?php _e('Submit', 'wp-survey-and-quiz-tool'); ?>' class='button-secondary' /></p><?php
} else {
	?><p><input type='submit' value='<?php _e('Next', 'wp-survey-and-quiz-tool'); ?> &raquo;' class='button-secondary' /></p><?php
}
*/
?>
	
</form>

<div id="light-pagination"></div>

</div>
<div class="post-content"></div>

<script type="text/javascript">
jQuery('#light-pagination').pagination({
	displayedPages: 13,
    pages: <?php echo $p;?>,
    cssStyle: 'light-theme',
    onPageClick: function(pageNumber){ 
        //alert(pageNumber); 
        jQuery('.pagesoal').hide();
        jQuery('#page'+pageNumber).show();
    },
});
</script>