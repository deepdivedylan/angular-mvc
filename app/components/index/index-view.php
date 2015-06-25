<main class="container">
	<section class="row">
		<div class="col-md-8">
			<table class="table table-bordered table-condensed table-hover table-responsive table-striped">
				<tr>
					<th>Tweet Id</th><th>Profile Id</th><th>Tweet Content</th><th>Tweet Date</th><th>Actions</th>
				</tr>
				<tr ng-repeat="tweet in tweets">
					<td>{{ tweet.tweetId }}</td>
					<td>{{ tweet.profileId }}</td>
					<td>{{ tweet.tweetContent }}</td>
					<td>{{ tweet.tweetDate | date: "medium" }}</td>
					<td><button class="btn btn-info"><i class="fa fa-pencil"></i></button>&nbsp;<button class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
				</tr>
			</table>
		</div>
		<div class="col-md-4">
			<form id="tweetForm" class="form-horizontal well" ng-submit="createTweet(newTweet);">
				<h2>Create Tweet</h2>
				<hr />
				<section class="form-group">
					<label for="profileId">Profile Id</label>
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
	</section>
</main>