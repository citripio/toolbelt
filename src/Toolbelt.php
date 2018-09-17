<?php 
namespace Citripio;

class Toolbelt {

	public function __construct() {
		
	}

	// 
	// Safely include specific GET params on redirects, for tracking
	// 
	function include_utms($url) {
		if (
			isset($_GET["utm_source"]) || 
			isset($_GET["utm_campaign"]) || 
			isset($_GET["utm_medium"]) || 
			isset($_GET["utm_term"]) || 
			isset($_GET["utm_content"])
		) {
			$query = parse_url($url, PHP_URL_QUERY);
			$utm_source = $_GET["utm_source"];
			$utm_campaign = $_GET["utm_campaign"];
			$utm_medium = $_GET["utm_medium"];
			$utm_term = $_GET["utm_term"];
			$utm_content = $_GET["utm_content"];

			// Returns a string if the URL has parameters or NULL if not
			if ($query) {
				$result = "$url&utm_source=$utm_source&utm_campaign=$utm_campaign&utm_medium=$utm_medium&utm_term=$utm_term&utm_content=$utm_content";
			} else {
				$result = "$url?utm_source=$utm_source&utm_campaign=$utm_campaign&utm_medium=$utm_medium&utm_term=$utm_term&utm_content=$utm_content";
			}
			return $result;
		}
		else {
			return $url;
		}
	}

	function retrieve_saved_timestamp_for_content_id($clist, $id){
		$timestamp = null;
		foreach ($clist as $key => $list) {
			if ($list["id"] == $id) {
				$timestamp = $list["timestamp"];
				return $timestamp;
			}
		}
		return $timestamp;
	}

	function save_user_token_and_session_in_cookies() {
		// 
		// Cookies are saved at /nuevo to avoid showing a subscription modal 
		// when the user navigates to /leer in case it's using a new and 
		// previously unknown device
		// 
		$cookie_name = "fbMessengerBotRegistered";
		$cookie_value = "true";
		// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie($cookie_name, $cookie_value, 0, "/"); // Will expire at the end of the session
		$cookie_name_2 = "fbMessengerBotUserToken";
		$cookie_value_2 = $_GET["utoken"];
		// setcookie($cookie_name_2, $cookie_value_2, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie($cookie_name_2, $cookie_value_2, 0, "/"); // Will expire at the end of the session
	}

	function save_content_list_timestamps_in_cookies($content_list) {
		$listcontents = array();
		foreach ($content_list as $content) {
			$date = $content["created_at_timestamp"];
			array_push($listcontents, array("id" => $content["id"], "timestamp" => $date));
		}
		// setcookie("listcontents", serialize($listcontents), time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie("listcontents", serialize($listcontents), 0, "/"); // Will expire at the end of the session
		// 
		// Return the same array to be used when cookies are still not available for reading
		// 
		return $listcontents;
	}

	// 
	// For OG image paths
	// 
	function generate_content_md5($content_id) {
		return md5("hola".$content_id."manolas");
	}

	// 
	// Content part getters
	// 
	function get_verse_code($content) {
		$verse_code = null;
		preg_match('/<verse_code>(.*?)<\/verse_code>/s', html_entity_decode($content), $verse_code);
		return $verse_code[1];
	}

	function get_verse($content) {
		$verse_code = null;
		preg_match('/<verse>(.*?)<\/verse>/s', html_entity_decode($content), $verse_code);
		return $verse_code[1];
	}

	function get_explanation($content) {
		$verse_code = null;
		preg_match('/<explanation>(.*?)<\/explanation>/s', html_entity_decode($content), $verse_code);
		return $verse_code[1];
	}

	function get_prayer_intro($content) {
		$verse_code = null;
		preg_match('/<pray_intro>(.*?)<\/pray_intro>/s', html_entity_decode($content), $verse_code);
		return $verse_code[1];
	}

	function get_prayer($content) {
		$verse_code = null;
		preg_match('/<prayer>(.*?)<\/prayer>/s', html_entity_decode($content), $verse_code);
		return $verse_code[1];
	}


	// 
	// Performs a substr() that doesn't cut words, and appends "..." 
	// 
	function substring_words($content, $length) {
		$result = null;
		if ($length > 0) {
			if (preg_match('/^.{1,'. $length .'}\b/s', $content, $match)) {
				$line = $match[0];
				$result = $line;
				if (
					strlen($content) > $length && 
					substr($line, -1) != '.' && 
					substr($line, -1) != ',' ) {
						$result = $result . '...';
				}
			}
			else {
				$result = $content;
			}
		}
		else {
			$result = $content;
		}
		return $result;
	}
}
?>
