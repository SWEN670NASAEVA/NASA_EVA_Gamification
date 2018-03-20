<?php
/**
 * UserGamificationProfile SpecialPage for NASA_EVA_Gamification extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialUserGamificationProfile extends SpecialPage {
	public function __construct() {
		parent::__construct( 'UserGamificationProfile' );
	}

	/**
	 * Show the page to the user
	 *
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:UserGamificationProfile/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->addWikiMsg( 'gamification-userprofile-intro' );

		// Change the display, based on the subpage toggle
		if( $sub == 'all') {
			$this->userGamificationProfileAll();
		} else {
			$this->userGamificationProfileUser();
		}

	}

	// Add this SpecialPage under the MediaWiki 'Others' category
	protected function getGroupName() {
		return 'other';
	}

	/**
	 * Backend query and page build of a single user's Gamification badges
	 */

	public function userGamificationProfileUser() {
		global $wgOut, $wgUser, $wgNASA_EVA_GamificationMaxNumberOfRanks;

		// Don't display anonymous or IP versions of the page
		if($wgUser->getId() == 0) { 
			$wgOut->addWikiMsg( 'gamification-notloggedin' );
			return true;
		}

		$wgOut->setPageTitle(' User Gamification Profile for '.$wgUser->getName());

		// Query against a read-only database, if configured
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'gamification_badges',
			array('badge_tag', 'badge_rank', 'date_badge_earned'),
			array('user_id' => $wgUser->getId()),
			__METHOD__,
			array('ORDER BY' => 'date_badge_earned DESC'),
			null
		);

		// Display user's Name and RealName
		$txt = $wgUser->getName()."<br>";
		$txt .= $wgUser->getRealName()."<br>";
		$count = 0;
		
		// Get data from query while there are rows to be fetched
		while ($row = $dbr->fetchRow($res)) {
			$text .= "The ".wfMessage($row['badge_rank'])->escaped().
				" level ".wfMessage($row['badge_tag'])->escaped()." badge was earned".
				($row['date_badge_earned']==null ? "." : " on ".$row['date_badge_earned'].".<br>");
			$count++;
		}
		$txt .= "You have earned ".$count." badge".($count == 1 ? "" : "s").".";
		if($count > 0) {
			$txt .= "  They are:<br>".$text;
		}
		
		$wgOut->addWikiText( $txt );

		$wgOut->addWikiText( 'Want to see [[Special:UserGamificationProfile/all|all]] badges earned?' );
	}

	/**
	  * Function will display all earned badges known to the system
	  */

	public function userGamificationProfileAll() {
		global $wgOut;

		$wgOut->setPageTitle( 'User Gamification Profiles ' );

		$html = '<table class="wikitable"><tr><th>User Name</th><th>Badge Tag</th><th>Badge Rank</th><th>Earned</th></tr>';

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array('gamification_badges','user'),
			array('user.user_name',
				'gamification_badges.badge_tag',
				'gamification_badges.badge_rank', 
				'gamification_badges.date_badge_earned'),
			'user.user_id = gamification_badges.user_id',
			__METHOD__,
			array('ORDER BY' => 'date_badge_earned'),
			null
		);

		while( $row = $dbr->fetchRow($res)) {
			list($name, $tag, $rank, $earned) = 
				array($row['user_name'], 
					wfMessage($row['badge_tag'])->escaped(), 
					wfMessage($row['badge_rank'])->escaped(), 
					($row['date_badge_earned']==null?"":wfTimestamp(TS_DB, $row['date_badge_earned'])));
			$html .= "<tr><td>$name</td><td>$tag</td><td>$rank</td><td>$earned</td></tr>";
		}		

		$html .= "</table>";

		$wgOut->addWikiText( $html );
	}
}
