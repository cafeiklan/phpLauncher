
<div class="row">
	<?php include "admin_siderbar.php" ?>
	<div class="span8">
		<?php 
		if ($error) {
			echo '<div class="alert alert-error">';
			echo '<a class="close" data-dismiss="alert" href="#">&times;</a>';
			echo $error[0];
			echo '</div>';
		}
		if ($success) {
			echo '<div class="alert alert-success">';
			echo '<a class="close" data-dismiss="alert" href="#">&times;</a>';
			echo $success[0];
			echo '</div>';
		}
		?>

		<h2>注册用户列表  &nbsp;&nbsp;&nbsp;<small><a href="#admin_add_form" data-toggle="modal"><i
						class="icon-plus-sign"></i> 添加账号</a></small></h2>
		<br />

		<table class="table table-striped">
			<thead>

				<tr>
					<th>#</th>
					<th class="yellow">用户名</th>
					<th class="blue">权限类型</th>
					<th class="red">操作</th>
				</tr>
			</thead>

			<tbody>
				<?php 
				foreach ($users as $index => $user){
					?>
				<tr>
					<td><?php echo $index + 1;?></td>
					<td><?php echo $user->username;?></td>
					<td><?php echo $user->role_id;?></td>
					<td><?php 
					echo '<a href="###" data-id="'. $user->id .'" class="edituser btn btn-info"><i class="icon-edit icon-white"></i>修改</a>';
					if ($user->role_id != 1) {
						echo '&nbsp;&nbsp;<a href="###" data-id="'. $user->id .'" class="deluser btn btn-danger"><i class="icon-trash icon-white"></i>删除</a>';
					}
					?>
					</td>
				</tr>
				<?php 
				}
				?>

			</tbody>
		</table>
		<div class="alert">
			<strong>说明：</strong> 权限类型中， <span class="label label-success">1</span>代表<strong>管理员</strong>，
			<span class="label label-success">2</span>代表<strong>普通用户</strong>。
		</div>
	</div>

</div>


<?php include "admin_user_add_form.php" ?>
<div class="placehoderhtml"></div>
