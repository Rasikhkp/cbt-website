<h2>Daftar Peserta Ujian</h2>

<div class="my-buttons-card" style="margin: 16px 0;">
  <div>
    <button onclick="return m_siswa_hs();" class="b b-danger">
      <box-icon name='brush-alt' color='white' size="20px"></box-icon>
      Delete All
    </button>
    <button onclick="return aktifkan_semua_siswa();" class="b b-info">
      <box-icon name='list-check' color='white' size="20px"></box-icon>
      Active All
    </button>
  </div>
  <div>
    <a href="#" onclick="return m_siswa_e(0);" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </a>
    <a href="<?php echo base_url(); ?>upload/format_import_siswa.xlsx" class="b b-success">
      <box-icon name='download' color='white' size="20px"></box-icon>
      Download Format Import
    </a>
    <a href="<?php echo base_url(); ?>adm/m_siswa/import" class="b b-warning">
      <box-icon name='upload' color='white' size="20px"></box-icon>
      Import
    </a>
  </div>
</div>

<div class="my-table-card">
  <div id="wrapper"></div>
</div>

<div class="my-modal" id="modal-tambah-peserta">
  <form name="f_siswa" id="f_siswa" onsubmit="return m_siswa_s();" class="my-modal-content">
    <div class="my-modal-header">
      <button type="button" onclick="toggle_modal_by_id('#modal-tambah-peserta')" class="my-modal-close-btn"><box-icon name='x'></box-icon></button>
      <div class="my-modal-title">Data Peserta</div>
      <div class="my-modal-description">Masukkan nama dan kode peserta dibawah.</div>
    </div>

    <div class="my-modal-body">
      <input type="hidden" name="id" id="id" value="0">
      <div style="display: grid; grid-template-columns: 1fr 4fr; gap: 16px 40px">
        <label for="nama" class="form-label text-end">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
        <label for="nim" class="form-label text-end">Kode</label>
        <input type="number" class="form-control" id="nim" name="nim" required>
      </div>
    </div>

    <div class="my-modal-footer">
      <div class="d-flex justify-content-end gap-2">
        <button type="button" onclick="toggle_modal_by_id('#modal-tambah-peserta')" class="b b-danger">Batalkan</button>
        <button type="submit" class="b b-primary">Simpan</button>
      </div>
    </div>
  </form>
</div>