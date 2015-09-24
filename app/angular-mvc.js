var app = angular.module("AngularMVC", ["ngMessages","ngRoute", "ngSanitize", "ui.bootstrap", "ui.bootstrap.datetimepicker"]);

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
