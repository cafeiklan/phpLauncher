$(function(){
	$('#apply_form').validate(
	{
		rules: {
			site_name: {
			  minlength: 2,
			  required: true
			  
			},
			site_mgr_mail: {
			  required: true,
			  email: true
			}
		},
		messages: {
			site_name: {
			  minlength: "最少需要2个字符",
			  required: "该字段为必须"			  
			},
			site_mgr_mail: {
			  required: "该字段为必须",
			  email: "邮箱格式不正确"
			}
		},
		highlight: function(label) {
		$(label).closest('.control-group').addClass('error');
		},
		success: function(label) {
		label
		  .text('OK!').addClass('valid')
		  .closest('.control-group').addClass('success');
		}
	});	
});
