<!-- <div class="row col-md-12 ini_bodi">
    <div class="panel panel-danger">
        <div class="panel-heading">Import Data Siswa
        </div>
        <div class="panel-body">
            <form name="f_siswa" action="<?php echo base_url(); ?>import/siswa" id="f_siswa" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <table class="table table-form">
                    <tr>
                        <td style="width: 25%">File</td>
                        <td style="width: 75%"><input type="file" class="form-control col-md-3" name="import_excel" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a href="<?php echo base_url(); ?>adm/m_siswa" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div> -->
<h2>Import Data Peserta</h2>

<div class="my-bank-soal-card">
    <form name="f_siswa" action="<?php echo base_url(); ?>import/siswa" id="f_siswa" enctype="multipart/form-data" method="post">
        <div class="mb-3">
            <label for="import_excel" class="form-label">File Peserta</label>
            <input class="form-control" type="file" name="import_excel" id="import_excel" required>
        </div>
        <div class="d-flex gap-2 mt-5">
            <a href="<?php echo base_url(); ?>adm/m_siswa" class="b b-danger">Kembali</a>
            <button class="b b-primary">Simpan</button>
        </div>
    </form>
</div>