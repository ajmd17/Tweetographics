<?php 
require_once 'twitconnect.php';

class Entry
{
    public $country;
    public $state;
    public $city;
    
    public $unparsedLocation;
    
    public $tweetData;
    public $screenName;
}

function loadTweetData($tweets)
{
    $mode = 'country_only';
    /* modes:
        country_only,
        country_state,
        country_state_city
    */
    $useStates = false;
    $useCities = false;

    $numResults = 0;
    
    $listResults = array();
    $entries = array();

    foreach ($tweets->statuses as $key => $tweet) {
        if ($tweet->user->location)
        {
            $location = urlencode($tweet->user->location);
            $address = $location;
            
            if ($address != '')
            {
                $key = urldecode($location);
                
                $numResults++;
                if (isset($listResults[$key]))
                    $listResults[$key]++;
                else
                    $listResults[$key] = 1;
                    
                $entry = new Entry();
                $entry->unparsedLocation = $key;
                $entry->tweetData = $tweet->text;
                $entry->screenName = $tweet->user->screen_name;
                    
                array_push($entries, $entry);
            }
        }
    }
    
    $returns = array(); // multiple return values

    $graph = array();

    $labels = array();
    $datasets = array();

    $data = array();
    $fillColors = array();

    foreach ($listResults as $key => $val) {
        array_push($labels, $key);
        array_push($data, $val);
    }

    $datasets[0]['data'] = $data;

    $graph['labels'] = $labels;
    $graph['datasets'] = $datasets;
    
    
    $returns['graph'] = $graph;
    $returns['tweetData'] = $entries;
    
    return json_encode($returns);
}

if (isset($_POST['query']))
{
    $query = $_POST['query'];
    $count = 50;
    $searchType = 'recent';
    
    if (isset($_POST['count']) && $_POST['count'] > 0)
        $count = $_POST['count'];
        
    if (isset($_POST['searchType'])) 
        $searchType = $_POST['searchType'];
        
    $tweets = $twitter->get('search/tweets.json?q=' . $query . '&result_type=' . $searchType . '&count=' . $count);
    echo loadTweetData($tweets);
}
?>