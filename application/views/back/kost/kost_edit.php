<?php $this->load->view('back/meta') ?>
<div class="wrapper">
  <?php $this->load->view('back/navbar') ?>
  <?php $this->load->view('back/sidebar') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?php echo $title ?></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><?php echo $module ?></a></li>
        <li class="active"><?php echo $title ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12">
          <?php echo validation_errors() ?>
          <?php if ($this->session->flashdata('message')) {
            echo $this->session->flashdata('message');
          } ?>
          <?php echo form_open_multipart($action); ?>
          <div class="box box-primary">
            <div class="box-body">
              <div class="form-group"><label>Nama kost</label>
                <?php echo form_input($nama_kost, $kost->nama_kost); ?>
              </div>
              <div class="form-group"><label>Harga</label>
                <?php echo form_input($harga, $kost->harga); ?>
              </div>
              <div class="form-group"><label>No. Handphone</label>
                <?php echo form_input($no_hp, $kost->no_hp); ?>
              </div>
              <div class="row">
                <div class="col-sm-6"><label>Provinsi</label>
                  <?php echo form_dropdown('', $ambil_provinsi, $kost->provinsi, $provinsi_id); ?><br>
                </div>
                <div class="col-sm-6"><label>Kabupaten/ Kota</label>
                  <?php echo form_dropdown('', $kost->kota,'', $kota_id); ?><br>
                </div>
              </div>
              <div class="form-group"><label>Lokasi</label>
                <?php echo form_input($lokasi, $kost->lokasi); ?>
              </div>
              <div class="form-group"><label>Sisa Kamar</label>
                <?php echo form_input($sisa_kost, $kost->sisa_kost); ?>
              </div>
              <div class="form-group"><label>Nama Kategori</label>
                <?php echo form_dropdown('', $ambil_kategori, '', $kat_id); ?>
              </div>
              <div class="form-group"><label>Deskripsi Kost</label>
                <?php echo form_textarea($deskripsi, $kost->deskripsi); ?>
              </div>
              <div class="form-group">
    <label>Foto Sebelumnya</label><br>
    <div id="image-container">
        <?php if (!empty($kost_images)): ?>
            <?php foreach ($kost_images as $image): ?>
                <div class="existing-image">
                    <img src="<?php echo base_url('assets/images/kost/' . $image->foto); ?>" width="300px" class="img-responsive" />
                    <p><?php echo $image->foto; ?></p> </div>
                    </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada foto sebelumnya.</p>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <label>Foto Baru</label>
    <input type="file" class="form-control" name="foto[]" id="foto" multiple onchange="tampilkanPreview(this, 'preview')" />
    <br>
    <p><b>Preview Foto</b><br>
    <div id="preview"></div>
</div>
            </div>
            <?php echo form_input($id_kost, $kost->id_kost); ?>
            <div class="box-footer">
              <button type="submit" name="submit" class="btn btn-success"><?php echo $button_submit ?></button>
              <button type="reset" name="reset" class="btn btn-danger"><?php echo $button_reset ?></button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div><!-- ./col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php $this->load->view('back/footer') ?>
</div><!-- ./wrapper -->
<?php $this->load->view('back/js') ?>
<script>
function tampilkanPreview(foto, idpreview) {
    var previewContainer = document.getElementById(idpreview);
    previewContainer.innerHTML = ''; // Clear previous previews

    var files = foto.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var imageType = /image.*/;
        if (file.type.match(imageType)) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.width = 300; // Set width
                img.classList.add('img-responsive', 'preview-image'); // Add classes
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        } else {
            alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
        }
    }
}
</script>
<script type="text/javascript">
  function tampilKota() {
    provinsi_id = document.getElementById("provinsi_id").value;
    $.ajax({
      url: "<?php echo base_url(); ?> a uth/pilih_k o ta/"+provinsi_id+"",
      success: function (response) {
        $("#kota_id").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>
</body>

</html>