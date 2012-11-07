
<div class="row">
	<div class="span12">

  <form class="form-horizontal" id="apply_form">
    <fieldset>
      <div id="legend" class="">
        <legend class="">申请表</legend>
      </div>
	<div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="sitename">名称</label>
          <div class="controls">
            <input type="text" placeholder="" class="input-xlarge" id="site_name" name="site_name">
            <p class="help-block"></p>
          </div>
        </div>


    

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">网址</label>
          <div class="controls">
            <input type="text" placeholder="" class="input-xlarge"  id="site_url" name="site_url">
            <p class="help-block"></p>
          </div>
        </div>


<div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="email">邮箱</label>
          <div class="controls">
            <input type="text" placeholder="" class="input-xlarge" id="site_mgr_mail" name="site_mgr_mail">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">
          <label class="control-label">Banner</label>

          <!-- File Upload -->
		  <div class="controls">
			<div id="banner_pic" style="width:220px;height:30px;">
			</div>
            <input type="hidden"  id="banner_url" name="banner_url">
			<div id="banner_display">
			</div>
          </div>
        </div>

	

    <div class="control-group">
          <label class="control-label"></label>

          <!-- Button -->
          <div class="controls">
			<button type="submit" class="btn btn-success">提交</button>
          </div>
        </div>

    </fieldset>
  </form>

	</div>
</div>
<script src="<?php echo  base_url("/plugins/iupload/i_upload.js") ?>" type="text/javascript" ></script>
<?php 
display_js(array('jquery.validate.min.js', 'test.form.js', 'test.upload.js')); 
?>

