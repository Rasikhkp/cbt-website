<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard - <?php echo $this->config->item('nama_aplikasi') . " " . $this->config->item('versi'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="<?php echo base_url(); ?>___/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/style.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>___/css/sidebar.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>___/img/kemenag.png">
    <style type="text/css">
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(<?php echo base_url('___/img/facebook.gif'); ?>) center no-repeat #fff;
        }

        .ajax-loading {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: #6f6464;
            opacity: 0.75;
            color: #fff;
            text-align: center;
            font-size: 25px;
            padding-top: 200px;
            display: none;
        }
    </style>
</head>

<body style="background-color: #F3F6F9; min-height: 100vh;">
    <div class="se-pre-con"></div>

    <nav class="nav-ujian">
        <img style="height: 60px;" src="<?php echo base_url(); ?>___/img/Logo Beasiswa Cakrawala-color.png" alt="beasiswa cakrawala">
        <button onclick="return simpan_akhir()" class="b b-primary">Selesaikan Ujian</button>
    </nav>

    <div style="display: flex; padding: 36px; gap: 36px; width: 100%;">
        <form role="form" name"_form" method="post" id="_form" style="flex-basis: 70%; ">
            <div style="background-color: white; border-radius: 24px; padding: 20px">
                <div style="font-size: 18px; font-weight: 600; color: #3C3C3C; display: flex; justify-content: space-between">
                    <div>Soal ke <span id="nomor-soal"></span></div>
                    <box-icon class="ragu_ragu" style="cursor: pointer" onclick="tidak_jawab()" rel="1" name='flag-alt' type='solid' color="#A0A0A0"></box-icon>
                </div>
                <div style="margin-top: 4px; font-size: 12px; color: #ADADAD"><?php echo $info_soal; ?></div>

                <?php echo $soal_jawaban; ?>

                <!-- <div style="margin-top: 16px; color: #3C3C3C; font-size: 14px">
                    <p>Apa yang dimaksud dengan “seni instalasi”? Berikan contoh seni instalasi yang terkenal dan jelaskan maknanya.</p>

                    <div style="margin-top: 16px; display: flex; flex-direction: column; gap: 16px">
                        <div style="display: flex; align-items: start; gap: 16px;">
                            <input style="display: block;" type="radio" name="jawaban" value="a" id="a">

                            <label for="a" style="font-weight: 400">Seni instalasi adalah bentuk seni lukis pada kanvas besar. Contoh: "Starry Night" oleh Vincent van Gogh, yang menggambarkan langit malam.</label>
                        </div>
                        <div style="display: flex; align-items: start; gap: 16px;">
                            <input style="display: block;" type="radio" name="jawaban" value="a" id="a">

                            <label for="a" style="font-weight: 400">Seni instalasi adalah bentuk seni lukis pada kanvas besar. Contoh: "Starry Night" oleh Vincent van Gogh, yang menggambarkan langit malam.</label>
                        </div>
                        <div style="display: flex; align-items: start; gap: 16px;">
                            <input style="display: block;" type="radio" name="jawaban" value="a" id="a">

                            <label for="a" style="font-weight: 400">Seni instalasi adalah bentuk seni lukis pada kanvas besar. Contoh: "Starry Night" oleh Vincent van Gogh, yang menggambarkan langit malam.</label>
                        </div>
                        <div style="display: flex; align-items: start; gap: 16px;">
                            <input style="display: block;" type="radio" name="jawaban" value="a" id="a">

                            <label for="a" style="font-weight: 400">Seni instalasi adalah bentuk seni lukis pada kanvas besar. Contoh: "Starry Night" oleh Vincent van Gogh, yang menggambarkan langit malam.</label>
                        </div>
                        <div style="display: flex; align-items: start; gap: 16px;">
                            <input style="display: block;" type="radio" name="jawaban" value="a" id="a">

                            <label for="a" style="font-weight: 400">Seni instalasi adalah bentuk seni lukis pada kanvas besar. Contoh: "Starry Night" oleh Vincent van Gogh, yang menggambarkan langit malam.</label>
                        </div>
                    </div>
                </div> -->
            </div>

            <div style="display: flex; gap: 16px; margin-top: 16px; justify-content: center">
                <button type="button" class="b b-success back" rel="0" onclick="back()" style="display: flex; align-items: center"><box-icon name='chevron-left' color="white"></box-icon></button>
                <button type="button" class="b b-primary next" rel="2" onclick="next()" style="display: flex; align-items: center"><box-icon name='chevron-right' color="white"></box-icon></button>
            </div>

            <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
        </form>

        <div style="padding: 16px; flex-basis: 30%; background-color: white; border-radius: 24px; height: fit-content">
            <div style="background-color: #F3F6F9; padding: 16px; text-align: center; border-radius: 16px">
                <p style="font-size: 14px; font-weight: 600; color: #434343">Time to complete</p>
                <p style="color: #F78500; font-size: 20px; font-weight: 700"><span id="batas-waktu">20:00:00</span> / <span id="countdown-waktu">30:00:00</span></p>
            </div>

            <p style="margin-top: 16px; font-size: 18px; color: #393939">Soal</p>

            <div style="margin-top: 12px; display: flex; gap: 16px; align-items: center">
                <div id="soal_sudah_dikerjakan" style="font-size: 12px; font-weight: 600; color: #393939;">11/22</div>
                <div style="width: 100%; height: 8px; background-color: #D9D9D9; border-radius: 4px">
                    <div id="progress_pengerjaan" style="height: 100%; width: 50%; border-radius: 4px; background-color: #3D78E3"></div>
                </div>
            </div>

            <div style="display: flex; gap: 36px; margin-top: 12px; font-size: 12px; color: #8A8A8A">
                <div style="display: flex; gap: 12px; align-items: center">
                    <div style="width: 12px; height: 12px; border-radius: 4px; background-color: #3D78E3"></div>
                    <div>Dijawab</div>
                </div>
                <div style="display: flex; gap: 12px; align-items: center">
                    <div style="width: 12px; height: 12px; border-radius: 4px; background-color: #67B173"></div>
                    <div>Ragu-ragu</div>
                </div>
            </div>

            <div id="info-jawaban" style="margin-top: 16px; background-color: #F3F6F9; padding: 16px; display: flex; border-radius: 16px; flex-wrap: wrap; justify-content: center; gap: 16px;">
                <div class="item-info-jawaban belum-dijawab">1</div>
            </div>
        </div>
    </div>

    <!-- 
    <nav class="navbar navbar-findcond navbar-fixed-top" style="display: none; background-color: #0B6623; color: #fff;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><b><i class="glyphicon glyphicon-blackboard"></i> &nbsp;<?php echo $this->config->item('nama_aplikasi') . " " . $this->config->item('versi'); ?></b></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right" style="z-index: 1000">
                    <li><a class="#" onclick="return simpan_akhir();"><i class="glyphicon glyphicon-stop"></i>&nbsp;&nbsp;SELESAI UJIAN</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="floating container">
        <a id="tbl_show_jawaban" href="#" onclick="return show_jawaban()" class="btn btn-info" title="Tampilkan bilah jawaban"><i class="glyphicon glyphicon-search"></i> Lihat Jawaban</a>
    </div>

    <div class="dmobile">
        <div class="col-md-3" id="v_jawaban">
            <div class="panel panel-default">
                <div class="panel-heading" id="nav_soal" style="overflow: auto">
                    <div class="btn btn-primary col-md-12"><i class="fa fa-home"></i> NAVIGASI SOAL</div>
                </div>
                <div class="panel-body" style="overflow: auto;  height: 450px; padding: 10px">
                    <div id="tampil_jawaban" class="text-center"></div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <form role="form" name="_form" method="post" id="_form">
                <div class="panel panel-default">
                    <div class="panel-heading">SOAL KE &nbsp;<div class="btn btn-danger" id="soalke"></div>

                        <div class="tbl-kanan-soal">
                            <div id="clock" style="font-weight: bold" class="btn btn-primary"></div>
                        </div>
                    </div>

                    <div class="panel-body" style="overflow: auto">
                        <?php echo $html; ?>
                    </div>

                    <div class="panel-footer text-center">
                        <a class="action back btn btn-success" rel="0" onclick="return back();"><i class="glyphicon glyphicon-chevron-left"></i> KEMBALI</a>

                        <a class="action next btn btn-success" rel="2" onclick="return next();"><i class="glyphicon glyphicon-chevron-right"></i> SELANJUTNYA</a>

                        <a class="ragu_ragu btn btn-warning" rel="1" onclick="return tidak_jawab();">RAGU-RAGU</a>

                        <a class="selesai action submit btn btn-danger" onclick="return simpan_akhir();"><i class="glyphicon glyphicon-stop"></i> SELESAI</a>

                        <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
                    </div>
                </div>
            </form>
        </div>

    </div> -->

    <div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>

    <!-- <div class="col-md-12 footer" style="background-color: #0B6623; color: #fff;">
        <b style="color: #fff;"><a href="<?php echo base_url(); ?>adm"><?php echo $this->config->item('nama_aplikasi') . " " . $this->config->item('versi') . "</a><br> WAKTU SERVER: " . tjs(date('Y-m-d H:i:s'), "s") . " - WAKTU DATABASE: " . tjs($this->waktu_sql, "s"); ?></b>
    </div> -->



    <script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>___/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>___/plugin/countdown/jquery.countdownTimer.js"></script>
    <script src="<?php echo base_url(); ?>___/plugin/jquery_zoom/jquery.zoom.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        id_tes = "<?php echo $id_tes; ?>";
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });

        function convertMinutesToHHMMSS(minutes) {
            const totalSeconds = minutes * 60;
            const hours = Math.floor(totalSeconds / 3600);
            const remainingSecondsAfterHours = totalSeconds % 3600;
            const minutesPart = Math.floor(remainingSecondsAfterHours / 60);
            const seconds = remainingSecondsAfterHours % 60;

            const formattedHours = String(hours).padStart(2, '0');
            const formattedMinutes = String(minutesPart).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');

            return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        }

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
            $.map(unindexed_array, function(n, i) {
                indexed_array[n['name']] = n['value'];
            });
            return indexed_array;
        }

        $(document).on("ready", function() {
            // $('.gambar').each(function() {
            //     var url = $(this).attr("src");
            //     $(this).zoom({
            //         url: url
            //     });
            // });

            hitung();
            simpan_sementara();
            buka(1);

            widget = $(".step");
            btnnext = $(".next");
            btnback = $(".back");
            // btnsubmit = $(".submit");

            $(".step").hide();
            $(".back").hide();
            $("#widget_1").show();
        });

        widget = $(".step");
        total_widget = widget.length;
        console.log({
            total_widget
        })

        simpan_sementara = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            //form = JSON.stringify(form);
            var jml_soal = form.jml_soal;
            jml_soal = parseInt(jml_soal);

            var hasil_jawaban = "";
            var jawaban = "";
            var sudah_dijawab = 0;

            for (var i = 1; i < jml_soal; i++) {
                var idx = 'opsi_' + i;
                var idx2 = 'rg_' + i;
                var jawab = form[idx];
                var ragu = form[idx2];

                if (jawab != undefined) {
                    sudah_dijawab += 1;
                    if (ragu == "Y") {
                        if (jawab == "-") {
                            // hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                            jawaban += `<button id="btn_soal_${i}" onclick="return buka(${i})" class="item-info-jawaban belum-dijawab">${i}. ${jawab}</button>`
                        } else {
                            // hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-warning btn_soal btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                            jawaban += `<button id="btn_soal_${i}" onclick="return buka(${i})" class="item-info-jawaban ragu-ragu">${i}. ${jawab}</button>`
                        }
                    } else {
                        if (jawab == "-") {
                            // hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                            jawaban += `<button id="btn_soal_${i}" onclick="return buka(${i})" class="item-info-jawaban belum-dijawab">${i}. ${jawab}</button>`
                        } else {
                            // hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-success btn_soal btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                            jawaban += `<button id="btn_soal_${i}" onclick="return buka(${i})" class="item-info-jawaban dijawab">${i}. ${jawab}</button>`
                        }
                    }
                } else {
                    // hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". -</a>";
                    jawaban += `<button id="btn_soal_${i}" onclick="return buka(${i})" class="item-info-jawaban belum-dijawab">${i}. -</button>`
                }
            }

            // $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
            $("#info-jawaban").html(jawaban)
            $('#soal_sudah_dikerjakan').text(`${sudah_dijawab}/${jml_soal-1}`)
            $("#progress_pengerjaan").css({
                'width': `${Math.floor(sudah_dijawab/(jml_soal - 1)*100)}%`
            })
        }

        simpan = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);

            $.ajax({
                    type: "POST",
                    url: base_url + "adm/ikut_ujian/simpan_satu/" + id_tes,
                    data: JSON.stringify(form),
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    beforeSend: function() {
                        $('.ajax-loading').show();
                    }
                }).done(function(response) {
                    console.log(response.data)
                    $('.ajax-loading').hide();

                    var hasil_jawaban = "";
                    var panjang = response.data.length;

                    // for (var i = 0; i < panjang; i++) {
                    //     if (response.data[i] != "_N") {
                    //         var getjwb = response.data[i];
                    //         var pc_getjwb = getjwb.split('_');

                    //         if (pc_getjwb[1] == "Y") {
                    //             if (pc_getjwb[0] == "-") {
                    //                 hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                    //             } else {
                    //                 hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-warning btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                    //             }
                    //         } else {
                    //             if (pc_getjwb[0] == "-") {
                    //                 hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                    //             } else {
                    //                 hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-success btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". " + pc_getjwb[0] + "</a>";
                    //             }
                    //         }
                    //     } else {
                    //         hasil_jawaban += '<a id="btn_soal_' + (i + 1) + '" class="btn btn-default btn_soal btn-sm" onclick="return buka(' + (i + 1) + ');">' + (i + 1) + ". -</a>";
                    //     }
                    // }

                    //$("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    $('.ajax-loading').hide();
                    console.error("Request failed: " + textStatus + ", " + errorThrown);
                })
                .always(function() {
                    $('.ajax-loading').hide();
                });
            return false;
        }

        hitung = function() {
            var tgl_mulai = '<?php echo date('Y-m-d H:i:s'); ?>';
            var tgl_selesai = '<?php echo $jam_selesai; ?>';
            var waktu_ujian = '<?php echo $waktu; ?>'

            // $("div#clock").countdowntimer({
            //     startDate: tgl_mulai,
            //     dateAndTime: tgl_selesai,
            //     size: "lg",
            //     displayFormat: "HMS",
            //     timeUp: selesai,
            // });

            $('#batas-waktu').text(convertMinutesToHHMMSS(waktu_ujian))
            $('#countdown-waktu').countdowntimer({
                startDate: tgl_mulai,
                dateAndTime: tgl_selesai,
                size: "lg",
                displayFormat: "HMS",
                timeUp: selesai,
            });
        }

        selesai = function() {
            var f_asal = $("#_form");
            var form = getFormData(f_asal);
            simpan_akhir(id_tes);
            window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/" + id_tes);

            return false;
        }

        next = function() {
            var berikutnya = $(".next").attr('rel');
            berikutnya = parseInt(berikutnya);
            berikutnya = berikutnya > total_widget ? total_widget : berikutnya;

            $("#soalke").html(berikutnya);
            $("#nomor-soal").html(berikutnya);

            $(".next").attr('rel', (berikutnya + 1));
            $(".back").attr('rel', (berikutnya - 1));
            $(".ragu_ragu").attr('rel', (berikutnya));
            cek_status_ragu(berikutnya);
            cek_terakhir(berikutnya);

            var sudah_akhir = berikutnya == total_widget ? 1 : 0;

            $(".step").hide();
            $("#widget_" + berikutnya).show();

            if (sudah_akhir == 1) {
                $(".back").show();
                $(".next").hide();
            } else if (sudah_akhir == 0) {
                $(".next").show();
                $(".back").show();
            }

            simpan_sementara();
            simpan();
        }

        back = function() {
            var back = $(".back").attr('rel');
            back = parseInt(back);
            back = back < 1 ? 1 : back;

            $("#soalke").html(back);
            $("#nomor-soal").html(back);

            $(".back").attr('rel', (back - 1));
            $(".next").attr('rel', (back + 1));
            $(".ragu_ragu").attr('rel', (back));
            cek_status_ragu(back);
            cek_terakhir(back);

            $(".step").hide();
            $("#widget_" + back).show();

            var sudah_awal = back == 1 ? 1 : 0;

            $(".step").hide();
            $("#widget_" + back).show();

            if (sudah_awal == 1) {
                $(".back").hide();
                $(".next").show();
            } else if (sudah_awal == 0) {
                $(".next").show();
                $(".back").show();
            }

            simpan_sementara();
            simpan();
        }

        tidak_jawab = function() {
            var id_step = $(".ragu_ragu").attr('rel');
            var status_ragu = $("#rg_" + id_step).val();

            if (status_ragu == "N") {
                $("#rg_" + id_step).val('Y');
                $("#btn_soal_" + id_step).removeClass('btn-success');
                $("#btn_soal_" + id_step).addClass('btn-warning');

            } else {
                $("#rg_" + id_step).val('N');
                $("#btn_soal_" + id_step).removeClass('btn-warning');
                $("#btn_soal_" + id_step).addClass('btn-success');
            }


            cek_status_ragu(id_step);

            simpan_sementara();
            simpan();
        }

        cek_status_ragu = function(id_soal) {
            var status_ragu = $("#rg_" + id_soal).val();

            if (status_ragu == "N") {
                // $(".ragu_ragu").html('RAGU-RAGU');
                $(".ragu_ragu").attr('color', "#A0A0A0");
            } else {
                $(".ragu_ragu").attr('color', "#67b173");
                // $(".ragu_ragu").html('TIDAK RAGU');
            }
        }

        cek_terakhir = function(id_soal) {
            var jml_soal = $("#jml_soal").val();
            jml_soal = (parseInt(jml_soal) - 1);

            if (jml_soal == id_soal) {
                $(".selesai").show();
            } else {
                $(".selesai").hide();
            }
        }

        buka = function(id_widget) {
            $(".next").attr('rel', (id_widget + 1));
            $(".back").attr('rel', (id_widget - 1));
            $(".ragu_ragu").attr('rel', (id_widget));
            cek_status_ragu(id_widget);
            cek_terakhir(id_widget);

            $("#soalke").html(id_widget);
            $("#nomor-soal").html(id_widget);

            $(".step").hide();
            $("#widget_" + id_widget).show();

            if (id_widget == total_widget) {
                $(".back").show();
                $(".next").hide();
            } else if (id_widget == 1) {
                $(".next").show();
                $(".back").hide();
            } else {
                $(".next").show();
                $(".back").show();
            }
        }

        simpan_akhir = function() {
            simpan();
            if (confirm('Ujian telah selesai. Anda yakin akan mengakhiri tes ini..?')) {
                simpan();
                $.ajax({
                    type: "GET",
                    url: base_url + "adm/ikut_ujian/simpan_akhir/" + id_tes,
                    beforeSend: function() {
                        $('.ajax-loading').show();
                    },
                    success: function(r) {
                        if (r.status == "ok") {
                            window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/" + id_tes);
                        }
                    }
                });

                return false;
            }
        }

        show_jawaban = function() {
            $("#v_jawaban").toggle();
        }
    </script>
</body>

</html>