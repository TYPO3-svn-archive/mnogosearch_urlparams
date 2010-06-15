<?php 

class tx_mnogosearch_urlparams {
	
	/**
	 * Parses the URL, this function is called by the hook inside the mnogosearch extension
	 * 
	 * @access public
	 * @param array $a_params An array containing the parameters passed on by the parent class
	 * @param object $o_parent The parent object (tx_mnogosearch_model)
	 * return void All parameters are referenced
	 */
	public function parseUrl($a_params, $o_parent) {
		$s_url = $a_params['url'];
		$o_controller = $a_params['controller'];
		
		$a_parts = t3lib_div::trimExplode('/',$s_url,true);
		$i_parts = count($a_parts);
		if($i_parts == 4) {
			/**
			 * Confirm and fetch indexing configuration
			 */
			if (!isset($o_parent->indexConfigCache[$a_parts[2]])) {
				list($a_config) = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
						'tx_mnogosearch_table,tx_mnogosearch_url_parameters,tx_mnogosearch_display_pid',
						'tx_mnogosearch_indexconfig',
						'uid=' . intval($a_parts[2])
					);
				$this->indexConfigCache[$a_parts[2]] = $a_config;
			}
			else {
				$a_config = $o_parent->indexConfigCache[$a_parts[2]];
			}
			
			/**
			 * Confirm record/configuration integrity, fetch the record and replace
			 * all available fields.
			 */
			if ($a_config && $a_config['tx_mnogosearch_table'] == $a_parts[1]) {
				$a_linkConfig = array(
					'parameter' => $a_config['tx_mnogosearch_display_pid'],
				);
				if($a_config['tx_mnogosearch_url_parameters']) {
					$a_linkConfig['useCacheHash'] = true;
					
					$a_originalRecord  = $GLOBALS['TSFE']->sys_page->checkRecord($a_parts[1],$a_parts[3]);
					$a_matches = array();
					$a_replacements = array();
					foreach($a_originalRecord as $s_key => $s_value) {
						$a_matches[] = '{field:'.$s_key.'}';
						$a_replacements[] = $s_value;
					}
					$a_linkConfig['additionalParams'] = str_replace($a_matches, $a_replacements, $a_config['tx_mnogosearch_url_parameters']);
				}
				$s_url = rawurldecode($GLOBALS['TSFE']->cObj->typoLink_URL($a_linkConfig));
				// Ensure that URL is complete
				$s_url = t3lib_div::locationHeaderUrl($s_url);
			}
			$a_params['url'] = $s_url;
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mnogosearch_urlparams/class.tx_mnogosearch_urlparams.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mnogosearch_urlparams/class.tx_mnogosearch_urlparams.php']);
}
?>