<div class="content p-4">
<div class="card">
	<div class="card card-header bg-danger">
		<h3 class="text-white">Add bot</h3>
	</div>
	<div class="card card-body">
	<?=form_open('hijaiyh/blockers/add');?>
	<label>Type</label>
	<select class="form-control" name="type">
		<option value="ip">IP</option>
		<option value="host">Hostname</option>
		<option value="agent">User-Agent</option>
	</select>
	<br>
	<label>Bots</label>
	<textarea class="form-control" style="height: 300px;width: 100%" name="bots"></textarea>
	<br><br>
	<input type="submit" name="submit" class="btn btn-success btn-block" value="Add bots">
	<?=form_close();?>	
	</div>
</div>
</div>