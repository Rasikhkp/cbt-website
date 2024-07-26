<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-danger">
    <div class="panel-heading"><b>DAFTAR UJIAN</b>
      <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_ujian_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
      </div>
    </div>
    <div class="panel-body">


      <table class="table table-bordered" id="datatabel">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Tes</th>
            <th width="15%">Kategori</th>
            <th width="5%">Jumlah Soal</th>
            <th width="5%">Kelas/Jurusan</th>
            <th width="15%">Waktu</th>
            <th width="10%">Pengacakan Soal</th>
            <th width="15%">Aksi</th>
          </tr>
        </thead>

        <tbody></tbody>
      </table>

    </div>
  </div>
</div>
</div> -->

<h2>Daftar Ujian</h2>

<div class="my-buttons-card" style="margin: 16px 0;">
  <div>
  </div>
  <div>
    <a href="#" onclick="return m_ujian_e(0);" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </a>
  </div>
</div>

<div class="my-table-card">
  <div id="wrapper"></div>
</div>

<div class="modal fade" id="m_ujian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">PENGATURAN UJIAN</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <a href="#" onclick="return view_petunjuk('petunjuk');"><b>PETUNJUK PEMBUATAN UJIAN</b></a>
          <div id="petunjuk">
            <ul>
              <li><b>Jumlah Soal</b>, masukkan sesuai jumlah soal di bank soal</li>
              <li><b>Tanggal Mulai</b>, waktu awal boleh mulai meng-klik tombol "mulai ujian"</li>
              <li><b>Tanggal Selesai</b>, waktu akhir boleh mulai meng-klik tombol "mulai ujian"</li>
              <li><b>Pengacakan Soal</b>, jika dipilih acak, maka soal akan diacak, jika diurutkan, maka akan diurutkan berdasarkan urutan soal masuk</li>
            </ul>
          </div>
        </div>

        <form name="f_ujian" id="f_ujian" onsubmit="return m_ujian_s();">
          <input type="hidden" name="id" id="id" value="0">
          <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
          <table class="table table-form">
            <tr>
              <td style="width: 25%">Nama Ujian</td>
              <td style="width: 75%"><input type="text" class="form-control" name="nama_ujian" id="nama_ujian" required></td>
            </tr>
            <tr>
              <td>Kategori</td>
              <td><?php echo form_dropdown('mapel', $p_mapel, '', 'class="form-control"  id="mapel" required'); ?></td>
            </tr>
            <tr>
              <td>Jumlah soal</td>
              <td><?php echo form_input('jumlah_soal', '', 'class="form-control"  id="jumlah_soal" required'); ?></td>
            </tr>
            <!-- <tr>
              <td style="width: 25%">Kelas</td>
              <td style="width: 75%">
                <select name="kelas" id="kelas" class="form-control" required>
                  <?php foreach ($kelas as $baris) : ?>
                    <option value="<?php echo $baris->kelas; ?>"><?php echo $baris->kelas; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <td style="width: 25%">Jurusan</td>
              <td style="width: 75%">
                <select name="jurusan" id="jurusan" class="form-control" required>
                  <?php foreach ($jurusan as $baris) : ?>
                    <option value="<?php echo $baris->jurusan; ?>"><?php echo $baris->jurusan; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr> -->
            <tr>
              <td>Tgl Mulai</td>
              <td>
                <input type="date" name='tgl_mulai' class="form-control" style="width: 150px; display: inline; float: left" id="tgl_mulai" placeholder="Tgl" data-tooltip="waktu awal boleh menge-klik tombol \" mulai\" ujian" required>
                <input type="time" name='wkt_mulai' class="form-control" style="width: 150px; display: inline; float: left" id="wkt_mulai" placeholder="Waktu" required>
              </td>
            </tr>
            <tr>
              <td>Tgl Selesai</td>
              <td>
                <input type="date" name='terlambat' class="form-control" style="width: 150px; display: inline; float: left" id="terlambat" placeholder="Tgl" required>
                <input type="time" name='terlambat2' class="form-control" style="width: 150px; display: inline; float: left" id="terlambat2" placeholder="Waktu" required>
              </td>
            </tr>
            <tr>
              <td>Waktu Ujian</td>
              <td><?php echo form_input('waktu', '', 'class="form-control" id="waktu" placeholder="menit" required style="width: 100px; display: inline; float: left"'); ?> <div style="float: left; margin: 4px 0 0 10px"> menit</div>
              </td>
            </tr>
            <tr>
              <td>Acak Soal</td>
              <td><?php echo form_dropdown('acak', $pola_tes, '', 'class="form-control"  id="acak" required'); ?></td>
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
</div>