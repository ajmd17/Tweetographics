<!DOCTYPE html>
<html lang="en">
<?php include "header.php" ?>
    <style>
        .searchbox-content {
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            margin: 10px 0 0 0;
            box-shadow: 1px 5px 5px #000000; 
            background-color: white;
            width: 100%;
        }
        
        #nav-search-box {
            float: right;
            opacity: 0.7;
            transition: width 0.5s ease-in-out;
            width: 160px;
        }

        #nav-search-box:hover {
            box-shadow: 0px 0px 5px #777777; 
            opacity: 1.0;
            width: 230px;
        }
        
        .canvas-container {
            width: 800px;
            height: 350px;
        }
        
        .chart-display {
            margin: 100px auto; 
            margin-bottom: 100px;
            box-shadow: 0px 0px 35px #111111; 
            display: table; 
            height: 50%; 
            top: 0; 
            right: 0; 
            bottom: 0; 
            left: 0; 
            background-color: white;
            max-width: 100%;
            padding: 10px;
        } 
        
        canvas {
            width: 100% !important;
            height: auto !important;
        }
        
        .modal-title {
            font-size: 18pt;
        }
        
        #share-buttons img {
            width: 48px;
            padding: 5px;
            border: 0;
            box-shadow: 0;
            display: inline;
        }
        
        .popover{
            max-width: 350px;
            width: 350px;
            font-size: 10pt;
            box-shadow: 0px 0px 25px #000000;
            z-index: 0;
        }
        
        @media (max-width: 400px) {
            .modal-title {
                font-size: 10pt;
            }
            
            .chart-display {
                margin: 0 auto;
                margin-top: 100px;
                margin-bottom: 100px;
            }
            
            .canvas-container {
                max-width: 330px;
                max-height: 400px;
            }
        }
    </style>
    <script src="save_search_ajax.js"></script>
    
</head>

<body>
    <div class="chart-display" id="chart-display">
        
        <h1 id="title-bar" style="margin: auto; top: 0; right: 0; bottom: 0; left: 0; padding-top: 15px; font-size: 20pt; text-align: center; display: table;"></h1>
        <hr>
        <div id="loader" class="spinner" style="right: 0; left: 0; transform: translateY(50%); margin: 0 auto; "></div>
        
        <div class="canvas-container">
            <canvas id="canvas" height="450" width="800" style="margin: 15px;display:table;"></canvas>
        </div>
        <hr>
        <div class="dropup" style="margin: 6px; float: left; display:inline-block;">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Chart type
                <span class="caret"></span>
            </button>
            <button id="share-btn" class="btn btn-default" type="button" onclick="shareResult();">
                Share
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#a" onclick="chartType = BAR_CHART; createChart();" style="color: #333333;">Bar graph</a></li>
                <li><a href="#a" onclick="chartType = PIE_CHART; createChart();" style="color: #333333;">Pie chart</a></li>
            </ul>
        </div>
        
        <a class="btn btn-default" href="index.php" type="button" style="margin: 6px; float: right; display:inline-block;" >
               New search
        </a>
        
        
    </div>
    
        <!-- Modal for clicking on graph items-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 id="ext-view-title" class="modal-title">No results</h1>
                
            </div>
            <div class="modal-body">
                <canvas id="canvasModal" height="350" width="600"></canvas>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
    
       <!-- Modal for getting a link-->
  <div id="linkGetter" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title">Share results</h1>
                
            </div>
            <div class="modal-body" style="display:table;">
                <div class="form-group">
                    <label for="linkText">Copy and paste this URL:</label>
                    <input id="linkText" class="form-control span6 input-large search-query" type="text" name="linktext">
                </div>
                <label for="share-buttons">Or share with your friends and followers</label>
                <div id="share-buttons" style="margin: 0 auto; display: table;">
                    <a href="#a" class="share-twitter">
                        <img src="img/twitter.png" alt="Twitter" />
                    </a>
                    <a href="#a" class="share-facebook">
                        <img src="img/fb.png" alt="Facebook" />
                    </a>
                    <a href="#a" class="share-googleplus">
                        <img src="img/google+.png" alt="Google" />
                    </a>
                    <a href="#a" class="share-linkedin">
                        <img src="img/linkedin.png" alt="LinkedIn" />
                    </a>
                    <a href="#a" class="share-reddit">
                        <img src="img/reddit.png" alt="Reddit" />
                    </a>
                    <a href="#a" class="share-email">
                        <img src="img/email.png" alt="Email" />
                    </a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
  </div>
  
  <script>
      function selectText(textField) 
      {
        textField.focus();
        textField.select();
      }
  </script>
  
  <nav class="navbar navbar-inverse">
        <div class="container-fluid">
        <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">                 
                </button>
                <a class="navbar-brand" href="index.php" style="text-shadow: 2px 4px 3px rgba(0,0,0,0.3);">Tweetographics</a>
                <p style="text-shadow: 1px 1px 3px rgba(0,0,0,0.3); font-size: 10pt; 
                            color: #FFFFFF; display: inline; 
                            margin-left: 11px; margin-top: 11px; 
                            position: absolute; top: 0; 
                             width: 150px;">
                   Simple demographics for Twitter
                </p>
                
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="#"></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    
                    <form name="quicksearch" class="form-group has-feedback" action="results.php" id="quick-search" method="get">
                       <!-- <div id="search-adv">-->
                            <input type="text" class="form-control search-box" onclick="selectText(this);" placeholder="Search" name="search" id="nav-search-box" style="display: inline-block; margin-top: 15px; height: 30px; padding-top:0; padding-bottom: 0;line-height: 30px;">
                            
                            <!--<div id="search-content" class="searchbox-content"> <hr>hello world </div>-->
                            <span href="#a" onclick="quicksearch.submit()" class="glyphicon glyphicon-search form-control-feedback" style="width: 16px; height: 16px; margin: 8px; margin-top: 7px; opacity: 0.7;"></span>
                      <!--  </div>-->
                            <input type="hidden" name="count" value="50">
                            <input type="hidden" name="searchmode" value="recent">
                    </form>
                    
                </ul>
            </div>
        </div>
    </nav>    
    
    
    <script src="js/spin.min.js"></script>
    <script src="chart_generator.js"> </script>  
    <script>
        function shareResult() {
                <?php
                
                if (isset($_GET['saved_search'])) 
                {
                    // the search result has already been saved to the database, 
                    // so just give the url back to the user.
                    echo "
                        savedID = " . $_GET['id'] . "
                        saved = true;
                        $('#linkText').val('http://tweetographics.com/results.php?saved_search&id=" . $_GET['id'] . "');
                        $('#linkGetter').modal('show');
                    ";
                } 
                else
                {
                echo "
                    if (!saved) {
                        // save the results to the database
                        var tweetDataSave = tweetData.slice();
                        var index;
                        for (index = 0; index < tweetDataSave.length; ++index) {
                            if (tweetData[index] == null || tweetData[index].country == null) {
                                delete tweetDataSave[index];
                            } else {
                                delete tweetDataSave[index].tweetData;
                                delete tweetDataSave[index].unparsedLocation;
                            }
                        }
                        
                        var strData = window.JSON.stringify(tweetDataSave);
                        
                        var callBack = function(savedSearchID) {
                                savedID = savedSearchID;
                                saved = true;
                                $('#linkText').val('http://tweetographics.com/results.php?saved_search&id=' + savedSearchID);
                                $('#linkGetter').modal('show');
                        };
                        
                        // from save_search_ajax.js
                        saveSearchResult(search_query, strData.toString(), callBack);
                    } else if (saved) {
                        $('#linkText').val('http://tweetographics.com/results.php?saved_search&id=' + savedID);
                        $('#linkGetter').modal('show');
                    }
                    ";
                }
                ?>
        }
        
    </script>
    <?php
        if (isset($_GET['search']))
        {
            if (isset($_GET['count']))
            {
                echo '<script>';
                if (intval($_GET['count']) > 250)
                {
                    echo '
                    alert("Sample count must be less than or equal to 250!");
                    sample_count = 50;
                    
                    var formInfo = document.forms["quick-search"];
                    formInfo.count.value = sample_count;';
                }
                else
                {
                    echo '
                    sample_count = ' . $_GET['count'] . ';
                    
                    var formInfo = document.forms["quick-search"];
                    formInfo.count.value = sample_count;';
                }
            }
            
            if (isset($_GET['charttype'])) 
            {
                echo '
                chartType = ' . intval($_GET['charttype']) . ';';
            }
            
            if (isset($_GET['searchmode'])) 
            {
                echo '
                search_type = "' . $_GET['searchmode'] . '";
                    
                var formInfo = document.forms["quick-search"];
                formInfo.searchmode.value = search_type;';
            }
            
            echo '
                $("#nav-search-box").attr("value", "' . $_GET['search'] . '");
                search("' . $_GET['search'] . '");';
            
            echo '
            </script>';
        } 
        elseif (isset($_GET['saved_search'])) 
        {
            if (isset($_GET['id'])) 
            {
                $search_id = intval($_GET['id']);
                
                echo '
                <script>
                    getSavedSearch(' . $search_id . ');
                </script>'; 
            }
        }
    ?>
</body>
</html>