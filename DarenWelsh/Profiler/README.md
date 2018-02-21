# Profiler
An extension to MediaWiki providing a platform to measure and profile user activity

## GENERAL CONCEPT
*See also [Gamification Design Framework for a Wiki](FRAMEWORK.md)*

There are many ways we can measure and quantify each user's wiki activity including viewing, reviewing, revising, participation, contribution, recognition, interaction, and persistance. This project will build a platform that provides new database tables and mechanisms to record this meta data so as to not strain the MediaWiki core functionality. For example, [Extension:UserJourney](https://github.com/darenwelsh/UserJourney) can run a query on the revision table to determine a user's history and it will generate various reports based on the scope. But each query is large and puts a strain on the server. So this project, at its core, is to provide a way for gathering and querying this data without straining the server. Upon this platform, many approaches to profile and even gamify each user's participation in the wiki will be added. UserJourney already provides several examples to get us started.

With this platform, the data necessary to build profiles on each user will be available. See the profile details section below for ideas of what this will include. By building profiles on each user, we can better understand the different types of people participating in the wiki and what motivates them. Each type of person might be motivated by different features and feedback. For example, a competitor is motivated by points and leaderboards. A collector might be motivated by badges. A socializer might be motivated by features allowing users to share their work and discuss it.

One major feature that would be useful in different applications would be to make use of [Wiki Blame](https://en.wikipedia.org/wiki/Wikipedia:WikiBlame). Ideally this tool would be converted into an extension and this Profiler extension would have a dependency on that new WikiBlame extension. With this capability, users could identify who actually contributed the content that answered their question. They could then thank the author(s) for their contribution.

Another major feature to include would be the ability to calculate the "value" of each contribution based on multiple factors. For example, if a user adds some content that has numerous incoming links (pages that link to it) then it would seem that content is valuable to others. The score should increase if those links are made from different contributors. Otherwise one person could artificially inflate the score of their revision by adding links. Furthermore, value could be calculated by how often other users view and thank the author for this bit of content.

The first approach with [Extension:UserJourney] was to make use of hooks built into MediaWiki core. This provided instant feedback, but was limited in the details collected because the code to collect data on each action had to be created from scratch. This approach also did not make use of a wiki's history. So any point/badge/history system only had data from the time the extension was installed and activated. This is unfortunate for a wiki that has been functioning for years like Wikipedia. [Extension:UserJourney] was then completely restarted to instead make use of existing data in the database tables (like the revision table). While this method did not provide realtime feedback (like congratulating a user with points for editing a page), it did allow the use of all historical data for the wiki. This allows us to build a much more comprehensive profile of each user for any wiki that did not have this extension installed from the beginning. Ultimately, a system combining both of these approaches is probably best - to provide realtime feedback and to make use of all historical data from before the activation of this extension. For example, a maintenance script could be run in the background upon first installing and activating the extension. This maintenance script would parse through all the historical data in the wiki database to generate the historical data in the format used by this extension.

## REQUIREMENTS
1. Provide a MediaWiki database modification that allows for tracking these meta data and calculating metrics without significant strain on the server (MySQL or MariaDB).
1. Since MediaWiki core is written in PHP, it is highly desired for the bulk of this extension to be written in PHP. Javascript can be used for front-end things. Other languages and libraries are acceptable with the understanding that each new dependency (things that must be installed on the server for this extension to work) make it less likely to be adopted by the MediaWiki community. 
1. Provide clear documentation on how to install, configure, and use the extension. Include screenshots and animated GIFs.
1. Design and build the extension to make use of real-time events through the use of hooks for immediate feedback while also making use of the entire history of the wiki.
1. Documentation should include a list of events and the hooks used to drive those events
1. Allow for the wiki sysadmin to configure variables via a config PHP file
1. Support multiple wikis on a single server (see [meza](https://github.com/enterprisemediawiki/meza))

## PROFILE DETAILS
1. Date of first page viewed (and calculated number of days being a viewer)
1. Date of first revision (and calculated number of days being a contributor)
1. Number of unique pages viewed (ever, over all time)
1. Number of unique pages revised (ever, over all time)
1. List of categories of pages revised, in descending order by percentage of pages in that category that user revised (user revised 85% of pages in Category:Tool and 74% of pages in Category:Module)
1. List of "friends/colleagues" based on categories of pages that both users heavily contribute to, in descending order
1. Diversity = % of all pages user has edited; % of all categories user has edited
1. Analyze text added in revisions by person over time, determine colleagues by similar technical content words
1. Plot revs over time in one color, discussion page revs in another color
1. GitHub-like contribution visualization showing how much a user contributes each day
1. Streaks - how many (work) days in a row has the user contributed?
1. Pages I edit that others view the most
1. Other attributes like Diversity based on recent 3 months
1. User's score-view ratio (current value and plot over time)
1. Plot user activity and avg activity over time with std dev (box plot over time); compare before/after date (effect of change)
1. For user, unique page views per day, recent revisions for those pages, and number of thanks by user
1. Type cast ... revising size freq, num pages
1. 

## PAGE FEATURES
The data generated by this extension can also be used for each wiki page.
1. Page contributor diversity (over time) - plot showing how many people have contributed to the page as a function of time
1. Next page to revise suggestions 
1. History of page revisions/viewing/user diversity over time (initial surge followed by drought? )
1. 

## WIKI SPECIAL PAGE FEATURES
There could be a special page with details for the wiki as a whole.
1. Compare between wikis (eva/robo)
1. 
