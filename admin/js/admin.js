(function($){

	$('.ctl_generate_link').on('click',function(){
		$.ajax({
            
            type: 'post',

            url: ctl_admin_ajax_object.ajaxurl,

            data: { action: 'ctl_create_link', create_user: "yes", ctl_security: ctl_admin_ajax_object.ctl_nonce_field },

            beforeSend: function(response) {

                $('.ctl-area .ctl-spinner').css({
					'display':'flex'
				});

            },

            complete: function(response) {

                $('.ctl-area .ctl-spinner').css({
					'display':'none'
				});

            },

            success: function(response) {
                console.log(response);
                window.location.reload();
            },

        });
	});

    $( 'a[class="ctl_token"]' ).on( 'click', function( event ){
        event.preventDefault();
        let $url = $(this).attr('data-url');
        // Calling a function
        copyToClipboard($url,$(this));

        if( $(this).find('span.ctl-tip').hasClass( 'ctl-tip-hidden' ) ){

            $(this).find('span.ctl-tip').removeClass('ctl-tip-hidden').addClass('ctl-tip-visible');

        }
        
    });


    // Copy to Clipboard
    function copyToClipboard($url,$this) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($url).select();
        if (!navigator.clipboard){
            document.execCommand("copy");
            $(document).trigger('ctl_tip_copied',[$url,$this]);
        } 
        else{
            navigator.clipboard.writeText($url).then(
                function(){
                    // success 
                    $(document).trigger('ctl_tip_copied',[$url,$this]);
                })
              .catch(
                 function() {
                    // error
            });
        } 
      
      $temp.remove();
    }

    $(document).on( 'ctl_tip_copied', function(event,$url,$this){

        setTimeout(function(){
            $this.find('span.ctl-tip').removeClass('ctl-tip-visible').addClass('ctl-tip-hidden');
        }, 2000);

    });



})(jQuery);