<div class="modal hide fade" id="admin_add_form" style="display: none;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>新增用户</h3>
	</div>
	<div class="modal-body">


		<?php
		$username = array(
				'name'	=> 'username',
				'id'	=> 'username',
				'value' => set_value('username'),
				'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
				'size'	=> 30,
		);

		$password = array(
				'name'	=> 'password',
				'id'	=> 'password',
				'value' => set_value('password'),
				'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
				'size'	=> 30,
		);
		$confirm_password = array(
				'name'	=> 'confirm_password',
				'id'	=> 'confirm_password',
				'value' => set_value('confirm_password'),
				'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
				'size'	=> 30,
		);

		$role = array(
				'name'	=> 'role',
				'id'	=> 'role',
				//'value' => set_select('role'),
				'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
				'size'	=> 30,
				'options' => array(
						'1'  => '管理员',
						'2'  => '用户'
				)
		);

		?>
		<?php echo form_open(site_url("/admin/user_add")); ?>
		<table class="table">
			<tr>
				<td><?php echo form_label('用户名', $username['id']); ?></td>
				<td><?php echo form_input($username); ?></td>
				<td style="color: red;">*<?php echo form_error($username['name']); ?>
					<?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo form_label('密码', $password['id']); ?></td>
				<td><?php echo form_password($password); ?></td>
				<td style="color: red;">*<?php echo form_error($password['name']); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo form_label('确认密码', $confirm_password['id']); ?></td>
				<td><?php echo form_password($confirm_password); ?></td>
				<td style="color: red;">*<?php echo form_error($confirm_password['name']); ?>
				</td>
			</tr>

			<tr>
				<td><?php echo form_label('权限类型', $role['id']); ?></td>
				<td><?php 
				echo form_dropdown($role['name'], $role['options'], '2'); ?></td>
				<td style="color: red;"><?php echo form_error($role['name']); ?> <?php echo isset($errors[$role['name']])?$errors[$role['name']]:''; ?>
				</td>
			</tr>

			<tr>
				<td></td>
				<td><?php echo form_submit('register', '增加用户', "class='btn-primary'"); ?>
				</td>
				<td></td>
			</tr>
			<?php echo form_close(); ?>
		</table>




	</div>
</div>
