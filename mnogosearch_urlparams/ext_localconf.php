<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['mnogosearch']['preProcessURL'][] = 'EXT:mnogosearch_urlparams/class.tx_mnogosearchurlparams.php:&tx_mnogosearchurlparams->parseUrl';
?>