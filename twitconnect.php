<?php

session_start();

include "twitteroauth/twitteroauth.php";

$consumer_key = "SBksCQYndNL72pfbkcd7XITbb";
$consumer_secret = /*removed*/;
$access_token = "701437285695410176-FmUrjOvr59dllOdmLgVOtSFaBioS08z";
$access_token_secret = /*removed*/;

$twitter = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

?>
