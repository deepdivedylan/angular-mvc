app.controller("IndexController", ["$scope", "TweetModel", function($scope, tweetModel) {
	$scope.editedTweet = null;
	$scope.isEditing = false;
	$scope.tweets = [];

	$scope.getTweets = function() {
		tweetModel.all()
			.then(function(result) {
				$scope.tweets = result.data.data;
			});
	};

	$scope.createTweet = function(tweet) {
		tweetModel.create(tweetModel)
			.then(function(result) {});
	};

	$scope.updateTweet = function(tweet) {
		tweetModel.update(tweet.tweetId, tweet)
			.then(function (result) {
				$scope.cancelEditing();
				$scope.getTweets();
			});
	};

	$scope.setEditedTweet = function(tweet) {
		$scope.editedTweet = angular.copy(tweet);
		$scope.isEditing = true;
	};

	$scope.cancelEditing = function() {
		$scope.editedTweet = null;
		$scope.isEditing = false;
	};

	$scope.deleteTweet = function(tweetId) {
		tweetModel.destroy(tweetId)
			.then(function(result) {
				$scope.cancelEditing();
				$scope.getTweets();
			});
	};

	$scope.getTweets();
}]);