jQuery(document).ready(function($){
    $('#subscriber-form').submit(function(e){
        
        e.preventDefault();

        //serialize FormData
        var subscriberData = $('#subscriber-form').serialize();

        //submit form
        $.ajax({
            type: "post",
            url: $('#subscriber-form').attr('action'),
            data: subscriberData
        }).done(function(response){
            $('.form-msg').removeClass('error');
            $('.form-msg').addClass('success');
            //set response 
            $('.form-msg').text(response);
            //clear fields
            $("#name").val('');
            $('#email').val('');
        }).fail(function(data){
            $('.form-msg').removeClass('success');
            $('.form-msg').addClass('error');
            if(data.responseText !== ""){
                $('.form-msg').text(data.responseText);
            }else{
                $('.form-msg').text("Something went wrong");
            }
            
        });
    });
});