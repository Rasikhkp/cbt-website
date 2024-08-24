<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-danger">
    <div class="panel-heading"><b>WELCOME TO DASHBOARD</b></div>
    <div class="panel-body">
      <div class="alert alert-success">Assalamualaikum <b><?php echo $this->session->userdata('admin_nama') . "</b>. Username Anda: <b>" . $sess_user; ?></b></div>
    </div>
  </div>
</div>
</div> -->

<h2>Selamat Datang di Home</h2>

<div>Halo <span style="font-weight: 500;"><?php echo $this->session->userdata('admin_nama') ?></span>. Username anda adalah <span style="font-weight: 500;"><?php echo $sess_user ?></span></div>