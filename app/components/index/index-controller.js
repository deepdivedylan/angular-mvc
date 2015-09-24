app.controller("IndexController", ["$scope", "$filter", "$modal", "$window", "TweetService", function($scope, $filter, $modal, $window, TweetService) {
	$scope.editedTweet = null;
	$scope.newTweet = null;
	$scope.isEditing = false;
	$scope.statusType = null;
	$scope.statusContent = null;
	$scope.showStatus = false;
	$scope.tweets = [];

	$scope.getTweets = function() {
		TweetService.all()
			.then(function(result) {
				$scope.tweets = result.data.data;
			});
	};

	$scope.createTweet = function(tweet, validated) {
		if(validated === true) {
			tweet.tweetDate = $filter("date")(tweet.tweetDate, "yyyy-MM-dd HH:mm:ss");
			TweetService.create(tweet)
				.then(function(result) {
					$scope.displayStatus(result.data);
				});
		}
	};

	$scope.updateTweet = function(tweet, validated) {
		if(validated === true) {
			tweet.tweetDate = $filter("date")(tweet.tweetDate, "yyyy-MM-dd HH:mm:ss");
			TweetService.update(tweet.tweetId, tweet)
				.then(function(result) {
					$scope.displayStatus(result.data);
					$scope.cancelEditing();
					$scope.getTweets();
				});
		}
	};

	$scope.setEditedTweet = function(tweet) {
		$window.scrollTo(0, 0);
		$scope.editedTweet = angular.copy(tweet);
		$scope.editedTweet.tweetDate = new Date($scope.editedTweet.tweetDate);
		$scope.isEditing = true;
	};

	$scope.cancelEditing = function() {
		$scope.editedTweet = null;
		$scope.isEditing = false;
	};

	$scope.deleteTweet = function(tweetId) {
    var message = "Do you really want to delete this tweet?";

    var modalHtml = '<div class="modal-body">' + message + '</div><div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

    var modalInstance = $modal.open({
      template: modalHtml,
      controller: ModalInstanceCtrl
    });

    modalInstance.result.then(function() {
			TweetService.destroy(tweetId)
				.then(function(result) {
					$scope.displayStatus(result.data);
					$scope.cancelEditing();
					$scope.getTweets();
				});
    });
  };

	$scope.initCreateForm = function() {
		$scope.newTweet = {profileId: "", tweetContent: "", tweetDate: new Date()};
	};

	$scope.disableStatus = function() {
		$scope.showStatus = false;
	};

	$scope.displayStatus = function(statusObject) {
		$scope.statusType = statusObject.status == 200 ? "alert-info" : "alert-danger";
		$scope.statusContent = statusObject.data;
		$scope.showStatus = true;
	};

	$scope.getTweets();
	$scope.initCreateForm();
}]);


var ModalInstanceCtrl = function($scope, $modalInstance) {
  $scope.yes = function() {
    $modalInstance.close();
  };

  $scope.no = function() {
    $modalInstance.dismiss('cancel');
  };
};
