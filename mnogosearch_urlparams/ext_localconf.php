<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['mnogosearch']['preProcessURL'][] = 'EXT:mnogosearch_urlparams/class.tx_mnogosearch_urlparams.php:&tx_mnogosearch_urlparams->parseUrl';
?>