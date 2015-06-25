app.constant("TWEET_ENDPOINT", "api/tweet/json/");
app.service("TweetModel", function($http, TWEET_ENDPOINT) {
	function getUrl() {
		return(TWEET_ENDPOINT);
	}

	function getUrlForId(tweetId) {
		return(getUrl() + tweetId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(tweetId) {
		return($http.get(getUrlForId(tweetId)));
	};

	this.create = function(tweet) {
		return($http.post(getUrl(), tweet));
	};

	this.update = function(tweetId, tweet) {
		return($http.post(getUrlForId(tweetId), tweet));
	};

	this.destroy = function(tweetId) {
		return($http.delete(getUrlForId(tweetId)));
	};
});