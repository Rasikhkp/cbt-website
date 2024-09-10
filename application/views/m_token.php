<button class="b b-ghost mb-4" onclick="window.history.back()">
  <box-icon name='chevron-left' color='black'></box-icon>
</button>

<h2>Konfirmasi Identitas</h2>

<input type="hidden" name="id_ujian" id="id_ujian" value="<?php echo $du['id']; ?>">
<input type="hidden" name="_token" id="_token" value="<?php echo $du['token']; ?>">
<input type="hidden" name="_tgl_sekarang" id="_tgl_sekarang" value="<?php echo date('Y-m-d H:i:s'); ?>">
<input type="hidden" name="_tgl_mulai" id="_tgl_mulai" value="<?php echo $tgl_mulai; ?>">
<input type="hidden" name="_terlambat" id="_terlambat" value="<?php echo $terlambat; ?>">
<input type="hidden" name="_statuse" id="_statuse" value="<?php echo $du['statuse']; ?>">

<div class="test-result-info-card">
  <table>
    <tbody>
      <tr>
        <th>Nama</th>
        <th><?php echo $dp['nama']; ?></th>
      </tr>
      <tr>
        <td>Kode</td>
        <td><?php echo $dp['nim']; ?></td>
      </tr>
      <tr>
        <td>Panitia / Kategori</td>
        <td><?php echo $du['nmguru'] . " / " . $du['nmmapel']; ?></td>
      </tr>
      <tr>
        <td>Ujian</td>
        <td><?php echo $du['nama_ujian']; ?></td>
      </tr>
      <tr>
        <td>Soal</td>
        <td><?php echo $du['jumlah_soal']; ?></td>
      </tr>
      <tr>
        <td>Waktu</td>
        <td><?php echo $du['waktu']; ?> menit</td>
      </tr>
      <tr>
        <td>Token</td>
        <td>
          <input type=" text" name="token" id="token" required class="form-control">
        </td>
      </tr>
    </tbody>
  </table>
  <div style="color: #4D4D4D; width: 475px">
    <p style="font-weight: 600;"> Waktu mengerjakan ujian pada saat tombol “Mulai” berwarna hijau. </p>

    <div> Tetap tenang, fokus, dan percaya diri. Kamu pasti bisa! </div>
    <div id="pesan"> Selamat mengerjakan! </div>

    <br>

    <div class="b b-danger" id="waktu_" style="margin-bottom: 20px">
      Sisa waktu mengikuti ujian
      <span id="waktu_akhir_ujian"></span>
    </div>

    <div id="btn_mulai">Ujian akan mulai dalam <div id="akan_mulai"></div>
    </div>


    <div id="waktu_game_over"></div>
    <!-- <div id="waktu_" class="b b-danger" style="width: 100%; margin-bottom: 16px;">Sisa waktu mengikuti ujian <span id="waktu_akhir_ujian"></span></div> -->
    <!-- <button class="b b-success"><box-icon type='solid' name='flag-checkered' color="white"></box-icon>Mulai</button> -->
  </div>
</div>