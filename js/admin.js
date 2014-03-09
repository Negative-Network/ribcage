
jQuery(document).ready(function($) {

    var custom_uploader;

//    $('#upload_image_button').click(function(e) {
    $('body').on('click','.file_upload_button',function(e) {

        e.preventDefault();
        var element = $(this).prev('input.file_upload');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose File',
            button: {
                text: 'Choose File'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            element.val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });


});
