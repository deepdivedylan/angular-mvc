var app = angular.module("AngularMVC", ["ngRoute", "ngSanitize"]);

app.config(function($routeProvider) {
	$routeProvider
		.when("/", {
			controller: "IndexController",
			templateUrl: "app/components/index/index-view.php"
		})
		.when("/tweet/:id", {
		controller: "TweetController",
		templateUrl: "app/components/tweet/tweet-view.php"
		})
		.otherwise({
			redirectTo: "/"
	});
});