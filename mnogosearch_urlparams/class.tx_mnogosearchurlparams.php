<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Sebastiaan de Jonge <szebi.eger@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *   44: class tx_mnogosearchurlparams
 *   55:     public function parseUrl($a_params, $o_parent)
 *
 * TOTAL FUNCTIONS: 1
 * (This index is automatically created/updated by the extension "extdeveval")
 */

/**
 * mnoGoSearch: URL Parameters
 *
 * @author Sebastiaan de Jonge <szebi.eger@gmail.com>
 * @package TYPO3
 * @subpackage tx_mnogosearchurlparams
 */
class tx_mnogosearchurlparams {
	/**
 * Parses the URL, this function is called by the hook inside the mnogosearch extension
 *
 * return void All parameters are referenced
 *
 * @param	array		$a_params An array containing the parameters passed on by the parent class
 * @param	object		$o_parent The parent object (tx_mnogosearch_model)
 * @return	[type]		...
 * @access public
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

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mnogosearch_urlparams/class.tx_mnogosearchurlparams.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mnogosearch_urlparams/class.tx_mnogosearchurlparams.php']);
}
?>