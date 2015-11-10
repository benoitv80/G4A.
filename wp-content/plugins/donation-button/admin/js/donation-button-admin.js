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

    $('.donation_button_date').datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $('.donation_background_color_change').wpColorPicker();

    var donation_button_progress_background = $('#donation_button_progress_background').val();
    var donation_button_bar_percentage_background = $('#donation_button_bar_percentage_background').val();
    var donation_button_bar_background = $('#donation_button_bar_background').val();
    var donation_button_bar_and_font = $('#donation_button_bar_and_font').val();
    var donation_button_preview_table_color = $('#donation_button_preview_table_color').val();

    $('.donation-button-bar-main-container').css('background', donation_button_progress_background);
    $('.donation-button-bar-percentage').css('background', donation_button_bar_percentage_background);
    $('.donation-button-bar-container').css('background-color', donation_button_bar_percentage_background);
    $('.donation-button-bar').css('background-color', donation_button_bar_background);
    $('.donation-button-bar-main-container').css('color', donation_button_bar_and_font);
    $('.donation_button_table_tbody_backgroud_color tr th').css('color', donation_button_preview_table_color);
    $('.donation_button_table_tbody_backgroud_color tr td').css('color', donation_button_preview_table_color);


    $('.donation_button_pbg_reload_color').click(function() {
        var donation_button_progress_background = $('#donation_button_progress_background').val();
        $('.donation-button-bar-main-container').css('background', donation_button_progress_background);
    });
    $('.donation_button_bpg_reload_color').click(function() {
        var donation_button_bar_percentage_background = $('#donation_button_bar_percentage_background').val();
        $('.donation-button-bar-percentage').css('background', donation_button_bar_percentage_background);
        $('.donation-button-bar-container').css('background-color', donation_button_bar_percentage_background);
    });
    $('.donation_button_bb_reload_color').click(function() {
        var donation_button_bar_background = $('#donation_button_bar_background').val();
        $('.donation-button-bar').css('background-color', donation_button_bar_background);
    });
    $('.donation_button_bf_reload_color').click(function() {
        var donation_button_bar_and_font = $('#donation_button_bar_and_font').val();
        $('.donation-button-bar-main-container').css('color', donation_button_bar_and_font);
    });
    $('.donation_button_pt_color').click(function() {
        var donation_button_preview_table_color = $('#donation_button_preview_table_color').val();
        $('.donation_button_table_tbody_backgroud_color tr th').css('color', donation_button_preview_table_color);
        $('.donation_button_table_tbody_backgroud_color tr td').css('color', donation_button_preview_table_color);
    });
   
    $('.donation_button_goal_detail').on("focusout", function() {
        $('.label_donation_goal_detail').text($(this).val());
    });
     $('#donation_button_start_date').change(function(){
        $('.label_donation_goal_start_date').text($('#donation_button_start_date').val());
    });
     $('#donation_button_end_date').change(function(){
        $('.label_donation_goal_end_date').text($('#donation_button_end_date').val());
    });
    $('#donation_button_target_amount').on("focusout", function() {
        $('.label_donation_goal_target_amount_lbl').text($('#donation_button_target_amount').val());
    });    
    
    if ($('#chk_donation_goal_detail_click').is(":checked"))
    {
      $('#label_donation_goal_detail_tr').show();
    } else {
      $('#label_donation_goal_detail_tr').hide();
    }
    if ($('#chk_donation_target_amount_click').is(":checked"))
    {
      $('#label_donation_goal_target_amount_lbl_tr').show();
    } else {
      $('#label_donation_goal_target_amount_lbl_tr').hide();
    }
    if ($('#chk_donation_goal_start_date_click').is(":checked"))
    {
      $('#label_donation_goal_start_date_tr').show();
    } else {
      $('#label_donation_goal_start_date_tr').hide();
    }
    if ($('#chk_donation_goal_end_date_click').is(":checked"))
    {
      $('#label_donation_goal_end_date_tr').show();
    } else {
      $('#label_donation_goal_end_date_tr').hide();
    }
    if ($('#chk_donation_goal_display_paypal_donation_button_click').is(":checked"))
    {
      $('#label_donation_goal_display_paypal_donation_button_tr').show();
    } else {
      $('#label_donation_goal_display_paypal_donation_button_tr').hide();
    }
    
    $('#chk_donation_goal_detail_click').click(function(){
        if($(this).is(':checked')){
            $('#label_donation_goal_detail_tr').show();
        } else {
            $('#label_donation_goal_detail_tr').hide();
        }
    });
    $('#chk_donation_target_amount_click').click(function(){
        if($(this).is(':checked')){
            $('#label_donation_goal_target_amount_lbl_tr').show();
        } else {
            $('#label_donation_goal_target_amount_lbl_tr').hide();
        }
    });
    $('#chk_donation_goal_start_date_click').click(function(){
        if($(this).is(':checked')){
            $('#label_donation_goal_start_date_tr').show();
        } else {
            $('#label_donation_goal_start_date_tr').hide();
        }
    });
    $('#chk_donation_goal_end_date_click').click(function(){
        if($(this).is(':checked')){
            $('#label_donation_goal_end_date_tr').show();
        } else {
            $('#label_donation_goal_end_date_tr').hide();
        }
    });
    $('#chk_donation_goal_display_paypal_donation_button_click').click(function(){
        if($(this).is(':checked')){
            $('#label_donation_goal_display_paypal_donation_button_tr').show();
        } else {
            $('#label_donation_goal_display_paypal_donation_button_tr').hide();
        }
    });    
    $(".donation_button_target_amount").keydown(function (e) {
           if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
               return;
           }
           if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
               e.preventDefault();
           }
       });
    
    $("#donation_button_twilio_test_sms_button").live("click", function() {      
        var donation_button_twilio_sms_test_mobile_number = $("#donation_button_twilio_sms_test_mobile_number").val();
        var donation_button_twilio_sms_test_message = $("#donation_button_twilio_sms_test_message").val();
        var data = {
            action: 'donation_button_twilio_send_test_sms',            
            donation_button_twilio_sms_test_mobile_number: donation_button_twilio_sms_test_mobile_number,
            donation_button_twilio_sms_test_message: donation_button_twilio_sms_test_message
        };
        $.post(donation_button_twilio_test_sms_button_params.ajax_url, data, function (response) {
            response = JSON.parse(response);
            if (typeof (response.success) !== 'undefined') {
                if (response.success.length > 0) {
                    alert(response.success);
                } else {
                    alert(response.error);
                }
            } else {
                alert(response.error);
            }
        });  
    });
});