<?php

/**
 *
 * SAML authentication for EnterpriseMediaWiki mezawiki landing page, very much
 * based upon MediaWiki Extension:SimpleSamlAuth and using SimpleSamlPhp. It is
 * almost a copy/paste of Extension:SimpleSamlAuth in order to reuse config for
 * both MediaWiki and the landing page.
 *
 * @license http://www.gnu.org/licenses/lgpl.html LGPL (GNU Lesser General Public License)
 * @copyright (C) 2016, James Montalvo
 * @author James Montalvo
 */

// Define some settings which are configured in SimpleSamlAuth.php for MediaWiki
// and which we need to fake here.
define( 'SAML_OPTIONAL', 0 );
define( 'SAML_LOGIN_ONLY', 1 );
define( 'SAML_REQUIRED', 2 );
define( 'MEDIAWIKI', 1 );
$wgSamlConfirmMail = false;

// get SAML config, shared with MediaWiki extension SimpleSamlAuth
require_once '/opt/.deploy-meza/SAMLConfig.php';

// This class is basically a pared down version of SimpleSamlAuth.class.php, an
// extension for MediaWiki. This allows the landing page to use the same config
// options as the MW extension, minimizing duplication. To be even more DRY, we
// could extend the SimpleSamlAuth class, but that is not possible with the 0.6
// version. A patch should be submitted to make "private" methods and variables
// "protected" instead.
//
// See file in /opt/htdocs/mediawiki/extensions/SimpleSamlAuth
class NonMediaWikiSimpleSamlAuth {

	/** SAML Assertion Service */
	protected static $as;
	/** Whether $as is initialised */
	private static $initialised;

	/**
	 * Construct a new object and register it in $wgHooks.
	 * See README.md for possible values in $config.
	 *
	 * @param $config mixed[] Configuration settings for the SimpleSamlAuth extension.
	 *
	 * @return boolean
	 */
	private static function init() {
		global $wgSamlSspRoot;
		global $wgSamlAuthSource;
		global $wgSessionName;
		global $wgSessionsInMemcached;
		global $wgSessionsInObjectCache;
		if ( self::$initialised ) {
			return true;
		}
		if ( ( !isset( $wgSessionName ) || !$wgSessionName )
			&& ( !isset( $wgSessionsInObjectCache ) || !$wgSessionsInObjectCache )
			&& ( !isset( $wgSessionsInMemcached ) || !$wgSessionsInMemcached )
		) {
			$wgSessionName = ini_get( 'session.name' );
		}
		// Load the simpleSamlPhp service
		require_once rtrim( $wgSamlSspRoot, DIRECTORY_SEPARATOR ) .
			DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . '_autoload.php';
		self::$as = new SimpleSAML\Auth\Simple( $wgSamlAuthSource );
		self::$initialised = is_object( self::$as );
		return self::$initialised;
	}


	public static function nonMediaWikiLoadSession() {
		if ( !self::init() ) {
			return true;
		}
		global $wgSamlRequirement;
		global $wgSamlUsernameAttr;
		global $wgBlockDisablesLogin;
		global $wgContLang;

		self::$as->requireAuth();

		if ( self::$as->isAuthenticated() ) {
			$attr = self::$as->getAttributes();
		}
		else {
			$attr = false;
		}
		// Not authenticated, but no errors either
		// Return means success, $result is still false
		return $attr;
	}

}

NonMediaWikiSimpleSamlAuth::nonMediaWikiLoadSession();
