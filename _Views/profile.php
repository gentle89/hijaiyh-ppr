
   <div class="content p-4">
   	<?=form_open('hijaiyh/profile/save');?>
   	<table class="table">
   		<tr>
   			<td>Username</td><td><input type="text" name="username" class="form-control" value="<?=$this->session->username;?>"></td></tr>
   			<tr>
   			<td>Email</td><td><input type="text" name="email" class="form-control" value="<?=$this->session->email;?>"></td></tr>
   			<tr>
   			<td>Old password</td><td><input type="password" name="old_password" class="form-control"></td>
   		</tr><tr>
   			<td>New Password</td><td><input type="password" name="new_password" class="form-control"></td></tr>
   			<tr>
   			<td colspan="2"><input type="submit" name="submit" class="btn btn-success btn-block" value="Save"></td>
   		</tr>
   	</table>
   	<?=form_close();?>
   </div>