app.controller("TweetController", ["$routeParams", "$scope", "TweetService", function($routeParams, $scope, TweetService) {
	$scope.tweet = null;

	$scope.fetchTweet = function() {
		TweetService.fetch($routeParams.id)
			.then(function(tweet) {
				$scope.tweet = tweet.data.data;
		});
	};

	$scope.fetchTweet();
}]);