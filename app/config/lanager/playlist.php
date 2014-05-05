<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Video Player
	|--------------------------------------------------------------------------
	|
	| Set the dimensions and preferred quality for the playlist video player
	|
	*/
	'videoplayer' => array(
		'width' => 1200,
		'height' => 700,
		'quality' => 'highres', // small, medium, large, hd720, hd1080, highres or default (see http://bit.ly/1isMjD9 )
	),

	/*
	|--------------------------------------------------------------------------
	| Max Queue Length
	|--------------------------------------------------------------------------
	|
	| Prevent users from submitting new items if the total of unplayed items
	| durations exceeds this value
	|
	*/
	'maxQueueLength' => 3600, // Time in seconds

	/*
	|--------------------------------------------------------------------------
	| Max Item Duration
	|--------------------------------------------------------------------------
	|
	| Prevent users from submitting a playlist item if it is longer than
	| this value
	|
	*/
	'maxItemDuration' => 600, // Time in seconds

	/*
	|--------------------------------------------------------------------------
	| Max Duplicate Items
	|--------------------------------------------------------------------------
	|
	| Prevent users from submitting a playlist item if this many duplicates
	| have already been submitted
	| 
	| Set to 0 to disallow all duplicates
	| Set to 1 to allow a single duplicate item (2 items of the same id total)
	|
	*/
	'maxDuplicates' => 0, // Item count

	/*
	|--------------------------------------------------------------------------
	| Max Consecutive Items from One User
	|--------------------------------------------------------------------------
	|
	| Prevent users from submitting a playlist item if it will be their Nth
	| consecutive item submission
	| 
	| Set to 0 to prevent more than one consecutive submission from one user
	|
	*/
	'maxConsecutiveItemsFromSingleUser' => 0, // Item count

	/*
	|--------------------------------------------------------------------------
	| Downvote Skip Threshold
	|--------------------------------------------------------------------------
	|
	| Videos that receive this number of downvotes from users will be skipped
	|
	*/
	'itemDownvoteSkipThreshold' => 4, // Downvote count


	/*
	|--------------------------------------------------------------------------
	| Allow Downvoting of Future Entries
	|--------------------------------------------------------------------------
	|
	| False - Users can only downvote the currently playing item
	| True  - Users can downvote any item
	|
	*/
	'downvoteFutureItems' => false, // Downvote count

);
