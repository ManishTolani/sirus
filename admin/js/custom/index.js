function getData() {
    $.ajax({
        type: "post",
        url: "getData.php",
        statusCode: {
            500: function() {
                console.log("Internal Server Error");
            }
        },
        success: function(response) {
            response = JSON.parse(response);
            $('#total_uploads').html(response['total_uploads']);
            $('#total_downloads').text(response['total_downloads']);
            $('#total_users').text(response['total_users']);
            $('#online_users').text(response['users_online']);
            $('#accepted_requests').text(response['accepted_requests']);
            $('#rejected_requests').text(response['rejected_requests']);
        },
        error: function(response) {
            console.log("Error in making request");
        }
    });
    setTimeout(getData, 3000);
}

$(window).on("load", function() {
    getData();
});
