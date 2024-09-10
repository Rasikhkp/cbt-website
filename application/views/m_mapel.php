<h2>Data Kategori</h2>

<div class="my-buttons-card" style="margin: 16px 0;">
  <div></div>
  <div>
    <a href="#" onclick="return m_mapel_e(0);" class="b b-primary">
      <box-icon name='plus' color='white' size="20px"></box-icon>
      Tambah
    </a>
  </div>
</div>

<div class="my-table-card">
  <div id="wrapper"></div>
</div>

<div class="my-modal" id="modal-tambah-kategori">
  <form name="f_mapel" id="f_mapel" onsubmit="return m_mapel_s();" class="my-modal-content">
    <div class="my-modal-header">
      <button type="button" onclick="toggle_modal_by_id('#modal-tambah-kategori')" class="my-modal-close-btn"><box-icon name='x'></box-icon></button>
      <div class="my-modal-title">Data Kategori</div>
      <div class="my-modal-description">Masukkan nama kategori dibawah.</div>
    </div>

    <div class="my-modal-body">
      <input type="hidden" name="id" id="id" value="0">
      <div style="display: grid; grid-template-columns: 1fr 4fr; gap: 16px 40px">
        <label for="nama" class="form-label text-end">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>
    </div>

    <div class="my-modal-footer">
      <div class="d-flex justify-content-end gap-2">
        <button type="button" onclick="toggle_modal_by_id('#modal-tambah-kategori')" class="b b-danger">Batalkan</button>
        <button type="submit" class="b b-primary">Simpan</button>
      </div>
    </div>
  </form>
</div>