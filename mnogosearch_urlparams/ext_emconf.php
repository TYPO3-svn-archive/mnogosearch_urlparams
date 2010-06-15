<?php

########################################################################
# Extension Manager/Repository config file for ext "mnogosearch_urlparams".
#
# Auto generated 15-06-2010 13:30
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'mnoGoSearch: URL Parameters',
	'description' => 'Allows parsing of all table field parameters inside the URL.',
	'category' => 'fe',
	'author' => 'Sebastiaan de Jonge (SebastiaanDeJonge.com)',
	'author_email' => 'szebi.eger@gmail.com',
	'shy' => '',
	'dependencies' => 'mnogosearch',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'mnogosearch' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:5:{s:9:"ChangeLog";s:4:"8fd4";s:10:"README.txt";s:4:"9fa9";s:34:"class.tx_mnogosearch_urlparams.php";s:4:"24f6";s:12:"ext_icon.gif";s:4:"8dff";s:17:"ext_localconf.php";s:4:"ba54";}',
	'suggests' => array(
	),
);

?>