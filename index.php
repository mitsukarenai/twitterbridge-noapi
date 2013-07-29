<?php
ini_set('user_agent', 'Mozilla/5.0 (X11; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0');
date_default_timezone_set('UTC');
//ini_set('display_errors','1');
//error_reporting(E_ALL);

function returnError($code, $message) {
 header("HTTP/1.1 $code");
 header('content-type: text/plain');
 die($message);
}

/*  Get PHP Simple HTML DOM Parser from:    http://simplehtmldom.sourceforge.net/    */
require_once('simple_html_dom.php');

if (isset($_GET['q'])) {   /* keyword search mode */
 $query = strip_tags($_GET['q']);
 $format = substr($query, 0, 4);
 $query = urlencode(substr($query, 5));
 $html = file_get_html("https://twitter.com/search/realtime?q=$query");
}

elseif (isset($_GET['u'])) {  /* user timeline mode */
 $query = strip_tags($_GET['u']);
 $format = substr($query, 0, 4);
 $query = substr($query, 5);
 $html = file_get_html("https://twitter.com/$query") or returnError('404 Not Found', 'ERROR: requested username can\'t be found');
}

else { returnError('403 Forbidden', 'ERROR: no query or username given'); }

foreach($html->find('div.tweet') as $tweet) {
    $item['username']	= trim(substr($tweet->find('span.username', 0)->plaintext, 1));								// extract username and sanitize
    $item['fullname']	= $tweet->getAttribute('data-name'); 											// extract fullname (pseudonym)
    $item['avatar']	= $tweet->find('img', 0)->src;												// get avatar link
    $item['id']		= $tweet->getAttribute('data-tweet-id');										// get TweetID
    $item['link']	= 'https://twitter.com'.$tweet->find('a.details', 0)->getAttribute('href');						// get tweet link
    $item['timestamp']	= $tweet->find('span._timestamp', 0)->getAttribute('data-time');							// extract tweet timestamp
    $item['text']	= str_replace('href="/', 'href="https://twitter.com/', strip_tags($tweet->find('p.tweet-text', 0)->innertext, '<a>'));	// extract tweet text
    $tweets[]	= $item;
}

if(empty($tweets)) { returnError('404 Not Found', 'ERROR: no result for this query'); } // useful if no results for search, or account with no tweets
if(!isset($_GET['format'])) {$_GET['format'] = '';}

if ($format == 'json') {$format='JSON';}		// nice JSON output
elseif ($format == 'atom') {$format='ATOM';}		// yummy ATOM output
else {$format='plaintext';}					// plaintext, default output

if($format == 'plaintext') { header('content-type: text/plain'); print_r($tweets); exit; }
if($format == 'JSON') { header('content-type: application/json'); $tweets = json_encode($tweets); exit($tweets); }

if($format == 'ATOM') {
header('content-type: application/atom+xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:thr="http://purl.org/syndication/thread/1.0" xml:lang="en-US">'."\n";
echo '<title type="text">Twitter / '.$query.'</title>'."\n";
echo '<id>http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '')."://{$_SERVER['HTTP_HOST']}{$_SERVER['PATH_INFO']}".'/</id>'."\n";
echo '<updated>'.date(DATE_ATOM, $tweets['0']['timestamp']).'</updated>'."\n";
echo '<link rel="alternate" type="text/html" href="https://twitter.com" />'."\n";
echo '<link rel="self" href="http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '')."://{$_SERVER['HTTP_HOST']}".htmlentities($_SERVER['REQUEST_URI']).'" />'."\n"."\n";

foreach($tweets as $entry) {
	echo '<entry><author><name>'.$entry['username'].'</name><uri>https://twitter.com/'.$entry['username'].'</uri></author>'."\n";
	echo '<title type="html"><![CDATA['.$entry['link'].']]></title>'."\n";
	echo '<link rel="alternate" type="text/html" href="'.$entry['link'].'" />'."\n";
	echo '<id>'.$entry['link'].'</id>'."\n";
	echo '<updated>'.date(DATE_ATOM, $entry['timestamp']).'</updated>'."\n";
	echo '<content type="html"><![CDATA[<a href="https://twitter.com/'.$entry['username'].'"><img align="top" alt="avatar" src="'.$entry['avatar'].'" />'.$entry['username'].'</a> '.$entry['fullname'].'<br/><blockquote>'.$entry['text'].'</blockquote>]]></content>'."\n";
	echo '</entry>'."\n\n";
	}
echo '</feed>';
exit;
}

?>
