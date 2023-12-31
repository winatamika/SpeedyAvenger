<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$eemail_errors = array();
$eemail_success = '';
$eemail_error_found = FALSE;

$search = isset($_GET['search']) ? $_GET['search'] : 'A,B,C';
if (isset($_POST['eemail_sendmail_commenter']) && $_POST['eemail_sendmail_commenter'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('eemail_sendmail_commenter');

	$form['eemail_subject_drop'] = isset($_POST['eemail_subject_drop']) ? $_POST['eemail_subject_drop'] : '';
	if ($form['eemail_subject_drop'] == '')
	{
		$eemail_errors[] = __('Please select email subject.', 'email-newsletter');
		$eemail_error_found = TRUE;
	}
	$form['eemail_checked'] = isset($_POST['eemail_checked']) ? $_POST['eemail_checked'] : '';
	if ($form['eemail_checked'] == '')
	{
		$eemail_errors[] = __('Please select email address.', 'email-newsletter');
		$eemail_error_found = TRUE;
	}
	$recipients = $_POST['eemail_checked'];
	
	//	No errors found, we can add this Group to the table
	if ($eemail_error_found == FALSE)
	{
		$sSql = $wpdb->prepare(
				"SELECT COUNT(*) AS `count` FROM ".WP_eemail_TABLE."
				WHERE `eemail_id` = %d",
				array($form['eemail_subject_drop'])
			);
			$result = '0';
			$result = $wpdb->get_var($sSql);
			
			if ($result != '1')
			{
				?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'email-newsletter'); ?></strong></p></div><?php
			}
			else
			{
				$num_sent = 0;
				$recipients = $form['eemail_checked'];
				$num_sent = eemail_send_mail($form['eemail_checked'], $form['eemail_subject_drop'], "commenter" );
				?>
				<div class="updated fade">
				<p>Email has been sent to <?php echo $num_sent; ?> user(s), and <?php echo count($recipients);?> recipient(s) were originally found.</p>
				</div>
				<?php
			}
	}
}
if ($eemail_error_found == TRUE && isset($eemail_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $eemail_errors[0]; ?></strong></p></div><?php
}
?>
<script language="javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/email-newsletter/sendemail/sendmail-setting.js"></script>
<div class="wrap">
  <div class="form-wrap">
    <div id="icon-plugins" class="icon32"></div>
    <h2><?php _e(WP_eemail_TITLE, 'email-newsletter'); ?> <?php _e('(Send email to commenter)', 'email-newsletter'); ?></h2>
	<h3><?php _e('Select email address from commentent authors list:', 'email-newsletter'); ?></h3>
	<div style="padding-bottom:14px;padding-top:5px;">
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=A,B,C">A, B, C</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=D,E,F">D, E, F</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=G,H,I">G, H, I</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=J,K,L">J, K, L</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=M,N,O">M, N, O</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=P,Q,R">P, Q, R</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=S,T,U">S, T, U</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=V,W,X,Y,Z">V, W, X, Y, Z</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=0,1,2,3,4,5,6,7,8,9">0 - 9</a>&nbsp;&nbsp;
		<a class="button add-new-h2" href="admin.php?page=sendmail-commenter&search=ALL">ALL</a>
	</div>
	<form name="form_eemail" method="post" action="#" onsubmit="return _send_email_submit()"  >
	<?php
	$sSql = "SELECT DISTINCT(comment_author_email) as user_email, `comment_author`,`comment_author_email` FROM ". $wpdb->prefix . "comments WHERE comment_author_email <> ''"; 
	if($search <> "")
	{
		if($search <> "ALL")
		{
			$array = explode(',', $search);
			$length = count($array);
			for ($i = 0; $i < $length; $i++) 
			{
				if(@$i == 0)
				{
					$sSql = $sSql . " and";
				}
				else
				{
					$sSql = $sSql . " or";
				}
				$sSql = $sSql . " comment_author_email LIKE '" . $array[$i]. "%'";
			}
		}
	}
	$sSql = $sSql . " ORDER BY comment_author_email";
	$data = $wpdb->get_results($sSql);
	$count = 0;
	if ( !empty($data) ) 
	{
		echo "<table border='0' cellspacing='0'><tr>";
		$col=3;
		foreach ( $data as $data )
		{
			$to = $data->user_email;
			if($to <> "")
			{
				echo "<td style='padding-top:4px;padding-bottom:4px;padding-right:10px;'>";
				?>
				<input class="radio" type="checkbox" checked="checked" value='<?php echo $to; ?>' name="eemail_checked[]">
				&nbsp;<?php echo $to; ?>
				<?php
				if($col > 1) 
				{
					$col=$col-1;
					echo "</td><td>"; 
				}
				elseif($col = 1)
				{
					$col=$col-1;
					echo "</td></tr><tr>";;
					$col=3;
				}
				$count = $count + 1;
			}
		}
		echo "</tr></table>";
	}
	else
	{
		$searchdisplay = "";
		if($search == "0,1,2,3,4,5,6,7,8,9")
		{
			$searchdisplay = "0 - 9";
		}
		else
		{
			$searchdisplay = $search;
		}
		_e($searchdisplay . ' - No email address available for this search result. Please click above buttons to search.', 'email-newsletter');
	}
	?>
	<div style="padding-top:14px;">
		<?php _e('Total emails:', 'email-newsletter'); ?> <?php echo $count; ?>
	</div>
	<div style="padding-top:14px;">
		<input class="button add-new-h2" type="hidden" name="send" value="true" />
		<input class="button add-new-h2" type="button" name="CheckAll" value="Check All" onClick="SetAllCheckBoxes('form_eemail', 'eemail_checked[]', true);">
		<input class="button add-new-h2" type="button" name="UnCheckAll" value="Uncheck All" onClick="SetAllCheckBoxes('form_eemail', 'eemail_checked[]', false);">
	</div>
	<?php
	$data = $wpdb->get_results("select eemail_id, eemail_subject  from ".WP_eemail_TABLE." where 1=1 and eemail_status='YES' order by eemail_id desc");
	if ( !empty($data) ) 
	{
		foreach ( $data as $data )
		{
			if($data->eemail_subject <> "")
			{
				@$eemail_subject_drop_val = @$eemail_subject_drop_val . '<option value="'.$data->eemail_id.'">' . stripcslashes($data->eemail_subject) . '</option>';
			}
		}
	}
	?>
	<h3><?php _e('Select email subject', 'email-newsletter'); ?></h3>
	<div>
		<select name="eemail_subject_drop" id="eemail_subject_drop">
			<option value=""><?php _e(' == Select Email Subject == ', 'email-newsletter'); ?></option>
			<?php echo $eemail_subject_drop_val; ?>
		</select>
	</div>
	<div style="padding-top:20px;">
	<input type="submit" name="Submit" class="button add-new-h2" value="<?php _e('Send Email', 'email-newsletter'); ?>" style="width:160px;" />&nbsp;&nbsp;
	<input name="publish" lang="publish" class="button add-new-h2" onclick="_eemail_redirect()" value="<?php _e('Cancel', 'email-newsletter'); ?>" type="button" />&nbsp;&nbsp;
    <input name="Help" lang="publish" class="button add-new-h2" onclick="_eemail_help()" value="<?php _e('Help', 'email-newsletter'); ?>" type="button" />
	</div>
	<?php wp_nonce_field('eemail_sendmail_commenter'); ?>
	<input type="hidden" name="eemail_sendmail_commenter" id="eemail_sendmail_commenter" value="yes"/>
	</form>
	</div>
	<?php include_once("steps.php"); ?>
  <p class="description"><?php echo WP_eemail_LINK; ?></p>
</div>