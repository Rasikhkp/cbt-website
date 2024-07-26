<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-warning">
    <div class="panel-heading"><b>DAFTAR PANITIA</b>
      <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_guru_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
        <a class="btn btn-warning btn-sm tombol-kanan" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="glyphicon glyphicon-download"></i> &nbsp;&nbsp;Download Format Import</a>
        <a class="btn btn-primary btn-sm tombol-kanan" href="<?php echo base_url(); ?>adm/m_guru/import"><i class="glyphicon glyphicon-upload"></i> &nbsp;&nbsp;Import</a>
      </div>
    </div>
    <div class="panel-body">
      <a href="#" onclick="return aktifkan_semua_guru();" class="btn btn-success" style="margin-bottom: 10px"><i class="fa fa-users"></i> &nbsp;<b>ACTIVE ALL</b></a>
      <table class="table table-bordered" id="datatabel">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="40%">Nama</th>
            <th width="20%">Kode</th>
            <th width="35%">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>
  </div>
</div>
</div>

<div class="modal fade" id="m_guru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data PANITIA</h4>
      </div>
      <div class="modal-body">
        <form name="f_guru" id="f_guru" onsubmit="return m_guru_s();">
          <input type="hidden" name="id" id="id" value="0">
          <table class="table table-form">
            <tr>
              <td style="width: 25%">Kode</td>
              <td style="width: 75%"><input type="text" class="form-control" name="nip" id="nip" required></td>
            </tr>
            <tr>
              <td style="width: 25%">Nama</td>
              <td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
            </tr>
          </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div> -->

<h2>Daftar Panitia</h2>

<div class="my-buttons-card" style="margin: 16px 0;">
  <div>
    <button onclick="return aktifkan_semua_guru();" class="b b-info">
      <box-icon name='list-check' color='white' size="20px"></box-icon>
      Active All
    </button>
  </div>
  <div>
    <a href="#" onclick="return m_guru_e(0);" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </a>
    <a href="<?php echo base_url(); ?>upload/format_import_guru.xlsx" class="b b-success">
      <box-icon name='download' color='white' size="20px"></box-icon>
      Download Format Import
    </a>
    <a href="<?php echo base_url(); ?>adm/m_guru/import" class="b b-warning">
      <box-icon name='upload' color='white' size="20px"></box-icon>
      Import
    </a>
  </div>
</div>

<div class="my-table-card">
  <div id="wrapper"></div>
</div>

<div class="modal fade" id="m_guru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data Panitia</h4>
      </div>
      <div class="modal-body">
        <form name="f_guru" id="f_guru" onsubmit="return m_guru_s();">
          <input type="hidden" name="id" id="id" value="0">
          <table class="table table-form">
            <tr>
              <td style="width: 25%">Nama</td>
              <td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td>
            </tr>
            <tr>
              <td style="width: 25%">Kode</td>
              <td style="width: 75%"><input type="text" class="form-control" name="nip" id="nip" required></td>
            </tr>
            <!-- <tr>
              <td style="width: 25%">Kelas</td>
              <td style="width: 75%">
                <select name="jurusan" id="jurusan" class="form-control" required>
                  <option value="">Pilih salah satu</option>
                  <?php foreach ($kelas as $baris) : ?>
                    <option value="<?php echo $baris->kelas; ?>"><?php echo $baris->kelas; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <td style="width: 25%">Jurusan</td>
              <td style="width: 75%">
                <select name="id_jurusan" id="id_jurusan" class="form-control" required>
                  <option value="">Pilih salah satu</option>
                  <?php foreach ($jurusan as $baris) : ?>
                    <option value="<?php echo $baris->jurusan; ?>"><?php echo $baris->jurusan; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr> -->
          </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>