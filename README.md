# NASA_EVA_Gamification

MediaWiki extension for gamification of wiki tasks, based on the requirements of NASA's Extravehicular Activities team.

## Installation

1. Obtain the code from [GitHub](https://github.com/SWEN670NASAEVA/NASA_EVA_Gamification)
2. Extract the files in a directory called ``NASA_EVA_Gamification`` in your ``extensions/`` folder.
3. Add the following code at the bottom of your "LocalSettings.php" file: `wfLoadExtension( 'NASA_EVA_Gamification' );`
4. From a shell prompt, run `php maintenance/update.php`
5. Go to "Special:Version" on your wiki to verify that the extension has successfully installed.
6. Done.

## Note
This extension was designed for MediaWiki 1.27 or later

## Config 
The extension uses default values to populate Badge names and Ranks.
```php
// Associative Array to map Games to their Ranking
$wgNASA_EVA_GamificationGamesToRankMapping = array(
			"gamification-badge-emailverification" => "gamification-rank-1"
);

// Maximum number of Ranks configured
$wgNASA_EVA_GamificationMaxNumberOfRanks = 3;
```