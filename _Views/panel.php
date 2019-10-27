<?php
$jml_blockers = $this->db->get('iyh_blocker')->num_rows();
$jip = $this->db->get_where('iyh_blocker',['type' => 'ip'])->num_rows();
$jag = $this->db->get_where('iyh_blocker',['type' => 'agent'])->num_rows();
$jho = $this->db->get_where('iyh_blocker',['type' => 'host'])->num_rows();

?>

    <div class="content p-4">
        <h1 class="display-5 mb-4">HijaIyh Premium Redirect.</h1>

        <div class="row">
            <div class="col-md-3 col-lg-3 bg-danger text-white p-4">
                <h2><?=$jml_blockers;?></h2>
                    <p>All blockers</p>
            </div>
            <div class="col-md-3 col-lg-3 bg-warning text-white p-4">
                <h2><?=$jip;?></h2>
                    <p>Blocker IP</p>
            </div>
            <div class="col-md-3 col-lg-3 bg-success text-white p-4">
                <h2><?=$jag;?></h2>
                    <p>Blocker User-Agent</p>
            </div>
            <div class="col-md-3 col-lg-3 bg-primary text-white p-4">
                <h2><?=$jho;?></h2>
                    <p>Blocker Hostname</p>
            </div>
        </div><br><br>
    <div class="content-fluid bg-light p-4">
    <p>
        <b>HijaIyh PPR</b>, adalah tools script redirect yang di lapisi dengan blocker memungkinkan sistem untuk memfilter visitor dari bots. Adapun tools ini bisa di integrasi kan dengan platform Antibot.pw hanya dengan menambahkan APiKey dari Antibot.pw,
        Secara default script ini sudah ada blocker bawaan dan anda juga bisa menambah blocker sendiri.

        <i>- HijaIyh Project.</i>
    </p>
    </div>
</div> 


