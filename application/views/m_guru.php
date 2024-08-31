<h2>Daftar Panitia</h2>

<div class="my-buttons-card" style="margin: 16px 0;">
  <div>
    <button onclick="return aktifkan_semua_guru();" class="b b-info">
      <box-icon name='list-check' color='white' size="20px"></box-icon>
      Active All
    </button>
  </div>
  <div>
    <button onclick="m_guru_e(0);" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </button>
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

<div class="my-modal" id="modal-tambah-guru">
  <form name="f_guru" id="f_guru" onsubmit="return m_guru_s();" class="my-modal-content">
    <div class="my-modal-header">
      <button type="button" onclick="toggle_modal_by_id('#modal-tambah-guru')" class="my-modal-close-btn"><box-icon name='x'></box-icon></button>
      <div class="my-modal-title">Tambah Panitia</div>
      <div class="my-modal-description">Masukkan nama dan kode panitia dibawah.</div>
    </div>

    <div class="my-modal-body">
      <input type="hidden" name="id" id="id" value="0">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>
      <div class="mb-3">
        <label for="nip" class="form-label">Kode</label>
        <input type="number" class="form-control" id="nip" name="nip" required>
      </div>
    </div>

    <div class="my-modal-footer">
      <div class="d-flex justify-content-end gap-2">
        <button type="button" onclick="toggle_modal_by_id('#modal-tambah-guru')" class="b b-danger">Batalkan</button>
        <button type="submit" class="b b-primary">Simpan</button>
      </div>
    </div>
  </form>
</div>