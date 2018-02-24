<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'NASA_EVA_Gamification' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['NASA_EVA_Gamification'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['NASA_EVA_GamificationAlias'] = __DIR__ . '/NASA_EVA_Gamification.i18n.alias.php';
	wfWarn(
		'Deprecated PHP entry point used for NASA_EVA_Gamification extension. Please use wfLoadExtension ' .
		'instead, see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return true;
} else {
	die( 'This version of the NASA_EVA_Gamification extension requires MediaWiki 1.25+' );
}
