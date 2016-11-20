        var randColorList=[];
        
        var search_query;
        var geocoder;
        var delay = 1;
        
        var search_type = 'recent';
        var sample_count = 50;
        
        var canv = document.getElementById('canvas');
        
        var stateBar;
        var myBar;
        var tweetData = {};
        var creatingChart = false;
        var graphData=[], stateData=[]; 
            
        const BAR_CHART = 0;
        const PIE_CHART = 1;
        
        var chartType = BAR_CHART;
        
        var saved = false; // is it saved in the database already?
        var savedID = -1;
        var shareURL = '';
        
        var pathArray = window.location.pathname.split( '/' );
        
        // fill random values
        for (var i = 0; i < 50; i++) {
            var rcseed = (i+100).toString();
            randColorList[i] = randomColor({luminosity: 'light',format: 'rgb',seed: rcseed});
        }
        
        function removeSpaces(str) {
            return str.replace(/\s+/g, '');
        }
        
        function gup( name, url ) {
            if (!url) url = location.href;
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS = "[\\?&]"+name+"=([^&#]*)";
            var regex = new RegExp( regexS );
            var results = regex.exec( url );
            return results == null ? null : results[1];
        }
        
        String.format = function() {
            var theString = arguments[0];
            for (var i = 1; i < arguments.length; i++) {
                var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
                theString = theString.replace(regEx, arguments[i]);
            }
            return theString;
        }
        
        function saveResults(siteLink) {
            var shareText = encodeURIComponent('See where people are tweeting about "' + search_query + '" with Tweetographics!');
            var shareTitle = encodeURIComponent('Results for "' + search_query + '" on Tweetographics');
            
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
                    shareURL = encodeURIComponent('http://tweetographics.com/results.php?saved_search&id=' + savedID);
                    window.open(String.format(siteLink, shareURL, shareText, shareTitle), 'sharePage');
                    saved = true;
                };
                
                // from save_search_ajax.js
                saveSearchResult(search_query, strData.toString(), callBack);
            } else if (saved) {
                shareURL = encodeURIComponent('http://tweetographics.com/results.php?saved_search&id=' + savedID);
                window.open(String.format(siteLink, shareURL, shareText, shareTitle), 'sharePage');
            }
        }
        
        function closeSharePopup() {
            $('#share-btn').popover('hide');
            $('#share-btn').popover('disable');
        }
                
        function showSharePopup() {
            var dvShareBtns = '<div id="share-buttons" style="margin: 0 auto; display: table;">'
                  +  '<a href="#a" class="share-twitter">'
                  +   '<img src="img/twitter.png" alt="Twitter" />'
                  +  '</a>'
                  +  '<a href="#a" class="share-facebook">'
                  +     '<img src="img/fb.png" alt="Facebook" />'
                  +  '</a>'
                  +  '<a href="#a" class="share-googleplus">'
                  +     '<img src="img/google+.png" alt="Google" />'
                  +  '</a>'
                  +  '<a href="#a" class="share-linkedin">'
                  +     '<img src="img/linkedin.png" alt="LinkedIn" />'
                  +  '</a>'
                  +  '<a href="#a" class="share-reddit">'
                  +     '<img src="img/reddit.png" alt="Reddit" />'
                  +  '</a>'
                  +  '<a href="#a" class="share-email">'
                  +     '<img src="img/email.png" alt="Email" />'
                  +  '</a>'
                  + '</div>';
            
            $("#share-btn").popover({
                                     title: 'Share your results' +
                                             '<button type="button" id="close" class="close" onclick="closeSharePopup()">&times;</button>',
                                     html: true,
                                     placement: 'top',
                                     content: 'Click here to share these results with others.' + dvShareBtns
                                     });
                                     
            $("#share-btn").popover('show');
            
            $('.share-twitter').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                
                var queryNoSpaces = removeSpaces(search_query);
                saveResults('https://twitter.com/intent/tweet?url={0}&text={1}&hashtags=tweetographics,'+queryNoSpaces);
            });
            $('.share-facebook').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                saveResults('http://www.facebook.com/sharer.php?u={0}');
            });
            $('.share-googleplus').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                saveResults('https://plus.google.com/share?url={0}');
            });
            $('.share-linkedin').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                saveResults('http://www.linkedin.com/shareArticle?mini=true&amp;url={0}');
            });
            $('.share-reddit').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                saveResults('http://reddit.com/submit?url={0}&title={2}');
            });
            $('.share-email').click(function() {
                closeSharePopup();
                window.open('about:blank', 'sharePage');
                saveResults('mailto:?Subject={2}&Body={1} {0}');
            });
        }
        
        function parseLocation(key) {
            if (geocoder == undefined) {
                geocoder = new google.maps.Geocoder();
            }
            
            var location = tweetData[key]['unparsedLocation'];
            
            geocoder.geocode( { 'address': location}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //for (var i = 0; i < results.length; i++) {
                        var address_components = results[0].address_components;
                        var components={}; 
                        jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})
                        tweetData[key]['country'] = components.country;
                        tweetData[key]['state'] = components.administrative_area_level_1;
                        tweetData[key]['city'] = components.locality;
                        if (delay > 1)
                            delay--;
                   // }
                } else {
                    console.log("error: " + status);
                    if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                       // key--;
                       delay+=3;
                    }
                }
            });
        }
            
        function createChart() {
            console.log("Create chart.");
            if (!creatingChart) {
                if (myBar != undefined)
                    myBar.destroy();
                    
                var countries = {};
                
                for (var i = 0; i < tweetData.length; i++) {
                    if (tweetData[i] != null) {
                    var currentCountry = tweetData[i].country;
                        if (currentCountry != '' && currentCountry != null) {
                            if (countries[currentCountry] != undefined) {
                                countries[currentCountry]++;
                            } else {
                                countries[currentCountry] = 1;
                            }
                        }
                    }
                }
                
                if (chartType == BAR_CHART) {    
                    var labels=[]; var vals=[]; var datasets=[]; var i = 0;
                    for (var index in countries) {
                        labels[i] = index;
                        vals[i] = countries[index];
                        i++;
                    }
                    
                    datasets[0] = [];
                    datasets[0]['data'] = vals;
                    graphData['labels'] = labels;
                    graphData['datasets'] = datasets;
                    
                    var ctx = canv.getContext("2d");
                    window.myBar = new Chart(ctx).Bar(graphData, {
                        responsive : true,
                        maintainAspectRatio: false
                    });
                } else if (chartType == PIE_CHART) {
                    var datasets=[]; var i = 0;
                    for (var index in countries) {
                        var data=[]; 
                        data['color'] = randColorList[i];
                        data['label'] = index;
                        data['value'] = countries[index];
                        graphData[i] = data;
                        i++;
                    } 
                    
                    var ctx = canv.getContext("2d");
                    window.myBar = new Chart(ctx).Pie(graphData, {
                        responsive : true,
                        maintainAspectRatio: false
                    });
                }
                
                for (var i = 0; i < myBar.datasets[0].bars.length; i++) {
                    myBar.datasets[0].bars[i].fillColor = randColorList[i];
                }
                myBar.update();
                
                if (window.location.href.indexOf('saved_search') != -1) {
                    saved = true;
                    shareURL = encodeURIComponent('http://tweetographics.com/results.php?saved_search&id=' + savedID);
                }
                
                showSharePopup();
                
                creatingChart = false;
            }
        }
        
        function getSavedSearch(search_id) {
            saved = true;
            savedID = search_id;
            
            $.ajax({
                type: "post",
                url: "get_saved_search.php",
                dataType: "json", 
                data: {
                    saved_search_id: search_id
                },
                success: function(data) {
                    search_query = data['query'];
                    tweetData = JSON.parse(data['data']);
                    
                    var date = data['date'];
                    
                    $("#title-bar").html("Results for \"" + search_query + "\" from " + date);
                    $("#loader").hide();
                    
                    $("#nav-search-box").attr("value", search_query);
                    
                    creatingChart = false;
                    createChart();
                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log("Error retreving saved search result!");
                }
            });
        }
        
        function search(searchQuery) {
            $.ajaxSetup({
                cache: true
            });
            
            $("#share-btn").attr("disabled", "true");
            
            search_query = searchQuery;
            //var numSamples = $("#countDropDown option:selected").val();
            
            $("#title-bar").html("Loading data...");
            
            if (searchQuery != "") {
                
                $("#loader").show();
               /* var opts = {
                    lines: 11 // The number of lines to draw
                    , length: 0 // The length of each line
                    , width: 16 // The line thickness
                    , radius: 48 // The radius of the inner circle
                    , scale: 3 // Scales overall size of the spinner
                    , corners: 1 // Corner roundness (0..1)
                    , color: '#000' // #rgb or #rrggbb or array of colors
                    , opacity: 0.1 // Opacity of the lines
                    , rotate: 0 // The rotation offset
                    , direction: 1 // 1: clockwise, -1: counterclockwise
                    , speed: 1.2 // Rounds per second
                    , trail: 60 // Afterglow percentage
                    , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
                    , zIndex: 2e9 // The z-index (defaults to 2000000000)
                    , className: 'spinner' // The CSS class to assign to the spinner
                    , top: '50%' // Top position relative to parent
                    , left: '50%' // Left position relative to parent
                    , shadow: true // Whether to render a shadow
                    , hwaccel: false // Whether to use hardware acceleration
                    , position: 'absolute' // Element positioning
                }
                var target = document.getElementById('chart-display');
                var spinner = new Spinner().spin();
                target.appendChild(spinner.el);*/
                
                $.ajax({
                    type: "post",
                    url: "search.php",
                    dataType: "json", 
                    data: {
                        query: searchQuery,
                        count: sample_count,
                        searchType: search_type
                    },
                    success: function(data) {
                        creatingChart = true;
                        
                        tweetData = data['tweetData'];
                        
                        $("#title-bar").html("Gathering location data...");
                        
                        var key = 0;
                        var timer;
                        function interval() {
                            for (var i = 0; i < 1; i++) {
                                if (key >= tweetData.length) {
                                    console.log("at end");
                                    $("#title-bar").html("Results for \"" + searchQuery + "\"");
                                    $("#loader").hide();
                                    creatingChart = false;
                                    clearTimeout(timer);
                                    createChart();
                                    $("#share-btn").removeAttr("disabled");
                                    timer = null;
                                    return;
                                } else {
                                    parseLocation(key);
                                    key++;
                                    
                                    //var percentage = Math.round((key / tweetData.length) * 100);
                                    $("#title-bar").html("Gathering location data... (" + key + "/" + tweetData.length + ")");
                                    clearTimeout(timer);
                                    timer = setTimeout(interval, 550*delay);
                                }
                            }
                        };
                        interval();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log("ERROR: " + thrownError);
                    }
                });
            }
        }
        
        $("#myModal").on("shown.bs.modal", function(event) {
            
                    var ctx = document.getElementById("canvasModal").getContext("2d");
                    stateBar = new Chart(ctx).Bar(stateData, {
                        responsive : true,
                        maintainAspectRatio: false
                    }); 
                    /*for (var i = 0; i < stateBar.datasets[0].bars.length; i++) {
                        if (stateData.labels[i] != "Unknown") {
                            stateBar.datasets[0].bars[i].fillColor = randColorList[i];
                        }
                    }
                    stateBar.update();*/
        });
        
        $("#canvas").click(function(e) {
            $("#tweet-info").text("");
            
            var activeBars; 
            if (chartType == BAR_CHART) {
                activeBars = myBar.getBarsAtEvent(e); 
            } else if (chartType == PIE_CHART) {
                activeBars = myBar.getSegmentsAtEvent(e); 
            }
            
            if (activeBars != undefined) {
                if (stateBar != null)
                    stateBar.destroy();
                
                var states = {};
                
                for (var i = 0; i < tweetData.length; i++) {
                    if (tweetData[i] != null) {
                        if (tweetData[i]['country'] == activeBars[0]['label']) {
                            var currentState = tweetData[i].state;
                            if (currentState != '' && currentState != null) {
                                if (states[currentState] != undefined) {
                                    states[currentState]++;
                                } else {
                                    states[currentState] = 1;
                                }
                            } else if (currentState == null) {
                                if (states["Unknown"] != undefined) {
                                    states["Unknown"]++;
                                } else {
                                    states["Unknown"] = 1;
                                }
                            }
                        }
                    }
                }
                  
                var labels=[]; var vals=[]; var datasets=[]; var i = 0;
                for (var index in states) {
                    labels[i] = index;
                    vals[i] = states[index];
                    i++;
                }
                   
                datasets[0] = [];
                datasets[0]['data'] = vals;
                stateData['labels'] = labels;
                stateData['datasets'] = datasets;
                
                $("#myModal").modal("show");
                
               /* for (var i = 0; i < tweetData.length; i++) {
                    if (tweetData[i]['country'] == activeBars[0]['label']) {
                        $("#tweet-info").append("<div style=\"width: 100%; height: 45px; margin: 0 auto; padding: 0;" +
                                                "color: white; box-shadow: 0px 0px 15px #888888; background-color: #888888; display: table;" + 
                                                "border-radius: 5px;\">" + 
                                                "<p style=\"font-size: 9pt; padding: 5px; text-align: center; font-family: Arial, sans-serif;\">" + 
                                                tweetData[i]["tweetData"] + "</p></div><br>");
                                                
                                                
                                                
                         $("#tweet-info").append("<div style=\"width: 100%; height: 45px; margin: 0 auto; padding: 0;" +
                                                "color: white; box-shadow: 0px 0px 15px #888888; background-color: #888888; display: table;" + 
                                                "border-radius: 5px;\">");
                         $("#tweet-info").append("<p style=\"font-size: 9pt; padding: 5px; text-align: center; font-family: Arial, sans-serif;\">" + 
                                                tweetData[i]["state"] + "</p></div><br>");                
                    }
                }*/
                
                $("#ext-view-title").html("Results for \"" + search_query + "\" in " + activeBars[0]['label']);
            }
        });
        
        
        $("#button").click(function() {
            search($("#search").val());
        });

        $('#search').keyup(function(e) {
            if (e.keyCode == 13) {
                search($("#search").val());
            }
        });