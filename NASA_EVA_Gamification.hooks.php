<?php
/**
 * Hooks for BoilerPlate extension
 *
 * @file
 * @ingroup Extensions
 */

class NASA_EVA_GamificationHooks {
    /**
     *  Add hook for email validated capture
     */
    public static function onConfirmEmailComplete( $user ) {
	wfDebugLog('NASA_EVA_Gamification', 'emailvalidated');
	wfDebug('NASA_EVA_Gamification - Someone called an email thing.');
      return true;
    }
}

