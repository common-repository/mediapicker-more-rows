=== Mediapicker More Rows ===
Contributors: codepress, tschutter
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZDZRSYLQ4Z76J
Tags: admin, attachments, items, media library, more, plugins, popup, rows, wordpress
Requires at least: 3.1
Tested up to: 3.4
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Add more rows to the Mediapicker!

By default the mediapicker only displays 10 items per page. With this plugin you can set your own maximum items per page. Now you can have as many results per page as you like.

= Translations = 

If you like to contrinute a language, please send them to <a href="mailto:info@codepress.nl">info@codepress.nl</a>.

* German (de_DE) - Thanks to <a href="http://www.iq137.de">robotect</a>
* Spanish (es_ES) - Thanks to <a href="http://rodbuaiz.com/">Rodolfo Buaiz</a>
* Brazilian Portuguese (pt_BR) - Thanks to <a href="http://rodbuaiz.com/">Rodolfo Buaiz</a>

== Installation ==

1. Upload codepress-mediapicker-limit to the /wp-content/plugins/ directory
2. Activate Mediapicker Items Limit through the 'Plugins' menu in WordPress
3. Go to the Media settings under the Settings menu.
4. Fill in the maximum number of items to display (per page) in the Mediapicker section.

== Frequently Asked Questions ==

= Can I change the default value? =

Yes, if you want to set a different default value in your theme functions.php you can use:

`
<?php
add_filter('cp_mediapicker_limit', 'my_mediapicker_limit');
function my_mediapicker_limit () {
	return 20; // set your own number of items
}
?>
`

= How did this plugin came about? =

This plugin came forth from a post on stackexchange where someone asked if it was possible to add more rows to the media picker. This plugin is my answer to that question. Initial props goes to Brasofilo.

Full answer: http://wordpress.stackexchange.com/questions/33775/add-more-rows-on-media-picker

== Screenshots ==

1. Settings page
2. Mediapicker popup with extra items

== Changelog ==

= 0.3 =

* Fixed bug with pagination
* Added Spanish and Brazilian Portuguese languages (thanks to Rodolfo Buaiz )

= 0.2 =

* Added German language (thanks to robotect )

= 0.1 =

* Initial release.