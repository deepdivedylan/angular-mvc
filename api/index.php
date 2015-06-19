<?php
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// prepare an empty reply
$reply = new stdClass();
$reply->status = 0;
$reply->data = null;

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	switch($method) {
		case "DELETE":
		case "POST":
			$inputMethod = INPUT_POST;
			break;
		case "GET":
		case "PUT":
			$inputMethod = INPUT_GET;
			break;
		default:
			throw(new RuntimeException("invalid HTTP method", 405));
	}

	// sanitize the class, id, and format
	$validFormats = array("html", "json", "xml");
	$id = filter_input($inputMethod, "id", FILTER_VALIDATE_INT);
	$class = filter_input($inputMethod, "class", FILTER_SANITIZE_STRING);
	$format = filter_input($inputMethod, "format", FILTER_SANITIZE_STRING);
	if(empty($class) === true) {
		throw(new InvalidArgumentException("invalid class", 405));
	}
	if(in_array($format, $validFormats) === false) {
		throw(new InvalidArgumentException("invalid format", 405));
	}
	if(($method === "DELETE" || $method === "POST") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/data-design/dmcdonald21.ini");

	if($class === "tweet") {
		if($method === "GET") {
			if(empty($id) === false) {
				$tweet = Tweet::getTweetByTweetId($pdo, $id);
			}
		}
	}


} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->data = $exception->getMessage();
	var_dump($reply);
}
