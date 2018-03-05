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
	wfDebugLog('NASA_EVA_Gamification', 'in emailvalidated');
	wfDebug('NASA_EVA_Gamification - '.$user.' did a validation thing.');
      return true;
    }
}

