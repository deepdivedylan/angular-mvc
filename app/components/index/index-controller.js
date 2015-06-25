app.controller("IndexController", ["$scope", "$filter", "TweetModel", function($scope, $filter, tweetModel) {
	$scope.editedTweet = null;
	$scope.newTweet = null;
	$scope.isEditing = false;
	$scope.tweets = [];

	$scope.getTweets = function() {
		tweetModel.all()
			.then(function(result) {
				$scope.tweets = result.data.data;
			});
	};

	$scope.createTweet = function(tweet) {
		tweet.tweetDate = $filter("date")(tweet.tweetDate, "yyyy-MM-dd HH:mm:ss");
		tweetModel.create(tweet)
			.then(function(result) {
				console.log(result.data);
			});
	};

	$scope.updateTweet = function(tweet) {
		tweet.tweetDate = $filter("date")(tweet.tweetDate, "yyyy-MM-dd HH:mm:ss");
		tweetModel.update(tweet.tweetId, tweet)
			.then(function (result) {
				$scope.cancelEditing();
				$scope.getTweets();
			});
	};

	$scope.setEditedTweet = function(tweet) {
		$scope.editedTweet = angular.copy(tweet);
		$scope.editedTweet.tweetDate = new Date($scope.editedTweet.tweetDate);
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

	$scope.initCreateForm = function() {
		$scope.newTweet = {profileId: "", tweetContent: "", tweetDate: new Date()};
	};

	$scope.getTweets();
	$scope.initCreateForm();
}]);