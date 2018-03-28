<?php
/**
 * Hooks for NASA_EVA_Gamification extension
 *
 * @file
 * @ingroup Extensions
 */

class NASA_EVA_GamificationHooks {
	/**
	 *  Add hook for validated email capture
	 *
	 *  @param User $user MediaWiki User object
	 */
	public static function onConfirmEmailComplete( $user ) {
		// Declare global variable from our extension.json file
		global $wgNASA_EVA_GamificationGamesToRankMapping;
		$rankHelper = $wgNASA_EVA_GamificationGamesToRankMapping["gamification-badge-emailverification"];

		// Always insert into DB_MASTER
        $dbw = wfGetDB(DB_MASTER);

        // Prepare the values to insert into gamification_badges table
        $arrayForDatabase[] = array(
            'user_id' => $user->getID(),
            'badge_tag' => 'gamification-badge-emailverification',
            'badge_rank' => $rankHelper,
            'date_badge_earned' => $dbw->timestamp()
        );

        $dbw->insert('gamification_badges',
            $arrayForDatabase,
            __METHOD__,
            'IGNORE'); // Ignore any duplicate key errors

		return true;
	}

	/**
	 *  Add hook for creating database objects
	 *
	 *  @param DatabaseUpdater $updater MediaWiki Updater object
	 */
	public static function onLoadExtensionSchemaUpdates( $updater ) {
		$updater->addExtensionTable( 'gamification_badges', 
			__DIR__ . '/sql/add_objects.sql' );
		return true;
	}
}
