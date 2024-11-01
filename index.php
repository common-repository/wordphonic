<?php

/**
 *	Plugin Name: Wordphonic
 *	Plugin URI: http://tracyfu.com/wordphonic
 *	Description: Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player!
 *	Version: 1.0.2
 *	Author: Tracy Fu
 */

/**
 *	Copyright 2008 Tracy Fu (email : wordphonic@tracyfu.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Determine Installation Path & URL
$path = basename(str_replace('\\','/',dirname(__FILE__)));
$info['siteurl'] = get_option('siteurl');
$info['install_url'] = $info['siteurl'] . '/wp-content/plugins';
$info['install_dir'] = ABSPATH . 'wp-content/plugins';
if ( $path != 'plugins' ) {
	$info['install_url'] .= '/' . $path;
	$info['install_dir'] .= '/' . $path;
}

// Path to PLAYLIST.XML
define('PLAYLIST_XML_PATH', "$info[install_dir]/playlist.xml");

// Debugging Output
define('DEBUG', false);

// Initialize Wordphonic
function install_wordphonic() {
	global $info;
	update_option('ephonic_init', '102');
	
	// Clean Up DB
	$playlist = array();
	
	// Transfer legacy playlist to new playlist
	for ( $i = 1; $i < 16; $i++ ) {
		if ( get_option('t' . $i) ) {
			if ( strlen(get_option('t' . $i)) > 1 ) {
				$playlist['default'][$i] = get_option('t' . $i);
			} else {
				$playlist['default'][$i] = array('artist' => '', 'title' => '', 'file' => '', 'image' => '');
			}
			delete_option('t' . $i);
		}
	}
	
	// Set demo playlist if none exists
	if ( count($playlist) < 1 ) {
		$playlist['default'][1] = array('artist' => 'E-Phonic', 
										'title'  => 'MP3 Player!',
										'file'   => "$info[install_url]/ephonic/mp3/demo.mp3",
										'image'  => "$info[install_url]/ephonic/mp3/demo.jpg");
		
		for ( $i = 2; $i < 36; $i++ ) {
			$playlist['default'][$i] = array('artist' => '', 'title' => '', 'file' => '', 'image' => '');
		}
	}
	
	update_option('ephonic_playlists', $playlist);
	
	// Set Defaults
	if ( !get_option('ephonic_skin') ) update_option('ephonic_skin', 'nobius_platinum');
	if ( !get_option('ephonic_autoplay') ) update_option('ephonic_autoplay', 0);
	if ( !get_option('ephonic_shuffle') ) update_option('ephonic_shuffle', 0);
	if ( !get_option('ephonic_repeat') ) update_option('ephonic_repeat', 1);
	if ( !get_option('ephonic_ephonic_buffer_time') ) update_option('ephonic_buffer_time', 1);
	if ( !get_option('ephonic_volume') ) update_option('ephonic_volume', 75);
	if ( !get_option('ephonic_mute') ) update_option('ephonic_mute', 0);
	if ( !get_option('ephonic_reg_key') ) update_option('ephonic_reg_key', "");
	
	// Write Playlist XML
	if ( file_get_contents(PLAYLIST_XML_PATH) == '' ) {
		write_playlist();
	}
}

// Write Playlist XML
function write_playlist() {
	$tracks_xml = '';
	$playlist   = get_option('ephonic_playlists');
	
	for ( $i = 1; $i < 36; $i++ ) {
		$track = $playlist['default'][$i];
		
		if ( $track['file'] != '' ) {
			$tracks_xml .= '<track>';
			$tracks_xml .= '<location><![CDATA[' . $track['file'] . ']]></location>';
			$tracks_xml .= '<title><![CDATA[' . $track['title'] . ']]></title>';
			$tracks_xml .= '<creator><![CDATA[' . $track['artist'] . ']]></creator>';
			$tracks_xml .= '<image><![CDATA[' . $track['image'] . ']]></image>';
			$tracks_xml .= '</track>';
		}
	}

	$playlist_xml = '<?xml version="1.0" encoding="UTF-8"?><playlist version="1" xmlns = "http://xspf.org/ns/0/"><trackList>' . $tracks_xml . '</trackList></playlist>';
	
	// Using 'fwrite' for PHP < 5 compatibility
	if ( is_writable(PLAYLIST_XML_PATH) ) {
		// TODO: Write logic in case file isn't writable
		if ( !$handle = fopen(PLAYLIST_XML_PATH, 'w') ) exit;
		if ( fwrite($handle, $playlist_xml) === FALSE ) exit;
		fclose($handle);
	}
	clearstatcache();
}

// First Run
if ( !get_option('ephonic_init') || get_option('ephonic_init') == 1 ) {
	add_action('init', 'install_wordphonic');
}

// Write 'swfobject' to Head
function write_js_to_head() {
	global $info;
	echo '<script src="' . $info['install_url'] . '/ephonic/swfobject.js" type="text/javascript"></script>';
}

add_action('admin_head', 'write_js_to_head');
add_action('wp_head', 'write_js_to_head');

// Add the Wordphonic Admin Panel
include_once($info['install_dir'] . '/options.php');

function add_admin_panel () {
	add_options_page('Wordphonic Plugin Options', 'Wordphonic', 7, 'index.php', 'create_admin_panel');
}

add_action('admin_menu', 'add_admin_panel');

// Write Playlist at Shutdown
add_action('shutdown', 'write_playlist');

?>