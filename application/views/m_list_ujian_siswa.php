<h2 style="padding: 0 0 1.5rem 0; margin: 1rem 0 2rem 0; border-bottom: 2px solid #E0DBDB">Daftar Ujian</h2>

<div style="display: flex; gap: 40px; flex-wrap: wrap; width: 100%;">

  <?php if (!empty($data)) : ?>

    <?php foreach ($data as $d) : ?>

      <div class="exam-card">
        <div class="exam-card-body">
          <div style="font-weight: 500" class="mb-3"><?php echo $d->nama_ujian ?></div>

          <div class="d-flex justify-content-between align-items-center">
            <div class="py-1 px-3 rounded-5" style="font-size: 12px; border: 1px solid #67B173; color: grey"><?php echo $d->nmmapel ?></div>
            <div style="color: grey; font-size: 12px"><?php echo $d->jumlah_soal ?> Soal</div>
          </div>

          <div class="d-flex gap-3 align-items-center mt-3">
            <box-icon name="user" color="black" size="18px"></box-icon>
            <div style="font-size: 14px;"><?php echo $d->nmguru ?></div>
          </div>

          <div class="d-flex gap-3 align-items-center mt-2">
            <box-icon name="time-five" color="black" size="18px"></box-icon>
            <div style="font-size: 14px;"><?php echo $d->waktu ?> menit</div>
          </div>

          <div class="d-flex gap-3 align-items-center mt-2">
            <box-icon type='solid' name='flag-checkered' size="18px"></box-icon>
            <div style="font-size: 14px;"> <?php echo tjs($d->tgl_mulai, 's') ?></div>
          </div>

          <div class="d-flex gap-3 align-items-center mt-2">
            <box-icon name="block" color="black" size="18px"></box-icon>
            <div style="font-size: 14px;"> <?php echo tjs($d->terlambat, 's') ?></div>
          </div>
        </div>

        <div class="exam-card-footer">
          <?php
          if ($d->status == "Belum Ikut") {
            echo '<a style="width: 100%" href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-primary"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon>&nbsp;&nbsp;Ikuti Ujian</a>';
          } else if ($d->status == "Sedang Tes") {
            echo '<a style="width: 100%" href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-success"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon> &nbsp;&nbsp; <blink>Ujian Sdg Aktif</blink></a>';
          } else if ($d->status == "Waktu Habis") {
            echo '<a style="width: 100%" href="' . base_url() . 'adm/ikut_ujian/token/' . $d->id . '" target="_self" class="b b-warning"><box-icon type="solid" name="pencil" color="white" size="18px"></box-icon> &nbsp;&nbsp; <blink>Waktu Habis</blink></a>';
          } else {
            echo '<a style="width: 100%" href="' . base_url() . 'adm/sudah_selesai_ujian/' . $d->id . '" class="b b-danger"><box-icon name="check" color="white" size="18px"></box-icon> &nbsp;&nbsp;Anda sudah ikut</a>';
          }
          ?>

        </div>


      </div>
    <?php endforeach; ?>

  <?php else : ?>
    <h4 style="text-align: center; width: 100%;">Belum ada data</h4>
  <?php endif; ?>

</div>