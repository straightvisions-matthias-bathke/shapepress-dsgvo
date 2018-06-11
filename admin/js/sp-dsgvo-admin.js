(function($){
	
	$(document).ready(function(){

	    /************************
		* Settings
		*************************/
		$('.btn-settings').click(function(){
			if($(this).attr('data-state') == 'closed'){
				$('.btn-settings-show').show();
				$(this).attr('data-state', 'open');
				$(this).find('.state').html('Hide');
			}else{
				$('.btn-settings-show').hide();
				$(this).attr('data-state', 'closed');
				$(this).find('.state').html('Show');
			}
		});


		/************************
		* SAR
		*************************/
		$('#process_now').change(function(){
			var checkbox = document.getElementById('process_now');
			if(checkbox){
				if(checkbox.checked){
					$('#display_email').closest('tr').show();
				}else{
					$('#display_email').closest('tr').hide();
				}
			}
		});
		
		$('.cbChecklist').on('change', function () {
            var input = $(this).next('span');
            if (this.checked) {
                $(input).css('textDecoration', 'line-through');
            } else {
                $(input).css('textDecoration', 'none');
            }
            $('#checklist-form').submit();
        });

	});
})( jQuery );
