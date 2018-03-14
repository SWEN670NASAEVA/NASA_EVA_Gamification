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
//		global $wgOut;
		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'gamification-userprofile' ) );

//		$out->addHelpLink( 'How to become a MediaWiki hacker' );

		$out->addWikiMsg( 'gamification-userprofile-intro' );

//		$html = '<table class="wikitable"><tr><th>User ID</th><th>Badge Tag</th><th>Earned</th></tr>';

//		$dbr = wfGetDB( DB_SLAVE );
//		$res = $dbr->select(
//			'gamification_badges',
//			array('user_id', 'badge_tag', 'date_badge_earned'),
//			null,
//			__METHOD__,
//			array('ORDER BY' -> 'date_badge_earned ASC'),
//			null
//		);
//		while ($row = $dbr->fetchRow($res)) {
//			list($id, $tag, $earned) = array($row['user_id'], $row['badge_tag'], $row['date_badge_earned']);
//			html .= "<tr><td>$id</td><td>$tag</td><td>$earned</td></tr>";
//		}
//		html .= "</table>";
//
//		$wgOut->addHTML( $html );
	}

	protected function getGroupName() {
		return 'other';
	}
}
