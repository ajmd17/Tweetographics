function saveSearchResult(search_query, search_result, callBack) {
    $.ajax({
        type: "post",
        url: "save_search.php",
        data: {
            query: search_query,
            search_data: search_result
        },
        success: function(data) {
            callBack(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("Error saving search result!");
        }
    });
}