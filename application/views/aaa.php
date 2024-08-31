<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <meta name="apple-mobile-web-app-capable" content="yes">
   <!-- <link href="<?php echo base_url(); ?>___/css/bootstrap.css" rel="stylesheet"> -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link href="<?php echo base_url(); ?>___/css/style.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/css/style2.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/plugin/fa/css/font-awesome.min.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>___/plugin/datatables/dataTables.bootstrap.css" rel="stylesheet">
   <link rel="icon" type="image/png" href="<?php echo base_url(); ?>___/img/kemenag.png">
   <link rel="stylesheet" href="<?php echo base_url(); ?>___/plugin/nice-select2/dist/css/nice-select2.css" />
   <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

   <title>HOME - <?php echo $this->config->item('nama_aplikasi') . " " . $this->config->item('versi'); ?></title>
</head>

<body>
   <div class="my-nav">
      <div style="display: flex; gap: 3rem; align-items: center;">
         <img src="<?php echo base_url(); ?>___/img/Logo Beasiswa Cakrawala-color.png" alt="beasiswa cakrawala">
         <button onclick="toggleSidebar()" style="padding: .5rem">
            <box-icon color="grey" name='menu'></box-icon>
         </button>
      </div>
      <button id="profile" onclick="toggleDropdown()">
         <?php echo $this->session->userdata("admin_user") ?>
         <box-icon color="#6E6E6E" name='chevron-down'></box-icon>
      </button>
   </div>

   <div class="my-dropdown">
      <div><?php echo $this->session->userdata("admin_user") ?></div>
      <div style="margin-bottom: 1rem; font-size: .75rem;"><?php echo $this->session->userdata("admin_nama") ?></div>

      <hr>

      <button onclick="return rubah_password();" class="dropdown-item">
         <div class="dropdown-icon"><box-icon color="grey" name='reset'></box-icon></div>
         <div class="dropdown-action">Reset password</div>
      </button>
      <a href="<?php echo base_url(); ?>adm/logout" onclick="return confirm('ANDA YAKIN KELUAR?');" class="dropdown-item">
         <div class="dropdown-icon"><box-icon color="grey" name='log-out'></box-icon></div>
         <div class="dropdown-action">Log out</div>
      </a>
   </div>

   <div class="my-main">
      <div class="my-sidebar">
         <?php echo gen_sidebar() ?>
      </div>
      <div class="my-menu">
         <?php echo $this->load->view($p); ?>
      </div>
   </div>

   <div id="tampilkan_modal"></div>


   <script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script>
   <!-- <script src="<?php echo base_url(); ?>___/js/bootstrap.js"></!--> -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <script src="<?php echo base_url(); ?>___/plugin/datatables/jquery.dataTables.min.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/datatables/dataTables.bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/jquery_zoom/jquery.zoom.min.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/countdown/jquery.countdownTimer.js"></script>
   <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/nice-select2/dist/js/nice-select2.js"></script>
   <script src="<?php echo base_url(); ?>___/plugin/tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
   <script src="<?php echo base_url(); ?>___/plugin/eqneditor/eqneditor.js" referrerpolicy="origin"></script>

   <script type="text/javascript">
      var base_url = "<?php echo base_url(); ?>";
      var editor_style = "<?php echo $this->config->item('editor_style'); ?>";
      var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
   </script>

   <!-- <?php if ($this->uri->segment(2) == "m_soal" && $this->uri->segment(3) == "edit") : ?>
      <script src="<?php echo base_url(); ?>___/plugin/ckeditor/ckeditor.js"></script>
   <?php endif; ?> -->

   <?php if ($this->uri->segment(2) == "m_soal" && $this->uri->segment(3) == "edit") : ?>
      <!-- <script src="<?php echo base_url(); ?>___/plugin/ckeditor/ckeditor.js"></script> -->
      <script>
         const mapels = <?= json_encode($p_mapel); ?>;
         const gurus = <?= json_encode($p_guru); ?>;
         const default_mapel = <?= json_encode($d["id_mapel"]); ?>;
         const default_guru = <?= json_encode($d["id_guru"]); ?>;

         const mapel_select_el = document.querySelector('#id_mapel')
         const guru_select_el = document.querySelector('#id_guru')

         const mapel_ns = NiceSelect.bind(mapel_select_el)
         const guru_ns = NiceSelect.bind(guru_select_el)

         mapel_ns.disable()
         guru_ns.enable()

         gurus.forEach(a => {
            guru_select_el.innerHTML += `<option value="${a.id_guru}" ${a.id_guru == default_guru ? 'selected' : ''}>${a.nama}</option>`
            guru_ns.update()
         })

         const update_mapel = () => {

            const selected_guru_id = guru_select_el.value
            const filtered_mapel = mapels.filter(el => el.id_guru == selected_guru_id)

            mapel_select_el.innerHTML = `<option data-display="Select">Pilih Kategori</option>`

            if (selected_guru_id !== 'Pilih Panitia') {

               filtered_mapel.forEach(a => {
                  mapel_select_el.innerHTML += `<option value="${a.id_mapel}" ${a.id_mapel == default_mapel ? 'selected' : ''}>${a.nama}</option>`

                  mapel_ns.enable()
                  mapel_ns.update()
               })
            } else {
               mapel_select_el.innerHTML = `<option data-display="Select">Pilih Kategori</option>`
               mapel_ns.update()
               mapel_ns.disable()
            }
         }

         if (default_mapel) {
            update_mapel()
         }

         tinymce.init({
            selector: "textarea",
            plugins: "eqneditor anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker",
            toolbar: "undo redo | bold italic underline strikethrough | link image table | align lineheight | numlist bullist indent outdent | emoticons charmap eqneditor removeformat",
            menubar: false,
            height: 200,
            images_upload_url: '<?php echo site_url('adm/upload_image'); ?>',
            automatic_uploads: true,
            file_picker_types: 'image',
            relative_urls: false, // Add this line
            remove_script_host: false, // Add this line
            document_base_url: '<?php echo base_url(); ?>', // Add this line
            file_picker_callback: function(callback, value, meta) {
               if (meta.filetype === 'image') {
                  const input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.setAttribute('accept', 'image/*');
                  input.onchange = function() {
                     const file = this.files[0];
                     const reader = new FileReader();
                     reader.onload = function() {
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        callback(blobInfo.blobUri(), {
                           title: file.name
                        });
                     };
                     reader.readAsDataURL(file);
                  };
                  input.click();
               }
            }
         });
      </script>
   <?php endif; ?>

   <script src="<?php echo base_url(); ?>___/js/aplikasi.js?time=<?php echo time(); ?>"></script>
</body>

</html>