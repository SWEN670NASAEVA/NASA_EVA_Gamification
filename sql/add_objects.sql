-- SQL Objects for NASA EVA Gamification extension

--
-- Table structure for table gamification_badges
--

CREATE TABLE IF NOT EXISTS /*_*/ gamification_badges (
  user_id int(10) UNSIGNED NOT NULL,
  badge_tag varchar(255) NOT NULL,
  badge_rank varchar(255) NOT NULL,
  date_badge_earned binary(14) DEFAULT NULL,
  PRIMARY KEY(user_id, badge_tag, badge_rank)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Populate the gamification_badges table with the email verification badge, if they already verified before the extention was loaded
--

INSERT IGNORE INTO gamification_badges (user_id, badge_tag, badge_rank)
  SELECT user_id, 'gamification-badge-emailverification', 'gamification-rank-1'
  FROM user
  WHERE user_email_authenticated IS NOT NULL;