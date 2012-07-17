<?php
/**
 *
 * @author TW1920 (Thomas Wolf) forum@twcmail.de
 * @version $Id$
 * @copyright (c) 2011 TW1920 &amp; TWCmail
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
$user->session_begin();
$auth->acl($user->data);
$user->setup();


if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'TWC - Star Mod';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'twcstarmod_version';


// The language file which will be included when installing
$language_file = 'mods/twcmod1';


/*
* Optionally we may specify our own logo image to show in the upper corner instead of the default logo.
* $phpbb_root_path will get prepended to the path specified
* Image height should be 50px to prevent cut-off or stretching.
*/
//$logo_img = 'styles/prosilver/imageset/site_logo.gif';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'1.0.0' => array(
		'table_add' => array(
			array('phpbb_star_rating', array(
				'COLUMNS' => array(
					'R_ID' => array('UINT:10', NULL, 'auto_increment'),
					'T_ID' => array('VCHAR:100', ''),
					'U_ID' => array('VCHAR:100', ''),
					'star' => array('INT:3', 0),
				),
				'PRIMARY_KEY'    => 'R_ID',
			)),
		),


		'table_column_add' => array(
			array('phpbb_topics', 'feed', array('VCHAR:100', '0')),
			array('phpbb_topics', 'star', array('VCHAR:100', '0')),
		),

	),
	
	'1.1.0'		=> array(),
	'1.1.1'		=> array(),
	'1.1.2'		=> array(),
	'1.1.3'		=> array(),	
);

// Include the UMIL Auto file, it handles the rest
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);
