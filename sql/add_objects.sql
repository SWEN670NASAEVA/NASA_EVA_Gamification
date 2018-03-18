-- SQL Objects for NASA EVA Gamification extension

--
-- Table structure for table gamification_badges
--

CREATE TABLE IF NOT EXISTS /*_*/ gamification_badges (
  user_id int(10) UNSIGNED NOT NULL,
  badge_tag varchar(255) NOT NULL DEFAULT '',
  badge_rank varchar(255) NOT NULL DEFAULT '',
  date_badge_earned binary(14) DEFAULT NULL,
  PRIMARY KEY(user_id, badge_tag, badge_rank)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

--
-- RELATIONSHIPS FOR TABLE gamification_badges:
--   user_id
--       user -> user_id
--
-- Indexes for table gamification_badges
--

--ALTER TABLE gamification_badges
--  ADD PRIMARY KEY (user_id,badge_tag,badge_rank),
--  ADD KEY game_badge_search_idx (user_id,badge_tag,badge_rank) USING BTREE,
--  ADD KEY gam_badge_user_idx (user_id) USING BTREE;

-- CREATE UNIQUE INDEX /*i*/gamification_badges_unique_idx ON /*_*/ gamification_badges(user_id, badge_tag, badge_rank);

--
-- Constraints for table gamification_badges
--

--ALTER TABLE /*_*/ gamification_badges 
--  ADD CONSTRAINT gamification_badges_ibfk_1 FOREIGN KEY (user_id) REFERENCES `user` (user_id) 
--  ON DELETE CASCADE ON UPDATE CASCADE;
--COMMIT;

--
-- Populate the gamification_badges table with the email verification badge, if they already verified before the extention was loaded.
--
INSERT IGNORE INTO gamification_badges (user_id, badge_tag, badge_rank)
  SELECT user_id, 'gamification-badge-emailverification', 'gamification-rank-1'
  FROM user
  WHERE user_email_authenticated IS NOT NULL
  ;
