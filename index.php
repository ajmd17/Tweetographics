<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>
    <style>
        html, body, .container-table {
            height: 100%;
        }
        .container-table {
            display: table;
        }
        .vertical-center-row {
            display: table-cell;
            vertical-align: middle;
        }
        
        .searchbox {
            transition: all linear .3s;
        }
        
        .searchbox:hover {
            box-shadow: 0px 0px 15px #777777; 
        }
        
        .title-bar {
            font-size: 12pt; 
        }
        
        .box {
            transition: all linear .2s;
            height: 135px;
            min-height: 135px;
            min-width:430px; 
        }
        
        .box-expand {
            height: 350px;
        }
        
        .expanded-box {
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3); 
            width: 100%; 
            height: 100%;
            color: white;
            display: table;
            margin: 0 auto;
        }
        
        .side-box {
            z-index: -1;
            overflow: hidden;
            visibility: hidden;
            height: 135px;
            background-color: rgba(0, 0, 0, 0.45);
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-right: 1px solid #555555;
            border-top: 1px solid #555555;
            border-bottom: 1px solid #555555;
            position: absolute;
            box-shadow: 2px 2px 20px #222222; 
            margin: auto; 
            top: 0; 
            right: -630px; 
            bottom: 0; 
            left: 0; 
            width: 200px;
            transition: all linear .2s;
        }
        
        .side-box-expand {
            height: 350px;
        }
        
        @media (max-width: 500px) {
            .box {
                min-width: 100%;
            }
            
            .title-bar {
                font-size: 10pt;
            }
        }
    </style>
    
    <script>
        function viewSearchOptions() {
            $('#box').toggleClass('box-expand');
            $('#trends-box').toggleClass('side-box-expand');
            
            if ($('#expanded-box-options').css('visibility') == 'hidden') {
                $('#expanded-box-options').css('visibility', 'visible');
            } else {
                $('#expanded-box-options').css('visibility', 'hidden');
            }
            
            $.cookie("options-visible", $("#expanded-box-options").css('visibility') == 'visible', {expires:9999});
        }
        
        function showTrends() {
            if ($('#trends-box').css('visibility') == 'hidden') {
                $('#trends-box').css('opacity', '1');
                $('#trends-box').css('visibility', 'visible');
            } else {
                $('#trends-box').css('opacity', '0');
                $('#trends-box').css('visibility', 'hidden');
            }
        }
    </script>
</head>

<body>
    <div class="container-fluid container-table">
        <div class="row vertical-center-row">
            <div id="box" class="box text-center col-sm-6 center-block" style="float: none; box-shadow: 2px 2px 20px #222222; border-radius: 5px; background-color: #6acd79;">
                <form id="search-form" action="results.php" onsubmit="return submitSearch()"  action="get">
                    <div>
                        <p id="title-bar" class="title-bar" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.3); margin: auto; overflow:hidden; padding-top: 6px; color: white; display: table;">
                            Enter a search term, username, or <!--<a href="#" onclick="showTrends();" class="title-bar" style="color: #d3f8d3;">-->trending topic.<!--</a>-->
                        </p>
                        
                        <input type="text" autofocus name="search" id="search" class="form-control searchbox" placeholder="Search" style="width: 100%; height: auto; margin: 8px auto; padding: 8px; right: 0; left: 0; ">
                        
                        <button id="btn-expand" class="btn btn-default btn-sm" onclick="viewSearchOptions();" type="button" style="float: left; bottom: 8px; left: 15px; position: absolute; display:inline-block;" >
                            Options
                        </button>
                        
                        <button type="submit" class="btn btn-default btn-sm" href="index.php" type="button" style="float: right; bottom: 8px; right: 15px; position: absolute; display:inline-block;" >
                            Search
                        </button>
                        
                        <div id="expanded-box-options" class="expanded-box" style="visibility: hidden; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);"> 
                            <h1 style="font-size: 14pt; padding: 1px; margin: 1px;">Search Options</h1>
                            <hr style="padding: 1px; margin-top: 8px; margin-bottom: 8px;">
                            
                            <div id="items">
                            
                                <label for="countDropDown" style="margin: 8px; font-size:10pt; width: 150px;">Number of samples:</label>
                                <select class="form-control input-sm" name="count" id="countDropDown" style="color: black;">
                                    <option value="15" id="s15">15 samples</option>
                                    <option value="30" id="s30" selected="selected">30 samples</option>
                                    <option value="50" id="s50">50 samples</option>
                                    <option value="100" id="s100">100 samples</option>
                                    <option value="250" id="s250">250 samples</option>
                                </select>
                                
                                <br>
                                
                                <label for="searchDropDown" style="margin: 8px; font-size:10pt; width: 150px;">Search type:</label>
                                <select class="form-control input-sm" name="searchmode" id="searchDropDown" style="color: black;">
                                    <option value="recent" id="sRecent">Most recent</option>
                                    <option value="popular" id="sPopular">Most popular</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="trends-box" class="side-box" style="position: fixed;">
        <p style="padding: 6px; color: white; font-size: 10pt;">
            Trending topics will go here
            Blah blah blah
            blah blah
        </p>
    </div>
    
    <script>
           if ($.cookie("options-visible") == 'true') {
               $('#box').toggleClass('box-expand');
               $('#trends-box').toggleClass('side-box-expand');
               $("#expanded-box-options").css('visibility', 'visible');
           }
           
           if ($.cookie('sample-count')) {
               $('#countDropDown').val($.cookie('sample-count'));
           }
           if ($.cookie('search-mode')) {
               $('#searchDropDown').val($.cookie('search-mode'));
           }
           
           function submitStoreCookie() {
               $.cookie('sample-count', $('#countDropDown').val());
               $.cookie('search-mode', $('#searchDropDown').val());
           }
           
           function validateForm() {
                var val = document.forms["search-form"]["search"].value;
                if (val == null || val == "") {
                    alert("Search box should not be empty");
                    return false;
                }
                return true;
            }
           
           function submitSearch() {
               if (validateForm()) {
                   submitStoreCookie();
                   return true;
               }
               return false;
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
                <ul class="nav navbar-nav navbar-right"></ul>
            </div>
        </div>
    </nav>    
</body>

</html>