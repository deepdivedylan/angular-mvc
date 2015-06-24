<main class="container">
	<div class="row">
		<div class="col-md-4">
			<section ng-repeat="tweet in tweets">
				<p>
					{{ tweet.tweetContent }}<br />
					<em>{{ tweet.tweetDate | date: "medium" }}</em>
				</p>
			</section>
		</div>
		<div class="col-md-8">
			<form id="tweetForm" class="form-horizontal well" ng-submit="createTweet(newTweet);">
				<section class="form-group">
					<label for="profileId">Profile ID</label>
					<input type="number" name="profileId" id="profileId" class="form-control" min="1" step="1" ng-model="newTweet.profileId" />
				</section>
				<section class="form-group">
					<label for="tweetContent">Tweet Content</label>
					<input type="text" name="tweetContent" id="tweetContent" class="form-control" maxlength="140" ng-model="newTweet.tweetContent"/>
				</section>
				<section class="form-group">
					<label for="tweetDate">Tweet Date</label>
					<div class="dropdown">
						<a class="dropdown-toggle" id="tweetDateDropdown" role="button" data-toggle="dropdown" data-target="#">
							<div class="input-group">
								<input type="text" id="tweetDate" name="tweetDate" class="form-control" ng-model="newTweet.tweetDate">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
							<datetimepicker ng-model="newTweet.tweetDate"
											data-datetimepicker-config="{ dropdownSelector: '#tweetDateDropdown', minuteStep: 1 }">
							</datetimepicker>
						</ul>
					</div>
				</section>
				<button type="submit" class="btn btn-info btn-lg">Create</button>
			</form>
		</div>
	</div>
</main>