<?php
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// if the token does not exist, create one and send it in a cookie
if(empty($_SESSION["XSRF-TOKEN"]) === true) {
	$_SESSION["XSRF-TOKEN"] = hash("sha512", session_id() . openssl_random_pseudo_bytes(16));
	setcookie("XSRF-TOKEN", $_SESSION["XSRF-TOKEN"]);
}

// prepare an empty reply
$format = "json";
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

/**
 * verifies the X-XSRF-TOKEN sent by Angular matches the XSRF-TOKEN saved in this session.
 * This function returns nothing, but will throw an exception when something does not match
 *
 * @see https://code.angularjs.org/1.3.16/docs/api/ng/service/$http Angular $http service
 * @throws InvalidArgumentException when tokens do not match
 **/
function verifyXsrf() {
	$headers = apache_request_headers();
	if(array_key_exists("X-XSRF-TOKEN", $headers) === false) {
		throw(new InvalidArgumentException("invalid XSRF token", 401));
	}
	$angularHeader = $headers["X-XSRF-TOKEN"];
	$correctHeader = $_SESSION["XSRF-TOKEN"];
	if($angularHeader !== $correctHeader) {
		throw(new InvalidArgumentException("invalid XSRF token", 401));
	}
}

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the class, id, and format
	$validFormats = array("html", "json", "xml");
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$class = filter_input(INPUT_GET, "class", FILTER_SANITIZE_STRING);
	$format = filter_input(INPUT_GET, "format", FILTER_SANITIZE_STRING);
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

	// handle all RESTful calls to Tweet
	if($class === "tweet") {
		// get some or all Tweets
		if($method === "GET") {
			if(empty($id) === false) {
				$reply->data = Tweet::getTweetByTweetId($pdo, $id);
			} else {
				$reply->data = Tweet::getAllTweets($pdo)->toArray();
			}
		// post to an existing Tweet
		} else if($method === "POST") {
			verifyXsrf();
			$tweet = Tweet::getTweetByTweetId($pdo, $id);
			if(empty($_POST["profileId"]) === true || empty($_POST["tweetContent"]) === true || empty($_POST["tweetDate"]) === true) {
				throw(new InvalidArgumentException("tweet fields incomplete or missing"));
			}
			$tweet->setProfileId($_POST["profileId"]);
			$tweet->setTweetContent($_POST["tweetContent"]);
			$tweet->setTweetDate($_POST["tweetDate"]);
			$tweet->update($pdo);
			$reply->data = "Tweet updated OK";
		// delete an existing Tweet
		} else if($method === "DELETE") {
			verifyXsrf();
			$tweet = Tweet::getTweetByTweetId($pdo, $id);
			$tweet->delete($pdo);
			$reply->data = "Tweet deleted OK";
		}
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->data = $exception->getMessage();
}

if($format === "json") {
	header("Content-type: application/json");
	echo json_encode($reply);
} else if($format === "html") {
	echo "HTML format selected";
} else if($format === "xml") {
	echo "XML format selected";
}