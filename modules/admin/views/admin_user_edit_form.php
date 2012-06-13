<div class="modal hide fade" id="editmodal" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>修改用户信息</h3><small>密码为必须填写</small>
	</div>
	<div class="modal-body">
		<form action="<?php echo site_url("/admin/user_edit")?>" method="post"
			accept-charset="utf-8">
			<table class="table">
				<input type="hidden" name="id" value="<?php echo $user['id'];?>"
					id="id" />
				<tr>
					<td><label for="username">用户名</label></td>
					<td><input type="text" name="username"
						value="<?php echo $user['username'];?>" id="username"
						maxlength="20" size="30" /></td>
					<td style="color: red;"></td>
				</tr>
				<tr>
					<td><label for="password">密码</label></td>

					<td><input type="password" name="password" value="" id="password"
						maxlength="20" size="30" /></td>
					<td style="color: red;">*</td>
				</tr>
				<tr>
					<td><label for="confirm_password">确认密码</label></td>
					<td><input type="password" name="confirm_password" value=""
						id="confirm_password" maxlength="20" size="30" /></td>
					<td style="color: red;">*</td>
				</tr>


				<tr>
					<td><label for="role">权限类型</label></td>
					<td><select name="role">
							<option value="1"
							<?php echo $user["role_id"] == 1 ? "selected='selected'" : "";?>>管理员</option>
							<option value="2"
							<?php echo $user["role_id"] == 2 ? "selected='selected'" : "";?>>用户</option>
							
					</select>
					</td>

					<td style="color: red;"></td>
				</tr>

				<tr>
					<td></td>
					<td><input type="submit" name="register" value="修改"
						class='btn-success' /></td>
					<td></td>
				</tr>
				</form>
			</table>
	
	</div>
</div>
