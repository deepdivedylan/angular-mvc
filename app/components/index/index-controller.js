app.controller("IndexController", ["$scope", "TweetModel", function($scope, tweetModel) {
	$scope.editedTweet = null;
	$scope.isEditing = false;
	$scope.tweets = [];

	$scope.getTweets = function() {
		TweetModel.all()
			.then(function(result) {
				$scope.$apply(function () {
					$scope.tweets = result.data;
				});
			});
	};

	$scope.createTweet = function(tweet) {
		TweetModel.create(tweetModel)
			.then(function(result) {});
	};

	$scope.updateTweet = function(tweet) {
		TweetModel.update(tweet.tweetId, tweet)
			.then(function (result) {
				$scope.$apply(function() {
					$scope.cancelEditing();
					$scope.getTweets();
				});
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
		TweetModel.destroy(tweetId)
			.then(function(result) {
				$scope.$apply(function() {
					$scope.cancelEditing();
					$scope.getTweets();
				});
			});
	}
}]);