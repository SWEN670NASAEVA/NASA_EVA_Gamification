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


-- Dummy table to prove we got here
CREATE TABLE dummy (dummykey int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT);

