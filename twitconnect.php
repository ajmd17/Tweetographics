<?php

session_start();

include "twitteroauth/twitteroauth.php";

$consumer_key = "SBksCQYndNL72pfbkcd7XITbb";
$consumer_secret = "***REMOVED***";
$access_token = "701437285695410176-FmUrjOvr59dllOdmLgVOtSFaBioS08z";
$access_token_secret = "***REMOVED***";

$twitter = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

?>