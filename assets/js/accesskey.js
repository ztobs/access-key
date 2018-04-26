jQuery(document).ready(function(){
	jQuery('#accesskey-users').DataTable();

	

	tinymce.init({ 
		selector:'textarea#refresh_email_body',
		plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help code',
		toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
		menubar: 'file edit view insert format tools table help',
		image_advtab: true
	});
	tinymce.init({ 
		selector:'textarea#new_email_body',
		plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help code',
		toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
		menubar: 'file edit view insert format tools table help',
		image_advtab: true
	});
	tinymce.init({ 
		selector:'textarea#renew_email_body',
		plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help code',
		toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
		menubar: 'file edit view insert format tools table help',
		image_advtab: true
		 });

	jQuery('.mce-notification').hide();
	jQuery('.mce-notification-inner').hide();
});

	function refreshToken(user_id)
	{
		jQuery.ajax({
			url: ajaxurl,
			method: 'POST',
			dataType: 'json',
			data: {action:'ztobs_set_token', user_id:user_id},
			success: function(out_data){
				if(out_data['status'] == "ok") 
				{
					jQuery('#key_'+user_id).html(out_data['token']);
					notify("Success: User Token Regenerated", "notice-success");
				}
			}
		})
	}

	function notify(msg, type)
	{
		jQuery('.notice').removeClass('notice-success');
		jQuery('.notice').removeClass('notice-error');
		jQuery('.notice').removeClass('notice-info');
		jQuery('.notice').removeClass('notice-warning');
		jQuery('.notice p').html(msg);
		jQuery('.notice').addClass(type);
		jQuery('.notice').removeClass('hidden');
	}

	function updateKey()
	{
		var key = jQuery('#ztobs_admin_apikey').val();

		if(key.length < 32)
		{
			notify("Error: Minimum of 10 characters required", 'notice-error');
			return;
		}
		if(hasSpecialChar(key))
		{
			notify("Error: Special Characters except _ and - are not allowed", 'notice-error');
			return;
		}


		jQuery.ajax({
			url: ajaxurl,
			method: 'POST',
			data: {action:'ztobs_set_admin_api_key', key:key},
			success: function(out_data){
				if(out_data == 1) 
				{
					notify("Success: Admin API Updated", 'notice-success');
					jQuery('#usage-key').html(key);
				}
			}
		})
	}

	function rand()
	{
		var key = generate(32);
		jQuery.ajax({
			url: ajaxurl,
			method: 'POST',
			data: {action:'ztobs_set_admin_api_key', key:key},
			success: function(out_data){
				if(out_data == 1) 
				{
					notify("Success: Admin API Updated", 'notice-success');
					jQuery('#usage-key').html(key);
					jQuery('#ztobs_admin_apikey').val(key);
				}
			}
		})
	}

	function generate(len) {
	  var text = "";
	  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	  for (var i = 0; i <= len; i++)
	    text += possible.charAt(Math.floor(Math.random() * possible.length));

	  return text;
	}


	function hasSpecialChar(str)
	{
		var format = /[ !@#$%^&*()+=\[\]{};':"\\|,.<>\/?]/;
		return format.test(str);
	}

	function openTab(evt, tabName) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(tabName).style.display = "block";
	    evt.currentTarget.className += " active";
	}


	function update_others()
	{
		tinyMCE.triggerSave();
		var token_status_success = jQuery('#token_status_success').val();
		var token_status_invalid = jQuery('#token_status_invalid').val();
		var token_status_expired = jQuery('#token_status_expired').val();
		var email_sender_name = jQuery('#email_sender_name').val();
		var email_sender_email = jQuery('#email_sender_email').val();
		var refresh_email_subject = jQuery('#refresh_email_subject').val();
		var refresh_email_body = jQuery('#refresh_email_body').val();
		var send_refresh_email = jQuery('#send_refresh_email').prop('checked');
		var new_email_subject = jQuery('#new_email_subject').val();
		var new_email_body = jQuery('#new_email_body').val();
		var send_new_email = jQuery('#send_new_email').prop('checked');
		var renew_email_subject = jQuery('#renew_email_subject').val();
		var renew_email_body = jQuery('#renew_email_body').val();
		var send_renew_email = jQuery('#send_renew_email').prop('checked');
		var product_id = jQuery('#product_id').val();

		if(product_id == "")
		{
			jQuery('#product_id').css({
				'border': '1px solid red'
			});
			jQuery('#product_id').focus();
			return;
		}
		else
		{
			jQuery('#product_id').css({
				'border': '1px solid #f1f1f1'
			})
		}

		var in_data = {
			action: 'ztobs_update_others',
			token_status_success: token_status_success,
			token_status_invalid: token_status_invalid,
			token_status_expired: token_status_expired,
			email_sender_name: email_sender_name,
			email_sender_email: email_sender_email,
			refresh_email_subject: refresh_email_subject,
			refresh_email_body: refresh_email_body,
			send_refresh_email: send_refresh_email,
			new_email_subject: new_email_subject,
			new_email_body: new_email_body,
			send_new_email: send_new_email,
			renew_email_subject: renew_email_subject,
			renew_email_body: renew_email_body,
			send_renew_email: send_renew_email,
			product_id: product_id
		}

		jQuery.ajax({
			url: ajaxurl,
			method: 'POST',
			data: in_data,
			success: function(out_data){
				if(out_data == "ok") 
				{
					notify("Success: Other Settings Saved", 'notice-success');
				}
			}
		})
	}