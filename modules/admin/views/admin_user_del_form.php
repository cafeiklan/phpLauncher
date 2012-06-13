					<div class="modal hide fade"
						id="delmodal"
						style="display: none;">
						<div class="modal-header">
							<a class="close" data-dismiss="modal">×</a>
							<h3>确认删除该用户?</h3>
						</div>
						<div class="modal-body">
							<p>
								用户名：
								<?php echo $user['username'];?>
							</p>
							<p>
								权限类型：
								<?php echo $user['role_id'];?>
							</p>

						</div>
						<div class="modal-footer">
							<a href="<?php echo site_url('/admin/user_del/' . $user['id']) ?>"
								class="btn btn-danger">确定删除</a>
						</div>
					</div>