$('.response-button').click(function() {

    var method = 'reject';
    if($(this).hasClass('accept')) {
        method = 'accept';
    }

    var id = $(this).parent('td').find('input').val();

    $.ajax({
        type: "POST",
        url: "../admin/confirmation.php",
        data: { id: id, what: method },
        success: function(response) {
            if(response == 1) {
                location.reload();
            } else {
                $(this).parent('td').text('Error!!');
            }
        },
        error: function(response) {
            console.log("Error deleting the data");
        }
    });
});
