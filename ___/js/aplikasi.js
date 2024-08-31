let isOpen = localStorage.getItem("isOpen") || "buka";

if (isOpen === "buka") {
    $(".my-icon-name").show();
    $(".my-sidebar-item").css("width", "12rem");
} else {
    $(".my-icon-name").hide();
    $(".my-sidebar-item").css("width", "fit-content");
}

let isDropdownHidden = true;

const renderTable = (columns, server) => {
    new gridjs.Grid({
        pagination: {
            limit: 10,
            summary: false,
        },
        search: true,
        className: {
            search: "search",
            table: "my-table",
            paginationButton: "pagination-button",
            paginationButtonNext: "pagination-button-next",
            paginationButtonCurrent: "pagination-button-current",
            paginationButtonPrevious: "pagination-button-previous",
            td: "td",
        },
        language: {
            search: {
                placeholder: "Search here...",
            },
        },
        columns,
        server,
    }).render(document.getElementById("wrapper"));
};

$(".my-dropdown").hide();

const toggleDropdown = () => {
    $(".my-dropdown").fadeToggle(100);

    if (isDropdownHidden) {
        isDropdownHidden = !isDropdownHidden;
    }
};

window.onclick = (event) => {
    if (
        !event.target.closest(".my-dropdown") &&
        !event.target.closest("#profile") &&
        !isDropdownHidden
    ) {
        $(".my-dropdown").fadeOut(100);
        isDropdownHidden = !isDropdownHidden;
    }
};

const toggleSidebar = () => {
    $(".my-icon-name").toggle(100);

    if (isOpen === "buka") {
        $(".my-sidebar-item").css("width", "fit-content");
        isOpen = "tutup";
    } else {
        $(".my-sidebar-item").css("width", "12rem");
        isOpen = "buka";
    }

    localStorage.setItem("isOpen", isOpen);
};

const tampilkan_soal = (id) => {
    const preview_soal_el = document.querySelector(`#id-soal-${id}`);

    preview_soal_el.classList.toggle("hidden");
};

$(document).ready(function () {
    $(".gambar").each(function () {
        var url = $(this).attr("src");
        $(this).zoom({ url: url });
    });

    var url = get_url(parseInt(uri_js));
    var url2 = get_url(parseInt(uri_js) + 1);
    var url3 = get_url(parseInt(uri_js) + 2);
    //console.log(url);

    if (url == "m_siswa") {
        const columns = [{ name: "No", width: "70px" }, "Nama", "Kode", "Aksi"];
        const server = {
            url: base_url + "adm/m_siswa/data",
            then: (data) =>
                data.data.map((d, i) => [
                    i + 1,
                    d.nama,
                    d.nim,
                    gridjs.html(`<div class="row-button-container">
                                    <button onclick="return m_siswa_e(${
                                        d.id
                                    });" class="edit-btn" title="Edit">
                                        <box-icon name='edit' color='gray'></box-icon>
                                    </button>
                                    <button onclick="return m_siswa_h(${
                                        d.id
                                    });" class="delete-btn">
                                        <box-icon name='trash' color='gray'></box-icon>
                                    </button>
                                    ${
                                        d.ada === "0"
                                            ? `
                                                <button onclick="return m_siswa_u(${d.id});"  class="activate-user-btn">
                                                    <box-icon name='user-check' color='gray'></box-icon>
                                                </button>`
                                            : `
                                                <button onclick="return m_siswa_non_aktif(${d.id});" class="deactivate-user-btn">
                                                    <box-icon name='user-x' color='gray'></box-icon>
                                                </button>
                                                <button onclick="return m_siswa_ur(${d.id});" class="reset-pass-btn">
                                                    <box-icon name='reset' color='gray'></box-icon>
                                                </button>`
                                    }
                                </div>`),
                ]),
        };

        renderTable(columns, server);
    } else if (url == "m_guru") {
        const columns = [{ name: "No", width: "70px" }, "Nama", "Kode", "Aksi"];
        const server = {
            url: base_url + "adm/m_guru/data",
            then: (data) =>
                data.data.map((d, i) => [
                    i + 1,
                    d.nama,
                    d.nip,
                    gridjs.html(`<div class="row-button-container">
                                    <button onclick="return m_guru_e(${
                                        d.id
                                    });" class="edit-btn" title="Edit">
                                        <box-icon name='edit' color='gray'></box-icon>
                                    </button>
                                    <button onclick="return m_guru_h(${
                                        d.id
                                    });" class="delete-btn">
                                        <box-icon name='trash' color='gray'></box-icon>
                                    </button>
                                    <button onclick="return m_guru_matkul(${
                                        d.id
                                    });" class="category-handled-btn">
                                        <box-icon name='category' color='gray'></box-icon>
                                    </button>
                                    ${
                                        d.ada === "0"
                                            ? `
                                                <button onclick="return m_guru_u(${d.id});"  class="activate-user-btn">
                                                    <box-icon name='user-check' color='gray'></box-icon>
                                                </button>`
                                            : `
                                                <button onclick="return m_guru_non_aktif(${d.id});" class="deactivate-user-btn">
                                                    <box-icon name='user-x' color='gray'></box-icon>
                                                </button>
                                                <button onclick="return m_guru_ur(${d.id});" class="reset-pass-btn">
                                                    <box-icon name='reset' color='gray'></box-icon>
                                                </button>`
                                    }
                                </div>`),
                ]),
        };

        renderTable(columns, server);
    } else if (url == "m_jurusan") {
        pagination("datatabel", base_url + "adm/m_jurusan/data", []);
    } else if (url == "m_kelas") {
        pagination("datatabel", base_url + "adm/m_kelas/data", []);
    } else if (url == "m_mapel") {
        const columns = [{ name: "No", width: "70px" }, "Nama", "Aksi"];
        const server = {
            url: base_url + "adm/m_mapel/data",
            then: (data) =>
                data.data.map((d, i) => [
                    i + 1,
                    d.nama,
                    gridjs.html(`<div class="row-button-container">
                                    <button onclick="return m_mapel_e(${d.id});" class="edit-btn">
                                        <box-icon name='edit' color='gray'></box-icon>
                                    </button>
                                    <button onclick="return m_mapel_h(${d.id});" class="delete-btn">
                                        <box-icon name='trash' color='gray'></box-icon>
                                    </button>
                                </div>`),
                ]),
        };

        renderTable(columns, server);
    } else if (url == "m_soal") {
        if (url2 == "edit") {
            // if (editor_style == "inline") {
            //     CKEDITOR.inline("editornya");
            //     CKEDITOR.inline("editornya_a");
            //     CKEDITOR.inline("editornya_b");
            //     CKEDITOR.inline("editornya_c");
            //     CKEDITOR.inline("editornya_d");
            //     CKEDITOR.inline("editornya_e");
            // } else if (editor_style == "replace") {
            //     CKEDITOR.replace("editornya");
            //     CKEDITOR.replace("editornya_a");
            //     CKEDITOR.replace("editornya_b");
            //     CKEDITOR.replace("editornya_c");
            //     CKEDITOR.replace("editornya_d");
            //     CKEDITOR.replace("editornya_e");
            // }
        } else {
            const columns = [];
            const server = {
                url: base_url + "adm/m_soal/data",
                then: (data) =>
                    data.data.map((d, i) => {
                        console.log(d);
                        return [
                            gridjs.html(`
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="font-weight: 700; font-size: 18px; color: #4F4F4F">Soal&emsp;${
                                            i + 1
                                        }</div>
                                        <div class="soal-info">
                                            <div class="badge-kategori-panitia">${
                                                d.pk
                                            }</div>
                                            <div style="color: #C8C8C8;">Dipakai&emsp;<span style="color: black">${
                                                d.dipakai
                                            }</span></div>
                                            <div style="color: #C8C8C8;">Benar&emsp;<span style="color: black">${
                                                d.benar
                                            }</span></div>
                                            <div style="color: #C8C8C8;">Salah&emsp;<span style="color: black">${
                                                d.salah
                                            }</span></div>
                                            <div class="vertical-divider"></div>
                                            <div style="color: #C8C8C8;">Bobot&emsp;<span style="color: black">${
                                                d.bobot
                                            }</span></div>
                                            <button onclick="toggle_dropdown(event, ${
                                                d.id
                                            })" class="btn-dropdown">
                                                <box-icon name='dots-horizontal-rounded'></box-icon>
                                            </button>

                                            <div id="soal-${
                                                d.id
                                            }" class="dropdown-more hide">
                                                <a href="${
                                                    base_url +
                                                    "adm/m_soal/edit/" +
                                                    d.id
                                                }">Edit</a>
                                                <a href="${
                                                    base_url +
                                                    "adm/m_soal/hapus/" +
                                                    d.id
                                                }">Delete</a>
                                            </div>
                                        </div>
                                    </div>

                                    <section style="margin-top: 36px; text-align: start;">${
                                        d.soal
                                    }</section>

                                    <section class="section-jawaban">
                                        <div>
                                            <div class="opsi ${
                                                d.jawaban === "a" && "benar"
                                            }">
                                                A
                                            </div>
                                            <div>${d.opsi_a}</div>
                                        </div>
                                        <div>
                                            <div class="opsi ${
                                                d.jawaban === "b" && "benar"
                                            }">
                                                B
                                            </div>
                                            <div>${d.opsi_b}</div>
                                        </div>
                                        <div>
                                            <div class="opsi ${
                                                d.jawaban === "c" && "benar"
                                            }">
                                                C
                                            </div>
                                            <div>${d.opsi_c}</div>
                                        </div>
                                        <div>
                                            <div class="opsi ${
                                                d.jawaban === "d" && "benar"
                                            }">
                                                D
                                            </div>
                                            <div>${d.opsi_d}</div>
                                        </div>
                                        <div>
                                            <div class="opsi ${
                                                d.jawaban === "e" && "benar"
                                            }">
                                                E
                                            </div>
                                            <div>${d.opsi_e}</div>
                                        </div>
                                    </section>
                                    `),
                        ];
                    }),
            };

            renderTable(columns, server);
        }
    } else if (url == "h_ujian") {
        if (url2 == "det") {
            // pagination(
            //     "datatabel",
            //     base_url + "adm/h_ujian/data_det/" + url3,
            //     []
            // );

            const columns = [
                { name: "No", width: "70px" },
                "Nama Peserta",
                "Jumlah Benar",
                "Nilai",
                "Nilai Bobot",
                "Aksi",
            ];
            const server = {
                url: base_url + "adm/h_ujian/data_det/" + url3,
                then: (data) =>
                    data.data.map((d, i) => [
                        i + 1,
                        d.nama,
                        d.jml_benar,
                        d.nilai,
                        d.nilai_bobot,
                        gridjs.html(`<a href="${
                            base_url +
                            "adm/h_ujian/batalkan_ujian/" +
                            d.id +
                            "/" +
                            d.id_tes
                        }" style="width: fit-content" class="b b-danger">
                                        <box-icon size="20px" color="white" name='x'></box-icon>
                                        Batalkan Ujian
                                    </a>`),
                    ]),
            };

            renderTable(columns, server);
        } else {
            const columns = [
                { name: "No", width: "70px" },
                "Nama Tes",
                "Panitia",
                "Kategori",
                "Jumlah Soal",
                "Waktu",
                "Aksi",
            ];
            const server = {
                url: base_url + "adm/h_ujian/data",
                then: (data) =>
                    data.data.map((d, i) => [
                        i + 1,
                        d.nama_ujian,
                        d.nama_guru,
                        d.mapel,
                        d.jumlah_soal,
                        d.waktu + " menit",
                        gridjs.html(`<a href="${
                            base_url + "adm/h_ujian/det/" + d.id
                        }" style="width: fit-content" class="b b-info">
                                        <box-icon size="20px" color="white" name='search'></box-icon>
                                        Lihat hasil
                                    </a>`),
                    ]),
            };

            renderTable(columns, server);
        }
    } else if (url == "m_ujian") {
        if (url2 == "det") {
            pagination(
                "datatabel",
                base_url + "adm/m_ujian/data_det/" + url3,
                []
            );
        } else {
            // pagination("datatabel", base_url + "adm/m_ujian/data", []);
            const columns = [
                { name: "No", width: "70px" },
                { name: "Nama Tes", width: "180px" },
                "Kategori",
                { name: "Soal", width: "80px" },
                "Mulai",
                "Pengacakan",
                "Aksi",
            ];
            const server = {
                url: base_url + "adm/m_ujian/data",
                then: (data) =>
                    data.data.map((d, i) => [
                        i + 1,
                        gridjs.html(d.nama_ujian),
                        d.mapel,
                        d.jumlah_soal,
                        gridjs.html(d.mulai),
                        d.pengacakan,
                        gridjs.html(`<div class="row-button-container">
                                    <button onclick="return m_ujian_e(${
                                        d.id
                                    });" class="edit-btn">
                                        <box-icon name='edit' color='gray'></box-icon>
                                    </button>
                                    <button onclick="return m_ujian_h(${
                                        d.id
                                    });" class="delete-btn">
                                        <box-icon name='trash' color='gray'></box-icon>
                                    </button>
                                    <a href="${
                                        base_url + "adm/h_ujian/det/" + d.id
                                    }" class="hasil-btn">
                                        <box-icon name='search' color='gray'></box-icon>
                                    </a>
                                </div>`),
                    ]),
            };

            renderTable(columns, server);
        }
    } else if (url == "ikut_ujian") {
        if (url2 == "token") {
            timer();
        }
    }
});

function toggle_dropdown(e, id) {
    const btn_dropdown = e.target.closest("button");
    const dropdown = document.querySelector(`#soal-${id}`);

    dropdown.classList.toggle("show");
    dropdown.classList.toggle("hide");
}

function timer() {
    var tgl_sekarang = $("#_tgl_sekarang").val();
    var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
    var id_ujian = $("#id_ujian").val();
    var statuse = $("#_statuse").val();
    statuse = parseInt(statuse);

    if (statuse == 1) {
        $("#btn_mulai").html(
            `<button onclick="return konfirmasi_token(${id_ujian})" class="b b-success"><box-icon type='solid' name='flag-checkered' color="white"></box-icon>Mulai</button>`
        );

        $("#waktu_akhir_ujian").countdowntimer({
            startDate: tgl_sekarang,
            dateAndTime: tgl_terlambat,
            size: "lg",
            labelsFormat: true,
            timeUp: hilangkan_tombol,
        });

        $("#pesan").text("Selamat mengerjakan!");
    } else if (statuse == 0) {
        $("#btn_mulai").addClass("b b-info");
        $("#waktu_").hide();
        $("#akan_mulai").countdowntimer({
            startDate: tgl_sekarang,
            dateAndTime: tgl_mulai,
            size: "lg",
            labelsFormat: true,
            timeUp: timeIsUp,
        });

        $("#pesan").text("Tunggu ujiannya mulai yaa.");
    } else if (statuse == 2) {
        hilangkan_tombol();
        $("#pesan").text("Ujian udah selesai.");
    } else {
        hilangkan_tombol();
    }
}

function timeIsUp() {
    var id_ujian = $("#id_ujian").val();
    $("#btn_mulai").html(
        '<a href="#" class="b b-success" id="tbl_mulai" onclick="return konfirmasi_token(' +
            id_ujian +
            ')"><i class="fa fa-check-circle"></i> MULAI</a>'
    );

    var tgl_sekarang = $("#_tgl_sekarang").val();
    var tgl_mulai = $("#_tgl_mulai").val();
    var tgl_terlambat = $("#_terlambat").val();
}

function hilangkan_tombol() {
    $("#btn_mulai").hide();
    $("#waktu_").hide();
    $("#waktu_game_over").html(
        '<a class="b b-danger" onclick="return alert(\'WAKTU UJIAN TELAH SELESAI!\');">UJIAN TELAH SELESAI</a>'
    );
}

/* FUNGSI BERSAMA */
function get_url(segmen) {
    var url1 = window.location.protocol;
    var url2 = window.location.host;
    var url3 = window.location.pathname;
    var pathArray = window.location.pathname.split("/");
    return pathArray[segmen];
}
function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function (n, i) {
        indexed_array[n["name"]] = n["value"];
    });
    return indexed_array;
}

function pagination(indentifier, url, config) {
    $("#" + indentifier).DataTable({
        language: {
            url: base_url + "___/plugin/datatables/Indonesian.json",
        },
        ordering: false,
        columnDefs: config,
        bProcessing: true,
        serverSide: true,
        bDestroy: true,
        ajax: {
            url: url, // json datasource
            type: "post", // type of method  , by default would be get
            error: function () {
                // error handling code
                $("#" + indentifier).css("display", "none");
            },
        },
    });
}

function login(e) {
    console.log("masuk login");
    const notyf = new Notyf();

    e = e || window.event;
    var data = $("#f_login").serialize();
    $("#konfirmasi").html(
        "<div class='alert alert-info'><i class='icon icon-spinner icon-spin'></i> Checking...</div>"
    );
    $.ajax({
        type: "POST",
        data: data,
        url: base_url + "adm/act_login",
        success: function (r) {
            if (r.log.status == 0) {
                notyf.error(r.log.keterangan);
            } else {
                notyf.success(r.log.keterangan);
                window.location.assign(base_url + "adm");
            }
        },
    });
    return false;
}
/* 
=======================================
=======================================
*/
function konfirmasi_token(id) {
    var token_asli = $("#_token").val();
    var token_input = $("#token").val();

    if (token_asli != token_input) {
        alert("TOKEN YANG ADA MASUKKAN SALAH!");
        return false;
    } else {
        alert("TOKEN BENAR, SILAHKAN KLIK TOMBOL OK");
        window.location.assign(base_url + "adm/ikut_ujian/_/" + id);
    }
}

function m_soal_h(id) {
    if (confirm("APAKAH ANDA YAKIN?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_soal/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_soal");
                } else {
                    console.log("gagal");
                }
            },
        });
    }

    return false;
}
//ujian
function m_ujian_e(id) {
    $("#m_ujian").modal("show");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_ujian/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#nama_ujian").val(data.nama_ujian);
            $("#jumlah_soal").val(data.jumlah_soal);
            $("#kelas").val(data.kelas);
            $("#jurusan").val(data.jurusan);
            $("#mapel").val(data.id_mapel);
            $("#waktu").val(data.waktu);
            $("#terlambat").val(data.terlambat);
            $("#terlambat2").val(data.terlambat2);
            $("#tgl_mulai").val(data.tgl_mulai);
            $("#wkt_mulai").val(data.wkt_mulai);
            $("#acak").val(data.jenis);
            $("#nama_ujian").focus();
            __ambil_jumlah_soal(data.id_mapel);
        },
    });

    return false;
}
function m_ujian_s() {
    var f_asal = $("#f_ujian");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_ujian/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_ujian");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_ujian_h(id) {
    if (confirm("APAKAH ANDA YAKIN")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_ujian/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_ujian");
                } else {
                    console.log("gagal");
                }
            },
        });
    }

    return false;
}
function refresh_token(id) {
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_ujian/refresh_token/" + id,
        success: function (response) {
            if (response.status == "ok") {
                pagination("datatabel", base_url + "adm/m_ujian/data", []);
            } else {
                console.log("gagal");
            }
        },
    });

    return false;
}

/* admindos las puerta conos il grande partite */
//siswa
function m_siswa_e(id) {
    $("#m_siswa").modal("show");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_siswa/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#nama").val(data.nama);
            $("#nim").val(data.nim);
            $("#jurusan").val(data.jurusan);
            $("#id_jurusan").val(data.id_jurusan);
            $("#nama").focus();
        },
    });
    return false;
}
function m_siswa_s() {
    var f_asal = $("#f_siswa");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_siswa/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_siswa");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_siswa_h(id) {
    if (confirm("APAKAH ANDA YAKIN")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}
function m_siswa_hs() {
    if (confirm("APAKAH ANDA YAKIN MENGHAPUS SEMUA DATA?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/hapussemua/",
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}
function m_siswa_u(id) {
    if (confirm("APAKAH ANDA YAKIN? USERNAME & PASSWORD OTOMATIS N I S")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/user/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    alert(response.caption);
                }
            },
        });
    }
    return false;
}
function m_siswa_ur(id) {
    if (confirm("APAKAH ANDA YAKIN? USERNAME & PASSWORD OTOMATIS N I S")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/user_reset/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    alert(response.caption);
                }
            },
        });
    }
    return false;
}
function aktifkan_semua_siswa() {
    if (confirm("APAKAH ANDA YAKIN MENGAKTIFKAN SEMUA DATA?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/aktifkan_semua/",
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    alert(response.caption);
                }
            },
        });
    }
    return false;
}
function m_siswa_non_aktif(id) {
    if (confirm("APAKAH ANDA YAKIN MENONAKTIFKAN USER INI?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_siswa/non_aktifkan/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_siswa");
                } else {
                    alert(response.caption);
                }
            },
        });
        return false;
    }
}
//guru
function m_guru_e(id) {
    toggle_modal_by_id("#modal-tambah-guru");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_guru/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#nip").val(data.nip);
            $("#nama").val(data.nama);
            $("#nama").focus();
        },
    });
    return false;
}
function m_guru_s() {
    var f_asal = $("#f_guru");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_guru/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_guru");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_guru_h(id) {
    if (confirm("APAKAH ANDA YAKIN?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_guru/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_guru");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}
function m_guru_u(id) {
    if (confirm("APAKAH ANDA YAKIN? USERNAME & PASSWORD ANDA ADALAH KODE")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_guru/user/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_guru");
                } else {
                    alert(response.caption);
                }
            },
        });
    }
    return false;
}

function m_guru_ur(id) {
    if (confirm("APAKAH ANDA YAKIN? USERNAME & PASSWORD ANDA ADALAH KODE")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_guru/user_reset/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_guru");
                } else {
                    alert(response.caption);
                }
            },
        });
    }
    return false;
}
function aktifkan_semua_guru() {
    if (confirm("APAKAH ANDA YAKIN MENGAKTIFKAN SEMUA DATA?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_guru/aktifkan_semua_guru/",
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_guru");
                } else {
                    alert(response.caption);
                }
            },
        });
    }

    return false;
}
function m_guru_matkul(id) {
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_guru/ambil_matkul/" + id,
        success: function (data) {
            if (data.status == "ok") {
                var jml_data = Object.keys(data.data).length;
                var hate =
                    '<div class="modal fade" id="m_siswa_matkul" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Setting Mata Pelajaran</h4></div><div class="modal-body"><form name="f_siswa_matkul" id="f_siswa_matkul" method="post" onsubmit="return m_guru_matkul_s();"><input type="hidden" name="id_mhs" id="id_mhs" value="' +
                    id +
                    '"><div id="konfirmasi"></div>';

                if (jml_data > 0) {
                    $.each(data.data, function (i, item) {
                        if (item.ok == "1") {
                            hate +=
                                '<label><input type="checkbox" value="' +
                                item.id +
                                '" name="id_mapel_' +
                                item.id +
                                '" checked> &nbsp;' +
                                item.nama +
                                "</label> &nbsp;&nbsp; ";
                        } else {
                            hate +=
                                '<label><input type="checkbox" value="' +
                                item.id +
                                '" name="id_mapel_' +
                                item.id +
                                '"> &nbsp;' +
                                item.nama +
                                "</label> &nbsp;&nbsp; ";
                        }
                    });
                } else {
                    hate += "Belum ada data..";
                }
                hate +=
                    '<div class="modal-footer"><button class="btn btn-primary" type="submit">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';
                $("#tampilkan_modal").html(hate);
                $("#m_siswa_matkul").modal("show");
            } else {
                console.log("gagal");
            }
        },
    });
    return false;
}
function m_guru_matkul_s() {
    var f_asal = $("#f_siswa_matkul");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_guru/simpan_matkul",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_guru");
        } else {
            console.log("gagal");
        }
    });

    return false;
}
//mapel
function m_mapel_e(id) {
    $("#m_mapel").modal("show");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_mapel/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#nama").val(data.nama);
            $("#nama").focus();
        },
    });
    return false;
}
function m_mapel_s() {
    var f_asal = $("#f_mapel");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_mapel/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_mapel");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_mapel_h(id) {
    if (confirm("APAKAH ANDA YAKIN?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_mapel/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_mapel");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}
//jurusan
function m_jurusan_e(id) {
    $("#m_jurusan").modal("show");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_jurusan/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#jurusan").val(data.jurusan);
            $("#jurusan").focus();
        },
    });
    return false;
}
function m_jurusan_s() {
    var f_asal = $("#f_jurusan");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_jurusan/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_jurusan");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_jurusan_h(id) {
    if (confirm("APAKAH ANDA YAKIN?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_jurusan/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_jurusan");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}
//kelas
function m_kelas_e(id) {
    $("#m_kelas").modal("show");
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_kelas/det/" + id,
        success: function (data) {
            $("#id").val(data.id);
            $("#kelas").val(data.kelas);
            $("#kelas").focus();
        },
    });
    return false;
}
function m_kelas_s() {
    var f_asal = $("#f_kelas");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/m_kelas/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            window.location.assign(base_url + "adm/m_kelas");
        } else {
            console.log("gagal");
        }
    });
    return false;
}
function m_kelas_h(id) {
    if (confirm("APAKAH ANDA YAKIN?")) {
        $.ajax({
            type: "GET",
            url: base_url + "adm/m_kelas/hapus/" + id,
            success: function (response) {
                if (response.status == "ok") {
                    window.location.assign(base_url + "adm/m_kelas");
                } else {
                    console.log("gagal");
                }
            },
        });
    }
    return false;
}

function __ambil_jumlah_soal(id_mapel) {
    $.ajax({
        type: "GET",
        url: base_url + "adm/m_ujian/jumlah_soal/" + id_mapel,
        success: function (response) {
            $("#jumlah_soal1").val(response.jumlah);
        },
    });
    return false;
}
function rubah_password() {
    $.ajax({
        type: "GET",
        url: base_url + "adm/rubah_password/",
        success: function (response) {
            var teks_modal =
                '<div class="modal fade" id="m_ubah_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">UPDATE PASSWORD</h4></div><div class="modal-body"><form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post"><input type="hidden" name="id" id="id" value="' +
                response.id +
                '"><div id="konfirmasi"></div><table class="table table-form"><tr><td style="width: 25%">Username</td><td style="width: 75%"><input type="text" class="form-control" name="u1" id="u1" required value="' +
                response.username +
                '" readonly></td></tr><tr><td style="width: 25%">Current Password</td><td style="width: 75%"><input type="password" class="form-control" name="p1" id="p1" required></td></tr><tr><td style="width: 25%">New Password</td><td style="width: 75%"><input type="password" class="form-control" name="p2" id="p2" required></td></tr><tr><td style="width: 25%">Reenter Password</td><td style="width: 75%"><input type="password" class="form-control" name="p3" id="p3" required></td></tr></table></div><div class="modal-footer"><button class="btn btn-primary" onclick="return rubah_password_s();"><i class="fa fa-check"></i> Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button></div></form></div></div></div>';
            $("#tampilkan_modal").html(teks_modal);
            $("#m_ubah_password").modal("show");
            $("#p1").focus();
        },
    });
    return false;
}
function rubah_password_s() {
    var f_asal = $("#f_ubah_password");
    var form = getFormData(f_asal);
    $.ajax({
        type: "POST",
        url: base_url + "adm/rubah_password/simpan",
        data: JSON.stringify(form),
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (response) {
        if (response.status == "ok") {
            $("#konfirmasi").html(
                '<div class="alert alert-success">' + response.msg + "</div>"
            );
            $("#m_ubah_password").modal("hide");
        } else {
            $("#konfirmasi").html(
                '<div class="alert alert-danger">' + response.msg + "</div>"
            );
        }
    });
    return false;
}

function toggle_modal_by_id(id) {
    const modalEl = $(id);

    const display = modalEl.css("display");
    if (display === "flex") {
        modalEl.animate({ opacity: "0%" }, 200);

        $("body").css({
            overflow: "auto",
            marginRight: "0",
        });

        modalEl.css("display", "none");
    } else {
        $("body").css({
            overflow: "hidden",
            marginRight: "17px",
        });

        modalEl.css("display", "flex");
        modalEl.animate({ opacity: "100%" }, 200);
    }
}
