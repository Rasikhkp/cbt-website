<!-- <div class="row col-md-12 ini_bodi">
    <div class="panel panel-danger">
        <div class="panel-heading">Import Data Soal
        </div>
        <div class="panel-body">
            <form name="f_siswa" action="<?php echo base_url(); ?>import/soal" id="f_siswa" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <table class="table table-form">
                    <tr>
                        <td style="width: 25%">Guru</td>
                        <td style="width: 75%">
                            <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control" id="id_guru" required'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td><?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control" id="id_mapel" required'); ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td><?php echo form_dropdown('id_kelas', $p_kelas, '', 'class="form-control" id="id_kelas" required'); ?></td>
                    </tr>
                    <tr>
                        <td>File</td>
                        <td><input type="file" class="form-control col-md-3" name="import_excel" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a href="<?php echo base_url(); ?>adm/m_soal" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div> -->
<h2>Import Data Soal</h2>

<div class="my-bank-soal-card">
    <form name="f_soal" action="<?php echo base_url(); ?>import/soal" id="f_soal" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label class="d-block form-label">Panitia</label>
            <select id="import-soal-guru" name="id_guru" class="mb-2" onchange="update_mapel_import()">
                <option data-display="Select">Pilih Panitia</option>
                <?php foreach ($p_guru as $el): ?>
                    <option value="<?php echo $el['id_guru']; ?>"><?php echo $el['nama']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3 mt-5">
            <label class="d-block form-label">Kategori</label>
            <select id="import-soal-mapel" class="mb-2" name="id_mapel">
                <option data-display="Select">Pilih Kategori</option>
            </select>
        </div>
        <div class="mb-3 mt-5">
            <label for="import_excel" class="form-label">File Soal</label>
            <input class="form-control" type="file" name="import_excel" id="import_excel" required>
        </div>
        <div class="d-flex gap-2 mt-5">
            <a href="<?php echo base_url(); ?>adm/m_soal" class="b b-danger">Kembali</a>
            <button class="b b-primary">Simpan</button>
        </div>
    </form>
</div>