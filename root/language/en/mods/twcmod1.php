<?php
/**
*
* @author Thomas Wolf - http://TWCmail.de/
*
* TWCstar [English]
*
* @package language
* @version $Id: twcmod1.php, V0.1.6 2011-02-08 18:08:26 TW1920 $
* @copyright (c) 2011 TWCmail
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

// Bot settings
$lang = array_merge($lang, array(
	'T_BEWERTET_V' 		=> 'Topic <br /><br /> always <br /><br /> rated.',
	'T_BEWERTET_J' 		=> 'Rating <br /><br /> saved.',
	'RATING'	=> 'Rating',
	'GIVE_RATING' 		=> 'Give Rating',
	'NOTONLINE'	=> 'For rating please login',
));

?>