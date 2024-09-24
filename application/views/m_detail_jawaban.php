<button class="b b-ghost mb-4" onclick="window.history.back()">
    <box-icon name='chevron-left' color='black'></box-icon>
</button>

<h2>Detail Jawaban</h2>

<div class="test-result-info-card">
    <table>
        <tbody>
            <tr>
                <td>Panitia</td>
                <td><?php echo $detail['nama_guru']; ?></td>
            </tr>
            <tr>
                <td>Nama Ujian</td>
                <td><?php echo $detail['nama_ujian']; ?></td>
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td><?php echo $detail['nama_siswa']; ?></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 200px">
        <tbody>
            <tr>
                <td>Benar/Salah</td>
                <td><?php echo $detail['jml_benar'] . '/' . ($detail['jumlah_soal'] - $detail['jml_benar']); ?></td>
            </tr>
            <tr>
                <td>Nilai</td>
                <td><?php echo $detail['nilai']; ?></td>
            </tr>
            <tr>
                <td>Nilai Bobot</td>
                <td><?php echo $detail['nilai_bobot']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="gap-3" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));">
    <?php
    $counter = 1;
    foreach ($soal as $el):
    ?>
        <div style="border-radius: 8px; width: 100%; height: fit-content; background-color: white" class="p-4 border">
            <div style="color: #625E5E" class="d-flex justify-content-between">
                <div class="fw-medium">Soal <?php echo $counter; ?></div>
                <div style="font-size: 14px"><span style="color: #B7B7B7">Bobot</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $el['bobot']; ?></div>
            </div>

            <div style="color: #3B3B3B; font-size: 14px" class="mt-2"><?php echo $el['soal']; ?></div>

            <div class="mt-2">
                <?php
                $options = ['a', 'b', 'c', 'd', 'e'];
                foreach ($options as $option) {
                    $isCorrect = $el['jawaban'] == $option;
                    $isUserAnswer = $el['jawaban_siswa'] == $option;

                    $border = '';
                    $icon = '';
                    if ($isUserAnswer && $isCorrect) {
                        $border = 'border: 1px solid green';
                        $icon = "<box-icon name='check' color='green' ></box-icon>";
                    } elseif ($isUserAnswer && !$isCorrect) {
                        $border = 'border: 1px solid red';
                        $icon = " <box-icon name='x' color='red'></box-icon>";
                    } elseif (!$isUserAnswer && $isCorrect) {
                        $icon = "<box-icon name='check' color='green' ></box-icon>";
                    }
                ?>
                    <div class="d-flex py-2 px-3 justify-content-between mb-2 align-items-center" style="border-radius: 8px; font-size: 14px; <?= $border ?>">
                        <div class="d-flex gap-3">
                            <div><?= strtoupper($option) ?>.</div>
                            <div id="jawaban"><?= $el['opsi_' . $option] ?></div>
                        </div>

                        <?= $icon ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
        $counter++;
    endforeach;
    ?>


</div>