<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-danger">
    <div class="panel-heading"><b>DAFTAR UJIAN</b></div>
    <div class="panel-body">
      <div style="overflow: auto">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="10%">Nama Ujian</th>
              <th width="20%">Kategori/Panitia</th>
              <th width="3%">Jumlah Soal</th>
              <th width="5%">Waktu</th>
              <th width="10%">Status</th>
              <th width="15%">Tanggal Mulai</th>
              <th width="10%">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {

                echo '<tr>
                        <td class="ctr">' . $no . '</td>
                        <td>' . $d->nama_ujian . '</td>
                        <td>' . $d->nmmapel . '/' . $d->nmguru . '</td>
                        <td class="ctr">' . $d->jumlah_soal . '</td>
                        <td class="ctr">' . $d->waktu . ' menit</td>
                        <td class="ctr">' . $d->status . '</td>
                        <td class="ctr">' . $d->tgl_mulai . '</td>
                        <td class="ctr">';

                if ($d->status == "Belum Ikut") {
                  echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Ikuti Ujian</a>';
                } else if ($d->status == "Sedang Tes") {
                  echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Ujian Sdg Aktif</blink></a>';
                } else if ($d->status == "Waktu Habis") {
                  echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
                } else {
                  echo '<a href="' . base_url() . 'adm/sudah_selesai_ujian/' . $d->id . '" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-ok" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Anda sudah ikut</a>';
                }

                echo '</td></tr>';
                $no++;
              }
            } else {
              echo '<tr><td colspan="7">Belum ada data</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div> -->

<!-- <pre>
  <?php print_r($data); ?>
</pre> -->

<h2 style="padding: 0 0 1.5rem 0; margin: 1rem 0 2rem 0; border-bottom: 2px solid #E0DBDB">Daftar Ujian</h2>

<div style="display: flex; gap: 40px; flex-wrap: wrap; width: 100%;">

  <?php if (!empty($data)) : ?>

    <?php foreach ($data as $d) : ?>

      <div style="min-width: 400px; border-radius: 16px; padding: 20px; background-color: white; border: 2px solid #E0DBDB">
        <h3><?php echo $d->nama_ujian; ?></h3>
        <div style="margin: 40px 0px 40px 0px; display: flex; gap: 40px; font-weight: 500">
          <div style="color: #B2B2B2; display: flex; flex-direction: column; gap: 8px">
            <div>Kategori</div>
            <div>Panitia</div>
            <div>Waktu</div>
            <div>Mulai</div>
            <div>Berakhir</div>
            <div>Jumlah Soal</div>
          </div>
          <div style="display: flex; flex-direction: column; gap: 8px">
            <div><?php echo $d->nmmapel; ?></div>
            <div><?php echo $d->nmguru; ?></div>
            <div><?php echo $d->waktu; ?> menit</div>
            <div><?php echo $d->tgl_mulai; ?></div>
            <div><?php echo $d->terlambat; ?></div>
            <div>2</div>
          </div>
        </div>
        <?php

        if ($d->status == "Belum Ikut") {
          echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-primary"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon>&nbsp;&nbsp;Ikuti Ujian</a>';
        } else if ($d->status == "Sedang Tes") {
          echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-success"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon> &nbsp;&nbsp; <blink>Ujian Sdg Aktif</blink></a>';
        } else if ($d->status == "Waktu Habis") {
          echo '<a href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-warning"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
        } else {
          echo '<a href="' . base_url() . 'adm/sudah_selesai_ujian/' . $d->id . '" class="b b-danger"><box-icon name="check" color="white" size="18px" ></box-icon> &nbsp;&nbsp;Anda sudah ikut</a>';
        }
        ?>
      </div>

    <?php endforeach; ?>

  <?php else : ?>
    <h4 style="text-align: center; width: 100%;">Belum ada data</h4>
  <?php endif; ?>

</div>