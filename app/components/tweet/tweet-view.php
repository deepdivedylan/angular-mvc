<main class="container">
	<h1><i class="fa fa-twitter"></i> Tweet #{{ tweet.tweetId }}</h1>
	<p>{{ tweet.tweetContent }}</p>
	<p><em>Posted by Profile #{{ tweet.profileId }}</em> at {{ tweet.tweetDate | date : "medium" }}</p>
</main>