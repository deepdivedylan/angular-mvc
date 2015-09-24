<main class="container">
	<section class="row">
		<div class="col-md-4">
			<form name="addTweetForm" id="addTweetForm" class="form-horizontal well" ng-submit="createTweet(newTweet, addTweetForm.$valid);" ng-hide="isEditing" novalidate>
				<h2>Create Tweet</h2>
				<hr />
				<div class="form-group" ng-class="{ 'has-error': addTweetForm.addProfileId.$touched && addTweetForm.addProfileId.$invalid }">
					<label for="addProfileId">Profile Id</label>
					<input type="number" name="addProfileId" id="addProfileId" class="form-control" min="1" step="1" ng-model="newTweet.profileId" ng-pattern="/^\d+$/" ng-required="true" />
					<div class="alert alert-danger" role="alert" ng-messages="addTweetForm.addProfileId.$error" ng-if="addTweetForm.addProfileId.$touched" ng-hide="addTweetForm.addProfileId.$valid">
						<p ng-message="required">Profile id is required.</p>
						<p ng-message="pattern">Profile id must be a positive integer.</p>
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': addTweetForm.addTweetContent.$touched && addTweetForm.addTweetContent.$invalid }">
					<label for="addTweetContent">Tweet Content</label>
					<input type="text" name="addTweetContent" id="addTweetContent" class="form-control" maxlength="140" ng-model="newTweet.tweetContent" ng-minlength="1" ng-maxlength="140" ng-required="true" />
					<div class="alert alert-danger" role="alert" ng-messages="addTweetForm.addTweetContent.$error" ng-if="addTweetForm.addTweetContent.$touched" ng-hide="addTweetForm.addTweetContent.$valid">
						<p ng-message="required">Tweet content is required.</p>
						<p ng-message="minlength">Tweet content cannot be empty.</p>
						<p ng-message="maxlength">Tweet content is too long.</p>
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': addTweetForm.addTweetDate.$touched && addTweetForm.addTweetDate.$invalid }">
					<label for="addTweetDate">Tweet Date</label>
					<div class="dropdown">
						<a class="dropdown-toggle" id="addTweetDateDropdown" role="button" data-toggle="dropdown" data-target="#">
							<div class="input-group">
								<input type="text" id="addTweetDate" name="addTweetDate" class="form-control" ng-model="newTweet.tweetDate" />
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="addTweetDateDropdown">
							<datetimepicker data-ng-model="newTweet.tweetDate" data-datetimepicker-config="{ dropdownSelector: '#addTweetDateDropdown', minuteStep: 1 }">
							</datetimepicker>
						</ul>
					</div>
				</div>
				<button type="submit" class="btn btn-info btn-lg" ng-disabled="addTweetForm.$invalid"><i class="fa fa-twitter"></i> Create</button>
			</form>
			<form name="editTweetForm" id="editTweetForm" class="form-horizontal well" ng-submit="updateTweet(editedTweet, editTweetForm.$valid);" ng-show="isEditing" novalidate>
				<h2>Edit Tweet</h2>
				<hr />
				<div class="form-group" ng-class="{ 'has-error': editTweetForm.editProfileId.$touched && editTweetForm.editProfileId.$invalid }">
					<label for="editProfileId">Profile Id</label>
					<input type="number" name="editProfileId" id="editProfileId" class="form-control" min="1" step="1" ng-model="editedTweet.profileId" ng-pattern="/^\d+$/" ng-required="true" />
					<div class="alert alert-danger" role="alert" ng-messages="editTweetForm.editProfileId.$error" ng-if="editTweetForm.editProfileId.$touched" ng-hide="editTweetForm.editProfileId.$valid">
						<p ng-message="required">Profile id is required.</p>
						<p ng-message="pattern">Profile id must be a positive integer.</p>
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': editTweetForm.editTweetContent.$touched && editTweetForm.editTweetContent.$invalid }">
					<label for="editTweetContent">Tweet Content</label>
					<input type="text" name="editTweetContent" id="editTweetContent" class="form-control" maxlength="140" ng-model="editedTweet.tweetContent" ng-minlength="1" ng-maxlength="140" ng-required="true" />
					<div class="alert alert-danger" role="alert" ng-messages="editTweetForm.editTweetContent.$error" ng-if="editTweetForm.editTweetContent.$touched" ng-hide="editTweetForm.editTweetContent.$valid">
						<p ng-message="required">Tweet content is required.</p>
						<p ng-message="minlength">Tweet content cannot be empty.</p>
						<p ng-message="maxlength">Tweet content is too long.</p>
					</div>
				</div>
				<div class="form-group" ng-class="{ 'has-error': editTweetForm.editTweetDate.$touched && editTweetForm.editTweetDate.$invalid }">
					<label for="editTweetDate">Tweet Date</label>
					<div class="dropdown">
						<a class="dropdown-toggle" id="editTweetDateDropdown" role="button" data-toggle="dropdown" data-target="#">
							<div class="input-group">
								<input type="text" id="editTweetDate" name="editTweetDate" class="form-control" ng-model="editedTweet.tweetDate">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="editTweetDateDropdown">
							<datetimepicker ng-model="editedTweet.tweetDate"
											data-datetimepicker-config="{ dropdownSelector: '#editTweetDateDropdown', minuteStep: 1 }">
							</datetimepicker>
						</ul>
					</div>
				</div>
				<button type="submit" class="btn btn-info btn-lg" ng-disabled="editTweetForm.$invalid"><i class="fa fa-twitter"></i> Save</button>
				<button class="btn btn-warning btn-lg" ng-click="cancelEditing();"><i class="fa fa-times"></i> Cancel</button>
			</form>
			<p id="tweetStatusBar" class="alert alert-dismissible" ng-class="statusType" ng-show="showStatus" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="disableStatus();"><span aria-hidden="true">&times;</span></button>
				{{ statusContent }}
			</p>
		</div>
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
	</section>
</main>
