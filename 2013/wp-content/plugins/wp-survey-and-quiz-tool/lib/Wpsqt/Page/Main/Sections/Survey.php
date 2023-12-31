<?php

require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Sections.php';

	/**
	 * Handles survey sections management.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Sections_Survey extends Wpsqt_Page_Main_Sections {

	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		$this->_pageView = "admin/surveys/sections.php";		
		$this->_doSections();
				
	}
	
}