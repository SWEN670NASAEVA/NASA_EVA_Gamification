-- SQL Objects for NASA EVA Gamification extension


-- Examples from other extensions: 
-- Notes table 
--CREATE TABLE /*_*/example_note (
  -- Unique ID to identify each note
--  exnote_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  -- Foreign key to user.user_id
--  exnote_user int unsigned NOT NULL,
  -- Key to page.page_id.
--  exnote_page int unsigned NOT NULL,
  -- Note value as a string.
--  exnote_value blob
-- ); 
-- For querying of all notes from all users on a certain page 
-- (e.g. "Notes by other users" on a certain page). 
--CREATE INDEX /*i*/exnote_page_user ON /*_*/example_note (exnote_page, exnote_user);




--
-- Table structure for table gamification_badges
--

DROP TABLE IF EXISTS gamification_badges;
CREATE TABLE gamification_badges (
  user_id int(10) UNSIGNED NOT NULL,
  badge_tag varbinary(255) NOT NULL DEFAULT '',
  badge_rank varbinary(255) NOT NULL DEFAULT '',
  date_badge_earned varbinary(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=binary;

--
-- RELATIONSHIPS FOR TABLE gamification_badges:
--   user_id
--       user -> user_id
--
-- Indexes for table gamification_badges
--

ALTER TABLE gamification_badges
  ADD PRIMARY KEY (user_id,badge_tag,badge_rank),
  ADD KEY game_badge_search_idx (user_id,badge_tag,badge_rank) USING BTREE,
  ADD KEY gam_badge_user_idx (user_id) USING BTREE;

--
-- Constraints for table gamification_badges
--

ALTER TABLE gamification_badges
  ADD CONSTRAINT gamification_badges_ibfk_1 FOREIGN KEY (user_id) REFERENCES `user` (user_id) 
  ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

--
-- Populate the gamification_badges table with the email verification badge, if they already verified before the extention was loaded.
--

INSERT INTO gamification_badges (user_id, badge_tag, badge_rank)
SELECT user_id, 'gamification-badge-emailverification', 'gamification-rank-1'
FROM user
WHERE user_email_authenticated IS NOT NULL;
