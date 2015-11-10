jQuery(function($) {    
    
   
        var progress = $('.donation-button-bar-percentage[data-percentage]');
        var percentage = Math.ceil(progress.attr('data-percentage'));        
        $({countNum: 0}).animate({countNum: percentage}, {
            duration: 300,
            easing: 'linear',
            step: function() {               
                var pct = '';                
                    pct = Math.floor(percentage) + '%';               
                progress.text(pct) && progress.siblings().children().css('width', pct);                
            }
        });

    
    var donation_button_progress_background = $('#donation_button_progress_background_color').val();
    var donation_button_bar_percentage_background = $('#donation_button_bar_percentage_background_color').val();
    var donation_button_bar_background = $('#donation_button_bar_background_color').val();
    var donation_button_bar_and_font = $('#donation_button_bar_and_font_color').val();
    var donation_button_preview_table_color = $('#donation_button_preview_table_color_color').val()
    
    $('.donation-button-bar-main-container').css('background', donation_button_progress_background);
    $('.donation-button-bar-percentage').css('background', donation_button_bar_percentage_background);
    $('.donation-button-bar-container').css('background-color', donation_button_bar_percentage_background);
    $('.donation-button-bar').css('background-color', donation_button_bar_background);
    $('.donation-button-bar-main-container').css('color', donation_button_bar_and_font);
    $('.donation_button_table_tbody_backgroud_color tr th').css('color', donation_button_preview_table_color);
    $('.donation_button_table_tbody_backgroud_color tr td').css('color', donation_button_preview_table_color);
    
    
    'use strict';
    $(document).ready(function() {
        $('#example').DataTable({
            "responsive": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false,
            "fnDrawCallback": function() {
                if (this.fnSettings().fnRecordsDisplay() > 10) {
                    $('#example_paginate').css("display", "block");
                } else {
                    $('#example_paginate').css("display", "none");
                }
            }

        });
        if ($('input[name="cmd"]').length > 0) {
            var cmdarray = ["_xclick", "_cart", "_oe-gift-certificate", "_xclick-subscriptions", "_xclick-auto-billing", "_xclick-payment-plan", "_donations", "_s-xclick"];
            if (cmdarray.indexOf($('input[name="cmd"]').val()) > -1) {
                if ($('input[name="bn"]').length > 0) {
                    $('input[name="bn"]').val("mbjtechnolabs_SP");
                } else {
                    $('input[name="cmd"]').after("<input type='hidden' name='bn' value='mbjtechnolabs_SP' />");
                }

            }
        }
    });
    
});
