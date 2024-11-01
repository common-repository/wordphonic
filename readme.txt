=== Wordphonic ===
Contributors: tracyfu
Donate link: http://tracyfu.com/wordphonic/#download
Tags: playlist, music, player, flash, mp3, mp3 player
Requires at least: 2.3
Tested up to: 2.5
Stable tag: trunk

Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player.

== Description ==

Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player. Manage custom settings, add your playlist and sample a live preview directly within the Wordphonic admin panel!

== Installation ==

Please follow these instructions to install Wordphonic:

1. Download the zipped plugin.
2. Unzip the archive and upload the 'wordphonic' folder to your WordPress Plugins folder (/wp-content/plugins/).
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to your Wordphonic Admin Panel (Options > Wordphonic) to get started!

Enjoi.

== Frequently Asked Questions ==

= Where do I place the code? =

You can paste the code in any template or post, provided that your theme contains the 'wp_head();' hook within the document head.

= The player isn't showing up. I'm getting an error asking me to upgrade my Flash Player, but I know Flash is properly installed. What do I do? =

1. If you pasted the code into a post, make sure you pasted it into the 'Code' view.
2. Or, if the error occurred after you pasted the code into a post, and later returned to edit the post, try re-pasting the code.

= The player is giving me the error 'Error Loading MP3'. What do I do? =

When in doubt, use absolute paths to your MP3s when listing MP3 Locations in the admin panel. Relative paths are local to your WordPress blog, not your WordPress installation.

= How can I add more than one player on a page? =

For each new player you want to add, change the following code:

1. Change the 'id' in the first line '<div id="flashcontent">' to another unique id. This can be anything, but it must start with a letter and can contain only alphanumeric characters, '-' and '_'.

2. Change the 'id' in the line 'so.write("flashcontent");' to the same id you chose in step 1.

Also, remember to save out separate playlists. You'll need to write some XML on your own for that and then make sure your script points to that file.

= How do I remove the default scrolling text that says "E-PHONIC MP3-PLAYER - GET YOUR OWN FREE SKINNABLE MP3-PLAYER AT WWW.E-PHONIC.COM/MP3PLAYER?" =

1. Depending on which skin you used, navigate to that folder location on your server. It will be something like "/wordpress/wp-content/plugins/wordphonic/ephonic/skins/nobius_platinum/."

2. Open up skin.xml in any text editor.

3. You will see the line '<display id="SONGINFO" width="166" height="8" x="88" y="58" font="TEXT" defaultText="E-PHONIC MP3-PLAYER - GET YOUR OWN FREE SKINNABLE MP3-PLAYER AT WWW.E-PHONIC.COM/MP3PLAYER"></display>' (line 24).

4. Edit the defaultText attribute in that line. When testing your change, remember to clear your browser cache.

== History ==

* Version 1.0.2
	* Update: Increased playlist length to 35 tracks
	* Update: Changed the data being written to the database for future support of multiple playlists
* Version 1.0.1
	* Bug: Fixed a pathing issue to playlist.xml that prevented the file from being written to correctly
* Version 1.0.0
	* Initial Release!