jQuery(document).ready(function(){
    jQuery('body').find('.select_player').show();  
    jQuery('body').find('.game_result').hide();  
    jQuery('body').on('click','#Send_into_Battle' , function(e){
        e.preventDefault();
        if (!jQuery('.unit').is(":checked")) { 
            alert('Select any player');
            return false;
        } else{
            var unitVal = jQuery('input[name="unit"]:checked').val();
            var loopRound ='';
            
            //console.log(unitVal);
            
            jQuery.ajax({
                url:rating_Ajax.ajaxurl,
                type:"POST",
                data:{'action':'game_result_func','unitVal':unitVal},
                success:function(res){
                    //console.log(res);
                    //jQuery('body').find('.select_player').hide();
                    
                    //setTimeout(function(){
                       // alert();
                        jQuery('body').find('.select_player').hide(); 
                        jQuery('body').find('.game_result').show();
                        
                        var defaultRoudVal = jQuery('body').find('#get_round').val(); 
                        if(defaultRoudVal==''){
                            //alert('blank='+defaultRoudVal);
                            loopRound = '19';
                            jQuery('body').find('.game_result').html(res);
                        } else if(defaultRoudVal== 0){
                            setTimeout(function(){
                                jQuery('body').find('.game_result').html(res);
                                jQuery('body').find('.result_continue').css('display','none');
                                jQuery('body').find('.result_stop').css('display','block');
                            },500);

                        } else {
                            loopRound = defaultRoudVal;
                            //alert('filled='+defaultRoudVal);
                            jQuery('body').find('.game_result').html(res);
                        }  
                        //alert('loopRound='+loopRound);

                        //jQuery('body').find('.game_result').html(res);
                        

                        setTimeout(function(){
                            jQuery('body #oldrounds').val(loopRound);
                            jQuery('body .round_countdown').text(loopRound+' rounds remaining');
                            
                            //jQuery('body #oldrounds').addClass('loopRound');
                        },500);
                    //},500);
                }
            });
        }
        //jQuery('body').find('.select_player').hide();  
        //jQuery('body').find('.game_result').show();  
        
    });  

    jQuery('body').on('click','#next_round' , function(e){
        e.preventDefault();
        jQuery('body').find('.select_player').show(); 
        jQuery('body').find('.game_result').hide();
        setTimeout(function() {
            var oldrounds = jQuery('body').find('#oldrounds').val();
            console.log(oldrounds);
            var retunround = oldrounds-1;
            console.log(retunround);
            jQuery('body').find('#get_round').val(retunround);
        },300);

    });  

    
})