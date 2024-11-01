<?php

/**
 * Save the Flash script to a variable.
 *
 */
 
function write_flash_script($output = 'script') {
	// Init Vars
	global $info;
	switch ( get_option(ephonic_skin) ) {
		case 'alien_green':
			$xw = 220;
			$xh = 265;
			$xc = '#000';
			break;
		case 'microplayer':
			$xw = 301;
			$xh = 16;
			$xc = '#FFF';
			break;
		case 'nobius_blue':
			$xw = 269;
			$xh = 226;
			$xc = '#FFF';
			break;
		default:
			$xw = 269;
			$xh = 226;
			$xc = '#000';
	}
	
	$x1 = get_option('ephonic_skin');
	if ( get_option('ephonic_autoplay') ) $x2 = 'true'; else $x2 = 'false';
	if ( get_option('ephonic_shuffle') )  $x3 = 'true'; else $x3 = 'false';
	if ( get_option('ephonic_repeat') )   $x4 = 'true'; else $x4 = 'false';
	$x5 = get_option('ephonic_buffer_time');
	$x6 = get_option('ephonic_volume');
	if ( get_option('ephonic_mute') )     $x7 = 'true'; else $x7 = 'false';
	if ( get_option('ephonic_reg_key') != '' ) {
		$x8 = get_option('ephonic_reg_key');
	} else {
		$x8 = '';
	}
	
	$x9 = rand(1, 100);

$fs = <<<FS
<div id="flashcontent$x9">
	To use the <a href="http://www.e-phonic.com/mp3player/" target="_blank" title="E-Phonic MP3 Player">E-Phonic MP3 Player</a> you will need <a href="http://www.adobe.com/products/flashplayer/" target="_blank" title="Adobe Flash Player 9">Adobe Flash Player 9</a> or better and a Javascript enabled browser.
</div>
<script type="text/javascript">
	// <![CDATA[
	var so = new SWFObject("$info[install_url]/ephonic/ep_player.swf", "ep_player$x9", "$xw", "$xh", "9", "$xc");
	so.addVariable("skin", "$info[install_url]/ephonic/skins/$x1/skin.xml");
	so.addVariable("playlist", "$info[install_url]/playlist.xml");
	so.addVariable("autoplay", "$x2");
	so.addVariable("shuffle", "$x3");
	so.addVariable("repeat", "$x4");
	so.addVariable("buffertime", "$x5");
	so.addVariable("volume", "$x6");
	so.addVariable("mute", "$x7");
	so.addVariable("key", "$x8");
	so.write("flashcontent$x9");
	// ]]>
</script>
FS;

	if ( $output == 'string' ) {
		echo htmlentities($fs, ENT_QUOTES);
	} else {
		echo $fs;
	}
}

/**
 * Create the Wordphonic Admin Panel
 *
 */

function create_admin_panel() {
	global $info;

?>
	<style type="text/css" media="screen">
		#wordphonic form { margin: 0; padding: 0; }
		#wordphonic legend { margin: 20px 0 0; padding: 0; }
		
		#ephonic-options { position: relative; }
		#ephonic-options div { width: 48%; height: 24px; margin: 6px 0; line-height: 24px; vertical-align: middle; }
		#ephonic-options label { cursor: default; }
		#ephonic-options input, #ephonic-options select { position: absolute; left: 100px; margin: 0; }
		#ephonic-options input.text { text-align: right; }
		#ephonic-options input.checkbox { margin: 5px 0; }
		#ephonic-options span.fieldnote { position: absolute; left: 145px; }
		#ephonic-options span.register { position: absolute; left: 360px; }
		
		#ephonic-player { float: right; }
		#ephonic-player div { float: right; width: 310px; margin: 0; text-align: right; }
		
		#ephonic-playlist table { width: 100%; margin: 10px 0; }
		#ephonic-playlist td { text-align: center; }
		#ephonic-playlist td.index { width: 30px; text-align: right; }
		#ephonic-playlist td input { width: 96%; *width: 220px; }
		
		#ephonic-script textarea { width: 99%; *width: 600px; color: #14568A; }
	</style>
	<?php if ( DEBUG ) require_once($info['install_dir'] . '/debug.php'); ?>
	<div id="wordphonic" class="wrap">
		<h2>Wordphonic</h2>
		<p>Howdy. For technical support, check out the <a href="<?php echo $info['install_url']; ?>/readme.txt" title="Wordphonic ReadMe" target="_blank">readme</a> 
			or visit Wordphonic&#8217;s <a href="http://tracyfu.com/wordphonic/#install" title="Wordphonic's Online Docs" target="_blank">online documentation</a>. To send 
			feedback, <a href="mailto:wordphonic@tracyfu.com" title="Talk to me!">email me</a>!</p>
		
		<div id="ephonic-options">
			<fieldset class="options"><legend>E-Phonic MP3 Player Options</legend>
				<p>Click &#8220;Update Options&#8221; to refresh the preview player.</p>
				<div id="ephonic-player">
					<?php write_flash_script(); ?>
				</div>
				<form method="post" action="options.php">
				<?php wp_nonce_field('update-options'); ?>
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="ephonic_skin,ephonic_autoplay,ephonic_shuffle,ephonic_repeat,ephonic_buffer_time,ephonic_volume,ephonic_mute,ephonic_reg_key" />

				<div>
					<label for="skin">Skin</label>
					<select name="ephonic_skin">
						<option value="alien_green"<?php if ( get_option('ephonic_skin') == 'alien_green' ) echo ' SELECTED'; ?>>Alien Green</option>
						<option value="micro_player"<?php if ( get_option('ephonic_skin') == 'micro_player' ) echo ' SELECTED'; ?>>Micro Player</option>
						<option value="nobius_blue"<?php if ( get_option('ephonic_skin') == 'nobius_blue' ) echo ' SELECTED'; ?>>Nobius Blue</option>
						<option value="nobius_platinum"<?php if ( get_option('ephonic_skin') == 'nobius_platinum' ) echo ' SELECTED'; ?>>Nobius Platinum</option>
					</select>
				</div>
				<div><label for="autoplay">Autoplay</label><input type="checkbox" class="checkbox" name="ephonic_autoplay" <?php if ( get_option('ephonic_autoplay') ) echo 'CHECKED '; ?>/></div>
				<div><label for="shuffle">Shuffle</label><input type="checkbox" class="checkbox" name="ephonic_shuffle" <?php if ( get_option('ephonic_shuffle') ) echo 'CHECKED '; ?>/></div>
				<div><label for="repeat">Repeat</label><input type="checkbox" class="checkbox" name="ephonic_repeat" <?php if ( get_option('ephonic_repeat') ) echo 'CHECKED '; ?>/></div>
				<div><label for="buffer_time">Buffer Time</label><input type="text" class="text" size="3" maxlength="3" align="right" name="ephonic_buffer_time" value="<?php echo get_option('ephonic_buffer_time'); ?>" /><span class="fieldnote">seconds</span></div>
				<div><label for="volume">Volume</label><input type="text" size="3" class="text" maxlength="3" name="ephonic_volume" value="<?php echo get_option('ephonic_volume'); ?>" /><span class="fieldnote">%</span></div>
				<div><label for="mute">Mute</label><input type="checkbox" class="checkbox" name="ephonic_mute" <?php if ( get_option('ephonic_mute') ) echo 'CHECKED '; ?>/></div>
				<div>
					<label for="reg_key">Reg Key</label><input type="text" size="30" name="ephonic_reg_key" value="<?php echo get_option('ephonic_reg_key'); ?>" />
					<?php if ( get_option('ephonic_reg_key') == "" ) { ?><span class="register"><a href="http://www.e-phonic.com/mp3player/register/" target="_blank" title="Register E-Phonic Now!">Register Now!</a></span><?php } ?>
				</div>
				<div class="submit"><input type="submit" name="submit" value="<?php _e('Update Options È'); ?>" /></div>
				
				</form>
			</fieldset>
		</div>
		
		<div id="ephonic-playlist">
			<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="ephonic_playlists" />
			
			<fieldset class="options"><legend>The Playlist</legend>
				<p>Add your tracks.</p>
				<div class="submit"><input type="submit" name="submit" value="<?php _e('Update Playlist È'); ?>" /></div>
				<table border="0" cellpadding="0" cellspacing="5">
				<tr>
					<th></th>
					<th>Artist</th>
					<th>Title</th>
					<th>MP3 Location</th>
					<th>Image Location</th>
				</tr>
				<?php
				
				$playlist = get_option('ephonic_playlists');
				
				for ( $i = 1; $i < 36; $i++ ) {
					$track = $playlist['default'][$i];

				?>
				<tr>
					<td class="index"><?php echo $i; ?></td>
					<td class="artist"><input type="text" name="ephonic_playlists[default][<?php echo $i; ?>][artist]" value="<?php echo $track['artist']; ?>" /></td>
					<td class="title"><input type="text" name="ephonic_playlists[default][<?php echo $i; ?>][title]" value="<?php echo $track['title']; ?>" /></td>
					<td class="mp3"><input type="text" name="ephonic_playlists[default][<?php echo $i; ?>][file]" value="<?php echo $track['file']; ?>" /></td>
					<td class="image"><input type="text" name="ephonic_playlists[default][<?php echo $i; ?>][image]" value="<?php echo $track['image']; ?>" /></td>
				</tr>
				<?php } ?>
				</table>
				<div class="submit"><input type="submit" name="submit" value="<?php _e('Update Playlist È'); ?>" /></div>
			</fieldset>
			
			</form>
		</div>
		
		<div id="ephonic-script">
			<fieldset class="options"><legend>The Script</legend>
				<p>Paste this script into your page where you want the player to show up.</p>
				<textarea rows="22" onclick="this.select()"><?php write_flash_script('string'); ?></textarea>
			</fieldset>
		</div>
	</div>
<?php } ?>