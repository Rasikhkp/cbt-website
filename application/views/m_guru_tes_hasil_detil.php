<?php
$uri4 = $this->uri->segment(4);
?>

<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-danger">
    <div class="panel-heading"><b>DAFTAR HASIL UJIAN</b>
      <div class="tombol-kanan">
        <a href='<?php echo base_url(); ?>adm/hasil_ujian_cetak/<?php echo $uri4; ?>' class='btn btn-success btn-sm' target='_blank'><i class='glyphicon glyphicon-print'></i> Cetak</a>
      </div>
    </div>
    <div class="panel-body">

      <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
        <div class="col-md-6">
          <table class="table table-bordered" style="margin-bottom: 0px">
            <tr>
              <td>Kategori</td>
              <td><?php echo $detil_tes->namaMapel; ?></td>
            </tr>
            <tr>
              <td>Panitia</td>
              <td><?php echo $detil_tes->nama_guru; ?></td>
            </tr>
            <tr>
              <td width="30%">Nama Ujian</td>
              <td width="70%"><?php echo $detil_tes->nama_ujian; ?></td>
            </tr>
            <tr>
              <td>Waktu</td>
              <td><?php echo $detil_tes->waktu; ?> menit</td>
            </tr>
          </table>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-6">
          <table class="table table-bordered" style="margin-bottom: 0px">
            <tr>
              <td width="30%">Jumlah Soal</td>
              <td><?php echo $detil_tes->jumlah_soal; ?></td>
            </tr>
            <tr>
              <td>Tertinggi</td>
              <td><?php echo $statistik->max_; ?></td>
            </tr>
            <tr>
              <td>Terendah</td>
              <td><?php echo $statistik->min_; ?></td>
            </tr>
            <tr>
              <td>Rata-rata</td>
              <td><?php echo number_format($statistik->avg_); ?></td>
            </tr>
          </table>
        </div>
      </div>


      <table class="table table-bordered" id="datatabel">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="40%">Nama Peserta</th>
            <th width="15%">Jumlah Benar</th>
            <th width="15%">Nilai</th>
            <th width="15%">Nilai Bobot</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>

        <tbody>
        </tbody>
      </table>

    </div>
  </div>
</div>
</div> -->
<button class="b b-ghost" onclick="window.history.back()">
  <box-icon name='chevron-left' color='black'></box-icon>
</button>

<h2 class="mt-4">Hasil Ujian</h2>

<!-- <div class="my-buttons-card" style="margin: 16px 0;">
  <div>

  </div>
  <div>
    <a href="<?php echo base_url(); ?>adm/m_soal/edit/0" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </a>
    <a href="<?php echo base_url(); ?>upload/format_soal_download.xlsx" class="b b-success">
      <box-icon name='download' color='white' size="20px"></box-icon>
      Download Format Import
    </a>
    <a href="<?php echo base_url(); ?>adm/m_soal/import" class="b b-warning">
      <box-icon name='upload' color='white' size="20px"></box-icon>
      Import
    </a>
  </div>
</div> -->



<div class="test-result-info-card">
  <table>
    <tbody>
      <tr>
        <td>Kategori</td>
        <td><?php echo $detil_tes->namaMapel; ?></td>
      </tr>
      <tr>
        <td>Panitia</td>
        <td><?php echo $detil_tes->nama_guru; ?></td>
      </tr>
      <tr>
        <td>Nama Ujian</td>
        <td><?php echo $detil_tes->nama_ujian; ?></td>
      </tr>
      <tr>
        <td>Waktu</td>
        <td><?php echo $detil_tes->waktu; ?> menit</td>
      </tr>
    </tbody>
  </table>
  <table style="width: 200px">
    <tbody>
      <tr>
        <td>Jumlah Soal</td>
        <td><?php echo $detil_tes->jumlah_soal; ?></td>
      </tr>
      <tr>
        <td>Tertinggi</td>
        <td><?php echo $statistik->max_; ?></td>
      </tr>
      <tr>
        <td>Terendah</td>
        <td><?php echo $statistik->min_; ?></td>
      </tr>
      <tr>
        <td>Rata-rata</td>
        <td><?php echo number_format($statistik->avg_); ?></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="my-table-card">
  <div id="wrapper"></div>
</div>