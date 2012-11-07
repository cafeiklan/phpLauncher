<?php
$allowedTypes = array("image/gif","image/jpeg","image/pjpeg","image/png","image/x-png");
$fieldName = 'iuploadFile';
$uploadDir = 'uploads/';
$json = array();

$prefix = $_SERVER['HTTP_HOST'].'/'.str_replace( 'upload.php', '', $_SERVER['REQUEST_URI'] ).'/';
$prefix = 'http://'.str_replace('//','/', $prefix);

if( in_array( $_FILES[$fieldName]["type"], $allowedTypes )){
  
  if( $_FILES[$fieldName]["error"] > 0 ){
    $json['status'] = 'error';
    $json['message']= $_FILES[$fieldName]["error"];
    
  }else{
    
    if(move_uploaded_file( $_FILES[$fieldName]["tmp_name"], $uploadDir . $_FILES[$fieldName]["name"] )){
      $json['status'] = 'success';
      $json['file'] = $prefix.$uploadDir . $_FILES[$fieldName]["name"];
    }else{
      $json['status'] = 'error';
      $json['message']= 'could not move uploaded file';
    }
  }
  
}else{
  $json['status'] = 'error';
  $json['message'] = 'File type '. stripslashes($_FILES[$fieldName]["type"]).' is not allowed';
}
?>

<script type="text/javascript" charset="utf-8">
  window.response = <?php echo json_encode($json); ?>;
</script>

