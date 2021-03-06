<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
// FORM SUBMIT AJAX
function ajaxSubmit(formId){
    $(formId).on('submit',function(){
        var form = $(this);
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function(data){
                form.find('input[type=submit]').attr('disabled','disabled');
                form.find('input[type=submit]').addClass('btn-disabled');
                form.find('button[type=submit]').attr('disabled','disabled');
                form.find('button[type=submit]').addClass('btn-disabled');
                $('#loading_ajax').show();
            },
            success: function(data) {
                if(data){
                    data = data.trim();
                    if(
                        data.slice(0,38)=='<script type="text/javascript">window.location.href' || 
                        data.slice(0,28)=='<script>window.location.href'
                    ){
                        $('#result_ajax').html(data);
                    }else{
                        var splitdata = data.split('|');

                        if(
                            splitdata[0]=='default' || 
                            splitdata[0]=='primary' || 
                            splitdata[0]=='secondary' || 
                            splitdata[0]=='success' || 
                            splitdata[0]=='warning' || 
                            splitdata[0]=='danger' || 
                            splitdata[0]=='info' || 
                            splitdata[0]=='light' || 
                            splitdata[0]=='dark' 
                        ){
                            $.notify(
                                {
                                    title: '<strong>'+splitdata[1]+'</strong>',
                                    message: splitdata[2],
                                },
                                {
                                    type: splitdata[0],
                                    placement: {
                                        align: 'center',
                                    },
                                },
                            );
                        } else {
                            $('#result_ajax').html(data);
                        }
                        $('#loading_ajax').hide();
                    }
                }
                form.find('input[type=submit]').removeAttr('disabled');
                form.find('input[type=submit]').removeClass('btn-disabled');
                form.find('button[type=submit]').removeAttr('disabled');
                form.find('button[type=submit]').removeClass('btn-disabled');
            }
        }).fail(function( e ) {
            $.notify(
                {
                    title: '<strong>ERROR</strong>',
                    message: 'Process Failed',
                },
                {
                    type: 'danger',
                    placement: {
                        align: 'center',
                    },
                },
            );
            form.find('input[type=submit]').removeAttr('disabled');
            form.find('input[type=submit]').removeClass('btn-disabled');
            form.find('button[type=submit]').removeAttr('disabled');
            form.find('button[type=submit]').removeClass('btn-disabled');

            $('#loading_ajax').delay( 800 ).fadeOut( 'slow' );
        });
        return false;
    });
}
</script>