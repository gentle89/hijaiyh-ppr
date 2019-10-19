<script>
function toggle(source) {
  checkboxes = document.getElementsByName('blocker[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<div class="content p-4">

<?php
if($this->uri->segment(3) == 'new'){
    ?>
<div class="card">
<div class="card card-header">
<h3>Create new shortlink</h3>
</div>
<div class="card card-body">
<?=form_open('hijaiyh/shortlink/create');?>
<label>URL </label>
<input type="url" name="url" class="form-control" >
<br>
<label>Cloak Url </label>
<input type="url" name="cloak" class="form-control">
<br>
<label>Custom shortlink <small>* Leave blank if using random shortlink</small></label>
<input type="text" name="custom" class="form-control" minglenght="6">
<br>
<label>Blocker </label><br>
[ <input type="checkbox" onClick="toggle(this);"> Select All ]
[ <input type="checkbox" name="blocker[]" value="ip"> Block IP ] [ <input type="checkbox" name="blocker[]" value="host"> Block Hostname ] [ <input type="checkbox" name="blocker[]" value="agent"> Block UserAgent ]
<?php
$q = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users])->row();
if($q->antibot_apikey != ''){
    ?>[ <input type="checkbox" name="blocker[]" value="antibot"> ANTIBOT.PW ]
<?php
}
?>
<br><br>
<input type="submit" class="btn btn-primary btn-block" name="submit" value="Create shortlink">
</form>
</div>
</div>

<?php
}elseif($this->uri->segment(3) == 'all')
{
    ?>
    <table class="table table-striped table-hover" id="datatable">
        <thead>
            <th>No</th><th>Shortlink</th><th>URL</th><th>Cloak URL</th><th>Visitor</th><th>Action</th>
        </thead>
        <tbody>
            <?php
            $no=1;
            $q = $this->db->get_where('iyh_link' , ['id_users' => $this->session->userdata('id_users')]);
            foreach($q->result() as $row)
            {
                $visitor = $this->db->get_where('iyh_stats' ,['id_link' => $row->id_link])->num_rows();
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".$row->short."</td>";
                echo "<td>".$row->link."</td>";
                echo "<td>".$row->cloak."</td>";
                echo "<td>".$visitor."</td>";
                echo "<td>";
                echo "<a href='".base_url('hijaiyh/shortlink/edit/'.$row->id_link)."'>Edit</a> | ";
                echo "<a href='".base_url('hijaiyh/shortlink/delete/'.$row->id_link)."'>Delete</a> | ";
                echo "<a href='".base_url($row->short)."' target='_blank'>Visit</a> | ";
                echo "<a href='".base_url('hijaiyh/shortlink/stats/'.$row->id_link)."'>Stats</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
}elseif($this->uri->segment(3) == 'delete')
{
    $this->db->delete('iyh_link',['id_link' => $this->uri->segment(4) , 'id_users' => $this->session->userdata('id_users')]);
    $this->db->delete('iyh_stats',['id_link' => $this->uri->segment(4)]);
    redirect(base_url('hijaiyh/shortlink/all'));
}elseif($this->uri->segment(3) == 'edit')
{
    $value = $this->db->get_where('iyh_link',['id_link' => $this->uri->segment(4) , 'id_users' => $this->session->userdata('id_users')])->row();
    ?>
    <div class="card">
<div class="card card-header">
<h3>Edit shortlink</h3>
</div>
<div class="card card-body">
<?=form_open('hijaiyh/shortlink/update/'.$this->uri->segment(4));?>
<label>URL </label>
<input type="url" name="url" class="form-control" value="<?=$value->link;?>" >
<br>
<label>Cloak Url </label>
<input type="url" name="cloak" class="form-control" value="<?=$value->cloak;?>">
<br>
<label>Shortlink</label>
<input type="text" name="custom" class="form-control" minlenght="6" value="<?=substr($value->short,3,6);?>">
<br>
<label>Blocker </label><br>
[ <input type="checkbox" onClick="toggle(this);"> Select All ]
[ <input type="checkbox" name="blocker[]" value="ip"> Block IP ] [ <input type="checkbox" name="blocker[]" value="host"> Block Hostname ] [ <input type="checkbox" name="blocker[]" value="agent"> Block UserAgent ]<?php
$q = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users])->row();
if($q->antibot_apikey != ''){
    ?>[ <input type="checkbox" name="blocker[]" value="antibot"> ANTIBOT.PW ]
<?php
}
?><br><br>
<input type="submit" class="btn btn-primary btn-block" name="submit" value="Save shortlink">
</form>
</div>
</div>
<?php

}elseif($this->uri->segment(3) == 'stats')
{
    require_once('shortlink-stats.php');
}

?>
</div>