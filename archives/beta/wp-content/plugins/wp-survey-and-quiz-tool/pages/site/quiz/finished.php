<?php 
// Set up the token object
require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
$objTokens = Wpsqt_Tokens::getTokenObject();
$objTokens->setDefaultValues();

?>

<h2><?php _e('Exam Finished', 'wp-survey-and-quiz-tool'); ?></h2>

<?php if ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Finish message' || $_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Both'  ) { ?>
	<?php if (isset($_SESSION['wpsqt'][$quizName]['details']['pass_finish']) &&
		$_SESSION['wpsqt'][$quizName]['details']['pass_finish'] == "yes" &&
		$percentRight >= $_SESSION['wpsqt'][$quizName]['details']['pass_mark']) {
			// Show pass finish message
			$string = $objTokens->doReplacement($_SESSION['wpsqt'][$quizName]['details']['pass_finish_message']);
			echo nl2br($string);
	} else if ( isset($_SESSION['wpsqt'][$quizName]['details']['fail_review']) &&
		$_SESSION['wpsqt'][$quizName]['details']['fail_review'] == "yes" &&
		$percentRight < $_SESSION['wpsqt'][$quizName]['details']['pass_mark'] &&
   		$_SESSION['wpsqt'][$quizName]['details']['finish_display'] != 'Both'){
			require_once Wpsqt_Core::pageView('site/quiz/review.php');
	} else if ( isset($_SESSION['wpsqt'][$quizName]['details']['finish_message']) &&
		!empty($_SESSION['wpsqt'][$quizName]['details']['finish_message'])) {
			// PARSE TOKENS
			$string = $objTokens->doReplacement($_SESSION['wpsqt'][$quizName]['details']['finish_message']);
			echo nl2br($string);
	} else {
		_e('Thank you for your time.', 'wp-survey-and-quiz-tool');
		?>
		
		<!-- AddThis Button BEGIN -->
		<!--<div class="addthis_toolbox addthis_default_style addthis_32x32_style">-->
                <div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="<?php echo WEB_URL;?>" addthis:title="Hai, saya sudah selesaikan kuis ini, bagaimana dengan kamu?">
		<!--<a class="addthis_button_preferred_1"></a>-->
		<a class="addthis_button_preferred_2"></a>
		<a class="addthis_button_preferred_3"></a>
		<a class="addthis_button_preferred_4"></a>
		<a class="addthis_button_compact"></a>
		<a class="addthis_counter addthis_bubble_style"></a>
		</div>
		<script type="text/javascript">
		var addthis_config = {"data_track_addressbar":true};
		</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e76cf94129ff9c1"></script>
		<!-- AddThis Button END -->
<?php
	} ?>
		
<?php } if ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Quiz Review' || $_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Both'){ 
	require_once Wpsqt_Core::pageView('site/quiz/review.php');	
} 

	if ( $_SESSION['wpsqt'][$quizName]['details']['use_pdf'] == "yes" ){
		?>
		<a href="<?php echo plugins_url('pdf.php?quizid='.$_SESSION['wpsqt'][$quizName]['details']['id'].'&id='.$_SESSION['wpsqt']['result_id'],WPSQT_FILE); ?>"><?php _e('Download certification', 'wp-survey-and-quiz-tool'); ?></a>
		<?php 
	}
?>

