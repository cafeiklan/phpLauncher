
<div class="row">
	<div class="span8">

		<?php
		if ($use_username) {
			$username = array(
					'name'	=> 'username',
					'id'	=> 'username',
					'value' => set_value('username'),
					'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
					'size'	=> 30,
			);
		}
		$email = array(
				'name'	=> 'email',
				'id'	=> 'email',
				'value'	=> set_value('email'),
				'maxlength'	=> 80,
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
		$captcha = array(
				'name'	=> 'captcha',
				'id'	=> 'captcha',
				'maxlength'	=> 8,
		);
		?>
		<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table">
			<?php if ($use_username) { ?>
			<tr>
				<td><?php echo form_label('用户名', $username['id']); ?></td>
				<td><?php echo form_input($username); ?></td>
				<td style="color: red;"><?php echo form_error($username['name']); ?>
					<?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td><?php echo form_label('邮箱', $email['id']); ?></td>
				<td><?php echo form_input($email); ?></td>
				<td style="color: red;"><?php echo form_error($email['name']); ?> <?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo form_label('密码', $password['id']); ?></td>
				<td><?php echo form_password($password); ?></td>
				<td style="color: red;"><?php echo form_error($password['name']); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo form_label('确认密码', $confirm_password['id']); ?>
				</td>
				<td><?php echo form_password($confirm_password); ?></td>
				<td style="color: red;"><?php echo form_error($confirm_password['name']); ?>
				</td>
			</tr>

			<?php if ($captcha_registration) {
				if ($use_recaptcha) { ?>
			<tr>
				<td colspan="2">
					<div id="recaptcha_image"></div>
				</td>
				<td><a href="javascript:Recaptcha.reload()">刷新验证码</a>
					<div class="recaptcha_only_if_image">
						<a href="javascript:Recaptcha.switch_type('audio')">Get an audio
							CAPTCHA</a>
					</div>
					<div class="recaptcha_only_if_audio">
						<a href="javascript:Recaptcha.switch_type('image')">Get an image
							CAPTCHA</a>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="recaptcha_only_if_image">输入上面的文字</div>
					<div class="recaptcha_only_if_audio">输入你听到的</div>
				</td>
				<td><input type="text" id="recaptcha_response_field"
					name="recaptcha_response_field" /></td>
				<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?>
				</td>
				<?php echo $recaptcha_html; ?>
			</tr>
			<?php } else { ?>
			<tr>
				<td><p>输入右边的验证码:</p></td>
				<td colspan="2"><?php echo $captcha_html; ?>
				</td>
			</tr>
			<tr>
				<td><?php echo form_label('验证码', $captcha['id']); ?></td>
				<td><?php echo form_input($captcha); ?></td>
				<td style="color: red;"><?php echo form_error($captcha['name']); ?>
				</td>
			</tr>
			<?php }
			} ?>
			<tr>
				<td></td>
				<td><?php echo form_submit('register', '注 册', "class='btn-success'"); ?>
				</td>
				<td></td>
			</tr>
			<?php echo form_close(); ?>
		</table>


	</div>
</div>
