<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tweetographics - Simple and free Twitter demographics engine</title>
  <meta name="description" content="Tweetographics allows you to enter any search term, username, or trending topic and see where people are talking about it.">
  <link rel="stylesheet" href="css/theme.css">
  <!--<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>-->
  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <script src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>
  <script src="js/jquery-1.12.0.min.js"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/Chart.js"></script>
  <script src="js/randomcolor.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-fZb8uxe8KKUuXPbxtxdqN8DXpnPxTMs&libraries=visualization"></script>
  <style>
    * {
        font-family: 'Open Sans', sans-serif;
        font-size: 12pt;
    }
    html {
        height: 100%;
    }
    
    .navbar {
	   position: fixed;
	   top: 0px;
	   width: 100%;
	   margin-bottom: 0;
	   border-radius: 0px;
       background-color: #6acd79;
	   box-shadow: 0px 0px 35px #111111;
       
    }
    
    body {
        background-color: #303030;
        background-image: url("img/pattern.png");
        background-size: cover;
    }
    
    .spinner {
        height: 100px;
        width: 100px;
        animation: rotate 1.3s infinite linear;
        border: 8px solid #6acd79;
        border-right-color: transparent;
        border-radius: 50%;
        margin: 0 auto;
        position: absolute;
        display: table;
    }
    
    @-moz-keyframes rotate {
        0%    { transform: rotate(0deg) scale(0.93); }
        50%  { transform: rotate(180deg) scale(1.0); }
        100%  { transform: rotate(360deg) scale(0.93); }
    }
    
    @-webkit-keyframes rotate {
        0%    { transform: rotate(0deg) scale(0.93); }
        50%  { transform: rotate(180deg) scale(1.0); }
        100%  { transform: rotate(360deg) scale(0.93); }
    }
    
    @keyframes rotate {
        0%    { transform: rotate(0deg) scale(0.93); }
        50%  { transform: rotate(180deg) scale(1.0); }
        100%  { transform: rotate(360deg) scale(0.93); }
    }
    
  </style>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-74358957-1', 'auto');
    ga('send', 'pageview');
   </script>
   
   <nav class="footer navbar-fixed-bottom" style="
            background-color: rgba(0, 0, 0, 0.9); 
            max-height: 70px; padding: 0;
            margin-top: 100px;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            border-top: 2px solid rgba(55,55,55,0.7);">
        <div class="container" style="right: 0; left: 0; max-width: 700px; width: 100%;">
                <!-- adsense code -->
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- TG ad 3 -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-3438250883368598"
                    data-ad-slot="2996686060"
                    data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            
        </div>
   </nav>