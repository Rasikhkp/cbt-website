<h2>Import Data Panitia</h2>

<div class="my-bank-soal-card">
    <form name="f_guru" action="<?php echo base_url(); ?>import/guru" id="f_guru" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label for="import_excel" class="form-label">File panitia</label>
            <input class="form-control" type="file" name="import_excel" id="import_excel" required>
        </div>
        <div class="d-flex gap-2 mt-5">
            <a href="<?php echo base_url(); ?>adm/m_guru" class="b b-danger">Kembali</a>
            <button class="b b-primary">Simpan</button>
        </div>
    </form>
</div>