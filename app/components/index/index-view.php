<main class="container">
	<section class="row">
		<div class="col-md-8">
			<table id="tweetTable" class="table table-bordered table-hover table-responsive table-striped">
				<tr>
					<th>Tweet Id</th><th>Profile Id</th><th>Tweet Content</th><th>Tweet Date</th><th>Actions</th>
				</tr>
				<tr ng-repeat="tweet in tweets">
					<td>{{ tweet.tweetId }}</td>
					<td>{{ tweet.profileId }}</td>
					<td>{{ tweet.tweetContent }}</td>
					<td>{{ tweet.tweetDate | date: "medium" }}</td>
					<td>
						<button class="btn btn-info" ng-click="setEditedTweet(tweet);"><i class="fa fa-pencil"></i></button>
						<form ng-submit="deleteTweet(tweet.tweetId);">
							<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
						</form>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-4">
			<form id="addTweetForm" class="form-horizontal well" ng-submit="createTweet(newTweet);" ng-hide="isEditing">
				<h2>Create Tweet</h2>
				<hr />
				<section class="form-group">
					<label for="addProfileId">Profile Id</label>
					<input type="number" name="addProfileId" id="addProfileId" class="form-control" min="1" step="1" ng-model="newTweet.profileId" />
				</section>
				<section class="form-group">
					<label for="addTweetContent">Tweet Content</label>
					<input type="text" name="addTweetContent" id="addTweetContent" class="form-control" maxlength="140" ng-model="newTweet.tweetContent"/>
				</section>
				<section class="form-group">
					<label for="addTweetDate">Tweet Date</label>
					<div class="dropdown">
						<a class="dropdown-toggle" id="addTweetDateDropdown" role="button" data-toggle="dropdown" data-target="#">
							<div class="input-group">
								<input type="text" id="addTweetDate" name="addTweetDate" class="form-control" ng-model="newTweet.tweetDate">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
							<datetimepicker ng-model="newTweet.tweetDate"
											data-datetimepicker-config="{ dropdownSelector: '#addTweetDateDropdown', minuteStep: 1 }">
							</datetimepicker>
						</ul>
					</div>
				</section>
				<button type="submit" class="btn btn-info btn-lg">Create</button>
			</form>
			<form id="editTweetForm" class="form-horizontal well" ng-submit="updateTweet(editedTweet);" ng-show="isEditing">
				<h2>Edit Tweet</h2>
				<hr />
				<section class="form-group">
					<label for="editProfileId">Profile Id</label>
					<input type="number" name="editProfileId" id="editProfileId" class="form-control" min="1" step="1" ng-model="editedTweet.profileId" />
				</section>
				<section class="form-group">
					<label for="editTweetContent">Tweet Content</label>
					<input type="text" name="editTweetContent" id="editTweetContent" class="form-control" maxlength="140" ng-model="editedTweet.tweetContent"/>
				</section>
				<section class="form-group">
					<label for="editTweetDate">Tweet Date</label>
					<div class="dropdown">
						<a class="dropdown-toggle" id="editTweetDateDropdown" role="button" data-toggle="dropdown" data-target="#">
							<div class="input-group">
								<input type="text" id="editTweetDate" name="editTweetDate" class="form-control" ng-model="editedTweet.tweetDate">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
							<datetimepicker ng-model="editedTweet.tweetDate"
											data-datetimepicker-config="{ dropdownSelector: '#editTweetDateDropdown', minuteStep: 1 }">
							</datetimepicker>
						</ul>
					</div>
				</section>
				<button type="submit" class="btn btn-info btn-lg">Save</button>
				<button class="btn btn-warning btn-lg" ng-click="cancelEditing();">Cancel</button>
			</form>
			<section id="tweetStatusBar" class="alert alert-dismissible" ng-class="statusType" ng-show="showStatus" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="disableStatus();"><span aria-hidden="true">&times;</span></button>
				{{ statusContent }}
			</section>
		</div>
	</section>
</main>
