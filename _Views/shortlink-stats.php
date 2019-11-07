<?php

$idlink =$this->uri->segment(4);//echo $idlink;
$q = $this->db->get_where('iyh_link',['id_link' => $idlink])->row();

$allow = $this->db->get_where('iyh_stats' ,['id_link' => $idlink , 'status' => 'allow'])->num_rows();
$visitor = $this->db->get_where('iyh_stats',['id_link' => $idlink])->num_rows();
$block1 = $this->db->get_where('iyh_stats',['id_link' => $idlink , 'status' => 'block'])->num_rows();
$block2 = $this->db->get_where('iyh_stats',['id_link' => $idlink , 'status' => 'antibot.pw_block'])->num_rows();
$block = ($block1+$block2);

?>
<table class="table">
    <tr><td>URL</td><td><?=$q->link;?></td></tr>
    <tr><td>Cloak</td><td><?=$q->cloak;?></td></tr>
    <tr><td>Short</td><td><?=$q->short;?></td></tr>
    <tr><td>Access</td><td><?=base_url($q->short);?></td></tr>
</table>
<div class="row">
    <div class="col-md-4 col-lg-4 bg-warning text-white p-3">
      <i class="fa fa-sign-in-alt fa-3x"></i> <b>Visitor</b> <h1 style="float:right"><?=$visitor;?></h1>
</div>
<div class="col-md-4 col-lg-4 bg-success text-white p-3">
<i class="fa fa-check fa-3x"></i> <b>Allow</b> <h1 style="float:right"><?=$allow;?></h1>
</div>
<div class="col-md-4 col-lg-4 bg-danger text-white p-3">
<i class="fa fa-times fa-3x"></i> <b>Block</b> <h1 style="float:right"><?=$block;?></h1>
</div>
</div>

<table class="table table-striped table-hover table-border" id="datatable">
    <thead>
        <th>Status</th><th>Description<th>Device</th><th>Browser</th><th>Platform</th><th>IP Address</th><th>Country</th>
</thead>
<tbody>
<?php
$q2 = $this->db->get_where('iyh_stats',['id_link' => $idlink]);
foreach($q2->result() as $row)
{
    if($row->status == 'allow')
    {
        $status = '<font color=green><b>ALLOW</b></font>';
    }else{
        $status ='<font color=red><b>BLOCK</b></font>';
    }
    echo "<tr>";
    echo "<td>".$status."</td>";
    echo "<td>".$row->description."</td>";
    echo "<td>".$row->device."</td>";
    echo "<td>".$row->browser."</td>";
    echo "<td>".$row->platform."</td>";
    echo "<td>".$row->ip."</td>";
    echo "<td>".$row->country."</td>";
    echo "</tr>";
}
?>
</tbody>
</table>