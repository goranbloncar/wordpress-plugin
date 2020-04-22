window.addEventListener("load", function() {

    // store tabs variables
    var tabs = document.querySelectorAll("ul.nav-tabs > li");

    for (var i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", switchTab);
    }

    function switchTab(event) {
        event.preventDefault();

        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");

        var clickedTab = event.currentTarget;
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");

        clickedTab.classList.add("active");
        document.querySelector(activePaneID).classList.add("active");

    }

});


jQuery(document).ready(function () {
    //image uploader
    jQuery(document).on('click', '.image-upload', function (e) {
        e.preventDefault();
        var $button = jQuery(this);

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload an Image',
            library: {
                type: 'image' // mime type
            },
            button: {
                text: 'Select Image'
            },
            multiple: false
        });

        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $button.siblings('.image-upload').val(attachment.url);
        });

        file_frame.open();
    });

    //datepicker
    jQuery('input.datepicker').datepicker({ dateFormat: 'dd-mm' }).val();

    //adding and removing inputs to working hours
    var url = window.location.origin;
    
    var click = 0;
    jQuery('.add-wh').click(function () {
        var buttonValue = jQuery(this).val()
        click += 1;
        jQuery.ajax({
            url: url + "/wp-json/torchlight/v1/torch-input",
            type: "POST",
            dataType: "json",
            data: {
                'optionName': buttonValue,
                'click' : click
            }
        }).done(function (data) {
            var x = JSON.parse(data);
            jQuery('#' + x[0]).closest('tbody').append(x[1]);
        });
    });

    var clickDate = 0;
    jQuery('.add-date').click(function () {
        var buttonValue = jQuery(this).val()
        clickDate += 1;
        jQuery.ajax({
            url: url + "/wp-json/torchlight/v1/torch-date",
            type: "POST",
            dataType: "json",
            data: {
                'optionName': buttonValue,
                'click' : clickDate
            }
        }).done(function (data) {
            var x = JSON.parse(data);
            jQuery('#' + x[0]).closest('tbody').append(x[1]);
            jQuery('input.datepicker').datepicker({ dateFormat: 'dd-mm' }).val();
        });
    });

    jQuery('.form-table').on('click','.remove-wh', function () {
        var divRemove = jQuery(this).val();
        var split = divRemove.split(" ");
        jQuery('.' + split[0]).remove();
        jQuery('.' + split[1]).remove();
    });

});