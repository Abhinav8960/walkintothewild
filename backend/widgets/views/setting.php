<!-- <h4 class="popupButton" value="/">open modal</h4> -->
<div id="popupmodal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="max-width: 90% !important;">
		<div class="modal-content">
			<div class="modal-header">
				<button class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
					<!-- <span aria-hidden="true">×</span> -->
				</button>

			</div>
			<div class="modal-body">
				<div id='modalContent'></div>
			</div>

		</div>
	</div>
</div>




<?php
$script = <<< JS

		function popupButton_Script() {
			$('.popupButton').unbind( 'click' ).click( function () {
				$('#popupmodal').modal('show')
				.find('#modalContent')
				.load($(this).attr('value'));
				
				var formid = $(this).attr("data-id");

				$('#popupmodal').on('shown.bs.modal', function (e) {
					var form =jQuery('#'+formid);
					form.on('beforeSubmit', function(e) {
						var submit = form.find(':submit');
						submit.html('<span class="fa fa-spin fa-spinner"></span> Processing...');
						submit.prop('disabled', true);
						e.preventDefault();
						jQuery.ajax({
							url: form.attr('action'),
								type: form.attr('method'),
								data: new FormData(form[0]),
								mimeType: 'multipart/form-data',
								contentType: false,
								cache: false,
								processData: false,
								dataType: 'json',
								success: function (data) {
									if(data.success === true){
										$('#popupmodal').modal('hide');
									}
								},
								error  : function (e)
								{
									console.log(e);
								}   
						});
						return false;        
					})
					if (formid) {
						$('#popupmodal form')[0].reset();
					}
					
				});
			});
		}

		popupButton_Script();
        
JS;
$this->registerJs($script);
?>