$(document).ready(function() {
    $.fn.extend({
        animateCss: function(animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated' + animationName);
            });
        }
    });

    var personName = $('.person-name').text();

    function createToast(notification) {
        $('.toast').html(notification).addClass('show');
        setTimeout(function() {
            $('.toast').html('').removeClass('show');
        }, 3000);
    }

    $('.inp-text').keyup(function() {
        $('.person-name').text($('#first_name').val() + ' ' + $('#last_name').val());
    });

    $('.inp-text,.search-bar').blur(function() {
        //$('.person-name').text(personName);
        if ($(this).val() != '') {
            if ($(this).attr('id') == 'search') {
                $('label[for="' + $(this).attr('id') + '"]').addClass('search-has-values');
            } else {
                $('label[for="' + $(this).attr('id') + '"]').addClass('has-values');
            }
        } else {
            if ($(this).attr('id') == 'search') {
                $('label[for="' + $(this).attr('id') + '"]').removeClass('search-has-values');
            } else {
                $('label[for="' + $(this).attr('id') + '"]').removeClass('has-values');
            }
        }
    });

    $('.search-bar').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('.table-container').css('display', 'block');
            $('.table-close-button').css('display', 'block');
            $('.nav').removeClass('nav-basic').addClass("nav-table-added");
            $('.table').removeClass('hide-table').addClass('view-table');
            $('.section').removeClass('show-main-section').addClass('hide-main-section');
            $('.table-close-button').removeClass('hide-table-button').addClass('show-table-button');
            $('.footer').css('visibility', 'hidden');

            var searchString = $('#search').val();
            if (searchString != "") {
                $('tbody').html("<tr class='row-table'><td colspan='4'>Loading Results ...</td></tr>");
                $.ajax({
                    type: "get",
                    url: "search.php",
                    data: {
                        keyword: searchString
                    },
                    statusCode: {
                        500: function() {
                            createToast("Internal Server Error");
                        }
                    },
                    success: function(response) {
                        var s = "";
                        var result = jQuery.parseJSON(response);
                        var host = window.location.hostname;
                        var upload_path = "/uploads/";
                        var address = host + upload_path;
                        if (result && result.length != 0) {
                            for (var i = 0; i < result.length; i++) {
                                s += "<tr class='row-table'>";
                                s += "<td>" + result[i]['file_name'] + "</td>";
                                s += "<td>" + result[i]['uploaded'] + "</td>";
                                s += "<td>" + (result[i]['times_dw'] == null ? 0 : result[i]['times_dw']) + " times </td>";
                                s += "<td><a href='http://ltz/download.php?file=" + result[i]['file_name'] + "&file_type=" + result[i]['file_type'] + "'style='cursor: hand;'><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span></a></td></tr>";
                            }

                        } else {
                            s = "<tr class='row-table'><td colspan='4'>No Search Results Found</td></tr>";
                        }
                        $('tbody').html(s);
                    },
                    error: function(response) {
                        createToast('Please Try After Sometime');
                    }
                });
            } else {
                var s = "<tr class='row-table'><td colspan='4'>No Search Results Found</td></tr>";
                $('tbody').html(s);
            }
        }
    });

    $('.table-close-button').click(function() {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $('.nav').removeClass('nav-table-added').addClass("nav-basic");
        $('.table').removeClass('view-table').addClass('hide-table');
        $('.table-close-button').removeClass('show-table-button').addClass('hide-table-button');

        window.setTimeout(function() {
            $('.table-container, .table-close-button').css('display', 'none');
        }, 250);

        if ($('.profile-setup').css('display') == 'none' && $('.password-setup').css('display') == 'none') $('.dashboard-main').removeClass('hide-main-section').addClass('show-main-section');
        $('.footer').css('visibility', 'visible');
    });

    $('#profile-btn').click(function() {
        var fname = $('#first_name').val();
        var lname = $('#last_name').val();
        if (fname != "" && lname != "") {
            $.ajax({
                type: "get",
                url: "profile.php",
                data: {
                    type: "profile",
                    fname: fname,
                    lname: lname
                },
                statusCode: {
                    500: function() {
                        createToast("Internal Server Error");
                    }
                },
                success: function(response) {
                    if (response == "1") {
                        createToast("Profile Updated");
                        $('.person-name').html(fname + ' ' + lname);
                        $('#first_name').css('border-bottom-color', '#ddd');
                        $('#last_name').css('border-bottom-color', '#ddd');
                    } else {
                        createToast("Please Try After Sometime");
                    }
                },
                error: function(response) {
                    createToast("Couldn't Connect To Server");
                }
            });
        } else {
            if (fname == "") $('#first_name').css('border-bottom-color', 'crimson');
            else $('#first_name').css('border-bottom-color', '#ddd');

            if (lname == "") $('#last_name').css('border-bottom-color', 'crimson');
            else $('#last_name').css('border-bottom-color', '#ddd');

            createToast("Name must be filled");
        }
    });

    $('#changepwd-btn').click(function() {
        var curr = $('#old_psw').val();
        var neww = $('#new_psw').val();
        var cnf = $('#cnf_new_psw').val();
        if (neww == cnf) {
            $.ajax({
                type: "get",
                url: "profile.php",
                data: {
                    type: "password",
                    curr: curr,
                    new: neww,
                    cnf: cnf
                },
                statusCode: {
                    500: function() {
                        createToast("Internal Server Error");
                    }
                },
                success: function(response) {
                    if (response == "1") {
                        createToast("Password Changed Successfully");
                    } else {
                        createToast("Invalid Current Password");
                    }
                },
                error: function(response) {
                    createToast("Please try after sometime");
                }
            });
        } else {
            createToast("Passwords don't match");
        }
    });

});
