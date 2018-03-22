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
		$this->getOutput()->addModules( 'ext.gamification.foo' );
		$this->userGamificationProfileUser();
	}

	// Add this SpecialPage under the MediaWiki 'Others' category
	protected function getGroupName() {
		return 'other';
	}

	/**
	 * Back-end query and page build of a single user's gamification badges
	 */

	public function userGamificationProfileUser() {
		global $wgOut, $wgUser, $wgNASA_EVA_GamificationMaxNumberOfRanks;
		
		$wgOut->setPageTitle('User Gamification Profile');
		
		// Don't display anonymous or IP versions of the page
		if($wgUser->getId() == 0) { 
			$wgOut->addWikiMsg( 'gamification-notloggedin' );
			return true;
		}

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
		$html = "<b>" . "Username: " . "</b>" . $wgUser->getName() . "<br />";
		$html .= "<b>" . "Name: " . "</b>" . ($wgUser->getRealName() == "" ? "[Not Populated]" : $wgUser->getRealName()) . "<br />";
		$count = 0;
		
		// Get data from query while there are rows to be fetched
		for ($i = $wgNASA_EVA_GamificationMaxNumberOfRanks; $i > 0; $i--) {
			${'rank' . $i . 'Count'} = 0;
			${'rank' . $i . 'Array'} = array();
		}
		
		$badgeRankArray = array();
		while ($row = $dbr->fetchRow($res)) {
			${'rank' . str_replace("gamification-rank-", "", $row['badge_rank']) . 'Count'}++;
			${'rank' . str_replace("gamification-rank-", "", $row['badge_rank']) . 'Array'}[] = 
				wfMessage($row['badge_tag'])->escaped() . " - " . ($row['date_badge_earned'] == null ? "." : date_format(date_create($row['date_badge_earned']), "m/d/Y") . "<br />");
		}
		
		// Get and display badge data
		$html .= '<table class="wikitable"><tr>';
		for ($i = $wgNASA_EVA_GamificationMaxNumberOfRanks; $i > 0; $i--) {
			$html .= '<th><div class="ext-gamification-foo-rank-image ext-gamification-foo-rank-' . $i . '-image"></div>' . '</th>';
		}
		$html .= '</tr><tr>';
		for ($i = $wgNASA_EVA_GamificationMaxNumberOfRanks; $i > 0; $i--) {
			$html .= '<td>' . wfMessage('gamification-rank-' . $i)->escaped() . " - " . ${'rank' . $i . 'Count'} . '</td>';
		}
		$html .= '</tr><tr>';
		for ($i = $wgNASA_EVA_GamificationMaxNumberOfRanks; $i > 0; $i--) {
			$html .= '<td>';
			foreach (${'rank' . $i . 'Array'} as $rankarray) {
				$html .= $rankarray;
			}
			$html .= '</td>';
		}
		$html .= "</tr></table>";
		
		$wgOut->addWikiText( $html );
	}
}
