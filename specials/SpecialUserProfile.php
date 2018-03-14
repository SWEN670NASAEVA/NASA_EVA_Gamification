<?php
/**
 * UserProfile SpecialPage for NASA_EVA_Gamification extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialUserProfile extends SpecialPage {
	public function __construct() {
		parent::__construct( 'UserProfile' );
	}

	/**
	 * Show the page to the user
	 *
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:UserProfile/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->addWikiMsg( 'gamification-userprofile-intro' );

		$out->addWikiText( 'Want to see [[Special:UserProfile/all|all]] badges earned?' );

		if( $sub == 'all') {
			$this->userProfileAll();
		} else {
			$this->userProfileUser();
		}

	}

	protected function getGroupName() {
		return 'other';
	}

	public function userProfileUser() {
		global $wgOut, $wgUser;
		
		$wgOut->setPageTitle(' User Gamification Profile for '.$wgUser->getName());

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'gamification_badges',
			array('badge_tag', 'badge_rank', 'date_badge_earned'),
			null,
			__METHOD__,
			array('ORDER BY' => 'date_badge_earned DESC'),
			null
		);
		$txt = $wgUser->getName()."<br>";
		$txt .= $wgUser->getRealName()."<br>";
		$count = 0;
		$text = "";
		
		while ($row = $dbr->fetchRow($res)) {
			$text .= "The ".$row['badge_rank'].
				" level ".$row['badge-tag']." badge was earned".
				($row['date_badge_earned']==null ? "." : " on ".$row['date_badge_earned'].".<br>");
			$count++;
		}
		$txt .= "You have earned ".$count." badge".($count == 1 ? "" : "s").".";
		if($count > 0) {
			$txt .= "  They are:<br>".$text;
		}
		
		$wgOut->addWikiText( $txt );
	}

	public function userProfileAll() {
		global $wgOut;

		$wgOut->setPageTitle( 'User Gamification Profiles ' );

		$html = '<table class="wikitable"><tr><th>User ID</th><th>Badge Tag</th><th>Badge Rank</th><th>Earned</th></tr>';

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
				array($row['user_name'], $row['badge_tag'], $row['badge_rank'], $row['date_badge_earned']);
			$html .= "<tr><td>$name</td><td>$tag</td><td>$rank</td><td>$earned</td></tr>";
		}		

		$html .= "</table>";

		$wgOut->addHTML( $html );
	}
}
