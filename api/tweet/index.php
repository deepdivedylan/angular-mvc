<?php
require_once(dirname(dirname(__DIR__)) . "/classes/autoload.php");
require_once(dirname(dirname(__DIR__)) . "/lib/xsrf.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the id
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/data-design/dmcdonald21.ini");

	// handle all RESTful calls to Tweet
	// get some or all Tweets
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($id) === false) {
			$reply->data = Tweet::getTweetByTweetId($pdo, $id);
		} else {
			$reply->data = Tweet::getAllTweets($pdo)->toArray();
		}
		// put to an existing Tweet
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$tweet = new Tweet($id, $requestObject->profileId, $requestObject->tweetContent, $requestObject->tweetDate);
		$tweet->update($pdo);
		$reply->data = "Tweet updated OK";
		// post to a new Tweet
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$tweet = new Tweet(null, $requestObject->profileId, $requestObject->tweetContent, $requestObject->tweetDate);
		$tweet->insert($pdo);
		$reply->data = "Tweet created OK";
	// delete an existing Tweet
	} else if($method === "DELETE") {
		verifyXsrf();
		$tweet = Tweet::getTweetByTweetId($pdo, $id);
		$tweet->delete($pdo);
		$reply->data = "Tweet deleted OK";
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);