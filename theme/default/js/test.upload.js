$(function(){
	var uploader = new dpm.IUpload( {
		container:'#banner_pic',
		action:WEB_ROOT + "/plugins/iupload/upload.php",
		iframe_src:WEB_ROOT + "/plugins/iupload/iframe.html",
		label:"上传Banner"
	} );  

	uploader.uploadComplete = function(response){
	  if( response.status == "success" ){
		$("#banner_url").val(response.file);
		$('#banner_display').html('<img src="'+response.file+'" width="220px" />');
	  }else{
		alert(response.message);
	  }
	};	
});
