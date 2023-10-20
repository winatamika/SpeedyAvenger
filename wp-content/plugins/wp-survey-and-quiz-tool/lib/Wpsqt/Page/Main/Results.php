<?php

/**
 * Handles displaying the results for quizzes and surveys.
 * 
 * 
 * @author Iain Cambridge
 * @copyright Fubra Limited 2010-2011, all rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
 * @package WPSQT
 */
class Wpsqt_Page_Main_Results extends Wpsqt_Page {
	
	public function process(){
		
		global $wpdb;
		
		if ( !isset($_GET['id']) ){
			// do some redirection here.
			// TODO add redirect function in code.
		}
		if ( isset($_GET['marked']) && $_GET['marked'] == "true" ){
			$this->_pageVars['message'] = "Result successfully marked!";
		}	
		if ( isset($_GET['deleted']) && $_GET['deleted'] == "true" ){
			$this->_pageVars['message'] = "Result successfully deleted!";
		}

		if (isset($_GET['orderby'])) {
			$orderby = $_GET['orderby'];
		} else {
			$orderby = 'ID';
		}

		if (isset($_GET['order'])) {
			$order = $_GET['order'];
		} else {
			$order = 'DESC';
		}

		$sql_filter_where = "";
		$range_from = 0;
		$range_until = strtotime("now");

		if ( isset($_POST['range_submit']) ){
			$range_from = ($_POST['range_from']=="") ? strtotime( date("Y")."-".date("m")."-".(date("d")-1) ) : strtotime($_POST['range_from']);
			$range_until = ($_POST['range_until']=="") ? strtotime( date("Y-m-d") ) : strtotime($_POST['range_until']);
			$sql_filter_where = "AND datetaken>=". $range_from ." AND datetaken<=".$range_until;
		}
		//echo $sql_filter_where;
		//echo $filter_from ."--". $filter_until;

		$unviewed = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d ".$sql_filter_where." 
						                 AND LCASE(status) = 'unviewed'
						                 ORDER BY $orderby $order" 
										, array($_GET['id']) )	, ARRAY_A	
										);
		$accepted = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d ".$sql_filter_where." 
						                 AND LCASE(status) = 'accepted'
						                 ORDER BY $orderby $order" 
										, array($_GET['id']))	, ARRAY_A	
										);
		$rejected = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d ".$sql_filter_where." 
						                 AND LCASE(status) = 'rejected'
						                 ORDER BY $orderby $order" 
										, array($_GET['id']))	, ARRAY_A	
										);

		$rawFormFields = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_FORMS."` 
						                 WHERE item_id = %d 
						                 ORDER BY ID ASC" 
										, array($_GET['id']) )	, ARRAY_A	
										);

		if ( !isset($_GET['status']) || !isset(${$_GET['status']}) ) {								
			$rawResults = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d ".$sql_filter_where." 
						                 ORDER BY $orderby $order" 
										, array($_GET['id']))	, ARRAY_A	
										);
		} else {
			$rawResults = ${$_GET['status']};
		}

		$formFields = array();
		foreach ($rawFormFields as $rawFormField) {
			$formFields[] = $rawFormField['name'];
		}

		$itemsPerPage = get_option('wpsqt_number_of_items');
		$currentPage = Wpsqt_Core::getCurrentPageNumber();	
		$startNumber = ( ($currentPage - 1) * $itemsPerPage );
		
		$this->_pageVars['results'] = array_slice($rawResults , $startNumber , $itemsPerPage );
		$this->_pageVars['counts'] = array('unviewed_count' => sizeof($unviewed), 
										   'accepted_count' => sizeof($accepted),
										   'rejected_count' => sizeof($rejected));
		$this->_pageVars['numberOfPages'] = Wpsqt_Core::getPaginationCount(sizeof($rawResults), $itemsPerPage);
		$this->_pageVars['currentPage'] = Wpsqt_Core::getCurrentPageNumber();
		$this->_pageVars['formFields'] = $formFields;
		$this->_pageVars['_range'] = array('range_from'=>$range_from, 'range_until'=>$range_until);
		return false;
		
	}
	
}