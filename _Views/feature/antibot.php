<div class="content p-4">
<?php
$integrated = $this->db->query("SELECT * FROM iyh_users WHERE id_users='".$this->session->id_users."' ")->row();
if($integrated->antibot_apikey != '' || !empty($integrated->antibot_apikey))
{
	?>
	<div class="alert alert-success"> Cool ! It's was integrated with antibot.pw</div>
	<div class="alert alert-primary"><b>ANTIBOT APIKEY : <i><?=$integrated->antibot_apikey;?></i></b></div>
	<a class="btn btn-danger text-white" href="<?=base_url('feature/antibot/delete');?>">Remove / Change apikey</a>
	<?php
}else{
?>
<?=form_open('feature/antibot/save');?>
<label>INPUT ANTIBOT.PW APIKEY</label>
<input type="text" name="apikey" class="form-control"><br>
<input type="submit" name="submit" class="btn btn-primary btn-block" value="Integrate">
<?=form_close();?>
</div>

<?php
}