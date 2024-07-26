<!-- <div class="row col-md-12 ini_bodi">
  <div class="panel panel-danger">
    <div class="panel-heading">Input Soal</div>
    <div class="panel-body">
      <?php echo form_open_multipart(base_url() . "adm/m_soal/simpan", "class='form-horizontal'"); ?>
      <input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">
      <input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
      <div id="konfirmasi"></div>

      <div class="form-group fgsoal">
        <div class="col-md-2"><label>Kategori</label></div>
        <div class="col-md-10"><?php echo form_dropdown('id_mapel', $p_mapel, $d['id_mapel'], 'class="form-control" id="id_mapel" required'); ?></div>
      </div>
      <div class="form-group fgsoal">
        <div class="col-md-2"><label>Panitia</label></div>
        <div class="col-md-10"><?php echo form_dropdown('id_guru', $p_guru, $d['id_guru'], 'class="form-control" id="id_guru" required'); ?></div>
      </div>
      <div class="form-group fgsoal">
        <div class="col-md-2"><label>Teks Soal</label></div>
        <div class="col-md-3">
          <input type="file" name="gambar_soal" id="gambar_soal" class="btn btn-info upload">
          <?php
          if (is_file('./upload/gambar_soal/' . $d['file'])) {
            echo tampil_media('./upload/gambar_soal/' . $d['file'], "100%");
          }
          ?>
        </div>
        <div class="col-md-7">
          <textarea class="form-control" id="editornya" style="height: 50px;" name="soal"><?php echo $d['soal']; ?></textarea>
        </div>
      </div>

      <?php
      for ($j = 0; $j < $jml_opsi; $j++) {
        $idx = $huruf_opsi[$j];
      ?>
        <div class="form-group fgsoal">
          <div class="col-md-2"><label>Jawaban <?php echo $huruf_opsi[$j]; ?></label></div>
          <div class="col-md-3">
            <input type="file" name="gj<?php echo $huruf_opsi[$j]; ?>" id="gambar_soal" class="btn btn-success upload"><br>
            <?php
            if (is_file('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'])) {
              echo tampil_media('./upload/gambar_opsi/' . $data_pc[$idx]['gambar'], "100%");
            }
            ?>
          </div>
          <div class="col-md-7">
            <textarea class="form-control" id="editornya_<?php echo $huruf_opsi[$j]; ?>" style="height: 30px" name="opsi_<?php echo $huruf_opsi[$j]; ?>"><?php echo $data_pc[$idx]['opsi']; ?></textarea>
          </div>
        </div>

      <?php } ?>

      <div class="form-group fgsoal">
        <div class="col-md-2"><label>Kunci Jawaban</label></div>
        <div class="col-md-2">
          <select class="form-control" name="jawaban" id="jawaban" required>
            <?php
            for ($o = 0; $o < $jml_opsi; $o++) {
              $_opsi = strtoupper($huruf_opsi[$o]);
              if ($d['jawaban'] == $_opsi) {
                echo '<option value="' . $_opsi . '" selected>' . $_opsi . '</option>';
              } else {
                echo '<option value="' . $_opsi . '">' . $_opsi . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-2"><label>Bobot Nilai Soal</label></div>
        <div class="col-md-1"><input type="text" name="bobot" class="form-control" required value="<?php echo $d['bobot']; ?>"></div>
      </div>
      <div class="form-group" style="margin-top: 20px">
        <div class="col-md-12">
          <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Simpan</button>
          <a href="<?php echo base_url(); ?>adm/m_soal/pilih_mapel/<?php echo $d['id_mapel']; ?>" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div> -->

<h2>Input Soal</h2>

<form action="<?php echo base_url() . "adm/m_soal/simpan" ?>" method="POST" class="my-bank-soal-card">
  <input type="hidden" name="mode" id="mode" value="<?php echo $d['mode']; ?>">
  <input type="hidden" name="id" id="id" value="<?php echo $d['id']; ?>">

  <h3>Informasi</h3>
  <table class="table table-bordered" style="width: 50%">
    <tbody>
      <tr>
        <td style=" width: 200px; font-weight: 600;">
          <div style="padding-top: 10px; width: fit-content">Panitia</div>
        </td>
        <td>
          <select name="id_guru" id="id_guru" onchange="update_mapel()">
            <option data-display="Select">Pilih Panitia</option>
          </select>
        </td>
        </td>
      </tr>
      <tr>
        <td style="width: 200px; font-weight: 600;">
          <div style="padding-top: 10px; width: fit-content">Kategori</div>
        </td>
        <td>
          <select name="id_mapel" id="id_mapel" placeholder="Pilih Kategori">
            <option data-display="Select">Pilih Kategori</option>
          </select>
        </td>
      </tr>

      <tr>
        <td style=" width: 200px; font-weight: 600;">
          <div style="padding-top: 8px; width: fit-content">Bobot Nilai</div>
        </td>
        <td>
          <input name="bobot" type="number" class="form-control" style="width: 40px; text-align: center" value="<?php echo $d['bobot']; ?>">
        </td>
      </tr>
    </tbody>
  </table>

  <hr>

  <h3 style="margin-bottom: 1rem;">Soal</h3>
  <p style="margin-bottom: 2rem;">Isi soal di bawah ini</p>

  <textarea name="soal" id="soal"><?php echo $d['soal']; ?></textarea>

  <hr>

  <h3 style="margin-bottom: 1rem;">Jawaban</h3>
  <p style="margin-bottom: 2rem;">Isi teks jawaban, kemudian pilih jawaban yang benar</p>

  <div class="jawaban">
    <input <?php echo $d['jawaban'] == 'a' ? 'checked' : '' ?> type="radio" id="a" name="jawaban" value="a">
    <label for="a" class="kunci-button">A</label>
    <textarea name="opsi_a" id="opsi_a"><?php echo $d['opsi_a']; ?></textarea>
  </div>
  <div class="jawaban">
    <input <?php echo $d['jawaban'] == 'b' ? 'checked' : '' ?> type="radio" id="b" name="jawaban" value="b">
    <label for="b" class="kunci-button">B</label>
    <textarea name="opsi_b" id="opsi_b"><?php echo $d['opsi_b']; ?></textarea>
  </div>
  <div class="jawaban">
    <input <?php echo $d['jawaban'] == 'c' ? 'checked' : '' ?> type="radio" id="c" name="jawaban" value="c">
    <label for="c" class="kunci-button">C</label>
    <textarea name="opsi_c" id="opsi_c"><?php echo $d['opsi_c']; ?></textarea>
  </div>
  <div class="jawaban">
    <input <?php echo $d['jawaban'] == 'd' ? 'checked' : '' ?> type="radio" id="d" name="jawaban" value="d">
    <label for="d" class="kunci-button">D</label>
    <textarea name="opsi_d" id="opsi_d"><?php echo $d['opsi_d']; ?></textarea>
  </div>
  <div class="jawaban">
    <input <?php echo $d['jawaban'] == 'e' ? 'checked' : '' ?> type="radio" id="e" name="jawaban" value="d">
    <label for="e" class="kunci-button">E</label>
    <textarea name="opsi_e" id="opsi_e"><?php echo $d['opsi_e']; ?></textarea>
  </div>

  <div style="margin-top: 4rem; justify-content: end; display: flex; gap: 1rem;">
    <button class="b b-danger" type="button" onclick="window.history.back()">Batalkan</button>
    <button class="b b-primary">Simpan</button>
  </div>
</form>