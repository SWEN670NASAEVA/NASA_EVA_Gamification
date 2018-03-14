<?php
/**
 * Hooks for NASA_EVA_Gamification extension
 *
 * @file
 * @ingroup Extensions
 */

class NASA_EVA_GamificationHooks {
	/**
	  *  Add hook for email validated capture
	  */
	public static function onConfirmEmailComplete( $user ) {
		$arrayForDatabase[] = array(
			'user_id' => $user->getID(),
			'badge_tag' => 'gamification-badge-emailverification',
			'badge_rank' => 'gamification-rank-1',
			'date_badge_earned' => wfTimestamp(TS_MW)
		);
		$dbw = wfGetDB(DB_MASTER);
		$dbw->insert('gamification_badges',
			$arrayForDatabase,
			__METHOD__,
			'IGNORE');
		if( $dbw->affectedRows()==1 ) {
// Notify the user somehow that they earned a new badge?
			wfDebug('NASA EVA - new badge earned');
		}
		return true;
	}


	/**
	  *  Add hook for creating database objects
	  */
	public static function onLoadExtensionSchemaUpdates( $updater ) {
		$updater->addExtensionTable( 'dummy', 
			__DIR__ . '/sql/add_objects.sql' );
		return true;
	}
}

