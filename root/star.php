<?php
/**
*
* @package TWCbb-Addon - phpBB Pioneer Edition for Olympus
* @author TW1920 (Thomas Wolf) forum@twcmail.de
* @version $Id: star.php 9470 2011-02-08 19:52:41Z  $
* @copyright (c) 2011 TWCmail
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/**
* @ignore
*/
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('viewforum');

// Add TWC_Lang1
$user->add_lang('mods/twcmod1');

//Definieren der nicht vorhandenen Variablen
$topic = request_var('t', 'int' );
$u_id = $user->data['user_id'];
if (isset($_GET['star']))
{
	$give_star = request_var('star', 'int' );
}

//Überprüfen ob es sich um eine Bewertung oder Bewertungsanfrage handelt
if (isset($_GET['star']) and $give_star <= 5)  
{
	//Zählen ob User Thema bereits bewertet hat
	$sql = "SELECT COUNT(*) AS anzahl
		FROM " . STAR_RATING_TABLE . "
		WHERE T_ID = " . (int) $topic . " AND U_ID = " . (int) $u_id; 

	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result)) 
	{
		$many = $row['anzahl'];
	}

	//Entscheiden ob Nutzer noch bewerten dar und gespeichert werden soll oder warnmeldung an nutzer kommenb soll
	if ($many == 1) 
	{
		// Output page
		page_header($user->lang['INDEX']);
		$template->assign_vars(array(
			'BW_SAVE'            => sprintf($user->lang['T_BEWERTET_V'])
		));

		$template->set_filenames(array(
			'body' => 'twc_bw_nopup.html',
		));

		page_footer();
	}
	
	//Bewertung speichern
	else 
	{
		//Auslesen der alten Werte
		$sql = "SELECT star, feed
			FROM " . TOPICS_TABLE . "
			WHERE topic_id = " . (int) $topic; 

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result)) 
		{
			//Berechnen der neuen werte
			$calcstar = $give_star;
			$feedcalc = $row['feed'];
			$starcalc = $row['star'];
			$calcfeed = 1;

			$star = $starcalc+$calcstar;
			$feed = $calcfeed+$feedcalc;

			//Speichern der neuen Werte

			$sql = "UPDATE " . TOPICS_TABLE . "
				SET star = " . (int) $star . "
				WHERE topic_id = " . (int) $topic;
			$db->sql_query($sql);

			$sql = "UPDATE " . TOPICS_TABLE . "
				SET feed = " . (int) $feed . "
				WHERE topic_id = " . (int) $topic;
			$db->sql_query($sql);

			$sql = "INSERT INTO " . STAR_RATING_TABLE . " (R_ID, T_ID, U_ID, star)
				VALUES (
					NULL, " . (int) $topic . "," . (int) $u_id . "," . (int) $calcstar . ")";
			$db->sql_query($sql);

			$db->sql_transaction('commit');
		}

		// Output page
		page_header($user->lang['INDEX']);

		$template->assign_vars(array(
			'BW_SAVE'			=> sprintf($user->lang['T_BEWERTET_J'])
		));

		// Output page
		page_header($user->lang['INDEX']);

		$template->set_filenames(array(
			'body' => 'twc_bw_repup.html',
		));

		page_footer();
	}
}

//Anzeigen der Bewertungsauswahl
else 
{
	// Output page
	page_header($user->lang['INDEX']);

	$template->assign_vars(array(
		'L_EINS'			=> append_sid("{$phpbb_root_path}star.$phpEx", 'star=1&amp;t='.$topic),
		'L_ZWEI'			=> append_sid("{$phpbb_root_path}star.$phpEx", 'star=2&amp;t='.$topic),
		'L_DREI'			=> append_sid("{$phpbb_root_path}star.$phpEx", 'star=3&amp;t='.$topic),
		'L_VIER'			=> append_sid("{$phpbb_root_path}star.$phpEx", 'star=4&amp;t='.$topic),
		'L_FUENF'			=> append_sid("{$phpbb_root_path}star.$phpEx", 'star=5&amp;t='.$topic),
		'BW_TOPIC'            => sprintf($topic),
	));

	$template->set_filenames(array(
		'body' => 'twc_bw_popup.html',
	));

	page_footer();
}

?>