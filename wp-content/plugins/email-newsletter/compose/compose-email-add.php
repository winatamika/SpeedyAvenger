<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$eemail_errors = array();
$eemail_success = '';
$eemail_error_found = FALSE;

// Preset the form fields
$form = array(
	'eemail_subject' => '',
	'eemail_content' => '',
	'eemail_status' => '',
	'eemail_date' => ''
);

// Form submitted, check the data
if (isset($_POST['eemail_form_submit']) && $_POST['eemail_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('eemail_form_add');
	
	$form['eemail_subject'] = isset($_POST['eemail_subject']) ? $_POST['eemail_subject'] : '';
	if ($form['eemail_subject'] == '')
	{
		$eemail_errors[] = __('Please enter email subject.', 'email-newsletter');
		$eemail_error_found = TRUE;
	}

	$form['eemail_content'] = isset($_POST['eemail_content']) ? $_POST['eemail_content'] : '';
	$form['eemail_status'] = isset($_POST['eemail_status']) ? $_POST['eemail_status'] : '';

	//	No errors found, we can add this Group to the table
	if ($eemail_error_found == FALSE)
	{
		$cur_date = date('Y-m-d G:i:s'); 
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_eemail_TABLE."`
			(`eemail_subject`,`eemail_content`, `eemail_status`, `eemail_date`)
			VALUES(%s, %s, %s, %s)",
			array($form['eemail_subject'], $form['eemail_content'], $form['eemail_status'], $cur_date)
		);
		$wpdb->query($sql);
		
		$eemail_success = __('Email was successfully created.', 'email-newsletter');
		
		// Reset the form fields
		$form = array(
			'eemail_subject' => '',
			'eemail_content' => '',
			'eemail_status' => '',
			'eemail_date' => ''
		);
	}
}

if ($eemail_error_found == TRUE && isset($eemail_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $eemail_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($eemail_error_found == FALSE && strlen($eemail_success) > 0)
{
	?>
	  <div class="updated fade">
		<p><strong><?php echo $eemail_success; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=compose-email"><?php _e('Click here', 'email-newsletter'); ?></a><?php _e(' to view the details', 'email-newsletter'); ?></strong></p>
	  </div>
	  <?php
	}
?>
<script language="javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/email-newsletter/compose/compose-email-setting.js"></script>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(WP_eemail_TITLE, 'email-newsletter'); ?></h2>
	<form name="eemail_form" method="post" action="#" onsubmit="return _eemail_submit()"  >
      <h3><?php _e('Compose email', 'email-newsletter'); ?></h3>
      <label for="tag-image"><?php _e('Enter email subject.', 'email-newsletter'); ?></label>
      <input name="eemail_subject" type="text" id="eemail_subject" value="" size="90" />
      <p><?php _e('Please enter your email subject.', 'email-newsletter'); ?></p>
	  <label for="tag-link"><?php _e('Enter email content', 'email-newsletter'); ?></label>
      <textarea name="eemail_content" cols="140" rows="25" id="eemail_content"></textarea>
      <p><?php _e('This page is where you write, save your email messages. We can add HTML content.', 'email-newsletter'); ?></p>
      <label for="tag-display-status"><?php _e('Display status', 'email-newsletter'); ?></label>
      <select name="eemail_status" id="eemail_status">
        <option value=''><?php _e('Select', 'email-newsletter'); ?></option>
		<option value='YES'>Yes</option>
        <option value='NO'>No</option>
      </select>
	  <p><?php _e('Do you want to show this email in Send Mail admin pages?.', 'email-newsletter'); ?></p>
      <input name="eemail_id" id="eemail_id" type="hidden" value="">
      <input type="hidden" name="eemail_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'email-newsletter'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_eemail_redirect()" value="<?php _e('Cancel', 'email-newsletter'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_eemail_help()" value="<?php _e('Help', 'email-newsletter'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('eemail_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo WP_eemail_LINK; ?></p>
</div>