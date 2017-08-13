// feature detection for drag&drop upload
var isAdvancedUpload = function() {
    var div = document.createElement( 'div' );
    return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
}();

var $form = $('.box');
var $input = $form.find('input[type="file"]');
var $label = $form.find('label');
var $restart = $form.find('.box__restart');
var $errorMsg = $form.find('.error-details');
var $showFiles = function(files) {
    $label.text(files.length>1 ? ($input.attr('data-multiple-caption') || '').replace('{count}', files.length): files[0].name);
};

if (isAdvancedUpload) {
    $form.addClass('has-advanced-upload');
    var droppedFiles = false;
    $form.on('drag, dragstart dragend dragover dragenter dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    $form.on('dragover dragenter', function() {
        $form.addClass('is-dragover');
    });
    $form.on('dragleave dragend drop', function() {
        $form.removeClass('is-dragover');
    });
    $form.on('drop', function(e) {
        droppedFiles = e.originalEvent.dataTransfer.files;
        $showFiles(droppedFiles);
    });
}

$form.on('submit', function(e) {
    if($form.hasClass('is-uploading')) {
        return false;
    }
    $form.addClass('is-uploading').removeClass('is-error');
    if(isAdvancedUpload) {
        e.preventDefault();
        var ajaxData = new FormData($form.get(0));
        if(droppedFiles) {
            $.each(droppedFiles, function(i, file) {
                ajaxData.append($input.attr('name'), file);
            });
        }
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: ajaxData,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                $('.upload-progress-bar').css('visibility','visible');
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            complete: function() {
                $form.removeClass('is-uploading');
            },
            success: function(data) {
                $form.addClass( data.success == true ? 'is-success' : 'is-error' );
                if (!data.success) {
                    $errorMsg.text(data.error);
                }else {
                }
            },
            error: function(data) {
                alert("error: " + JSON.stringify(data));
            }
        });
    }
    else {
        var iframeName  = 'uploadiframe' + new Date().getTime();
        $iframe   = $('<iframe name="' + iframeName + '" style="display: none;"></iframe>');

        $('body').append($iframe);
        $form.attr('target', iframeName);

        $iframe.one('load', function() {
            var data = JSON.parse($iframe.contents().find('body' ).text());
            $form
                .removeClass('is-uploading')
                .addClass(data.success == true ? 'is-success' : 'is-error')
                .removeAttr('target');
            if (!data.success) $errorMsg.text(data.error);
            $form.removeAttr('target');
            $iframe.remove();
        });
    }
});

$restart.on( 'click', function( e )
{
    e.preventDefault();
    $form.removeClass( 'is-error is-success' );
    $input.val("");
    $label.html("<strong>Choose a file</strong> or drag it here");
});

$input.on('change', function (e) {
    $showFiles(e.target.files);
});

// Firefox focus bug fix for file input
$input
    .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
    .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });

function progress(e){
    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;
        var Percentage = (current * 100)/max;
        $('.upload-progress-value').text(Math.ceil(Percentage) + " %");
        $('.upload-progress-container').css('width',Percentage + "%");
        console.log(Percentage);
        if(Percentage >= 100) {
            window.setTimeout(function() {
                $('.upload-progress-bar').css('visibility','hidden');
            }, 1000);
        }
    }
}
