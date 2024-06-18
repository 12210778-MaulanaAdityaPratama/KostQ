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
                                <?php echo form_input($nama_kost); ?>
                            </div>
                            <div class="form-group"><label>Nama Perusahaan</label>
                                <?php echo form_input($nama_perusahaan); ?>
                            </div>
                            <div class="form-group"><label>Harga</label>
                                <?php echo form_input($harga); ?>
                            </div>
                            <div class="form-group"><label>No. Handphone</label>
                                <?php echo form_input($no_hp); ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-6"><label>Provinsi</label>
                                    <?php echo form_dropdown('', $ambil_provinsi, '', $provinsi_id); ?><br>
                                </div>
                                <div class="col-sm-6"><label>Kabupaten/ Kota</label>
            <?php echo form_dropdown('', array(''=>'- Pilih Kota -'),'', $kota_id); ?>
          </div>
                            </div>
                            <div class="form-group"><label>Lokasi</label>
                                <?php echo form_input($lokasi); ?>
                            </div>
                            <div class="form-group"><label>Sisa Kamar</label>
                                <?php echo form_input($sisa_kost); ?>
                            </div>
                            <div class="form-group"><label>Nama Kategori</label>
                                <?php echo form_dropdown('', $ambil_kategori, '', $kat_id); ?>
                            </div>
                            <div class="form-group"><label>Deskripsi Kost</label>
                                <?php echo form_textarea($deskripsi); ?>
                            </div>
                            <div class="form-group"><label>Foto</label>
    <input type="file" class="form-control" name="foto[]" id="foto" multiple onchange="tampilkanPreview(this,'preview')" />
    <br>
    <p><b>Preview Foto</b><br>
        <div id="preview"></div> </p>
</div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit"
                                class="btn btn-success"><?php echo $button_submit ?></button>
                            <button type="reset" name="reset"
                                class="btn btn-danger"><?php echo $button_reset ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div><!-- ./col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view('back/footer') ?>
</div><!-- ./wrapper -->
<!-- <script type="text/javascript" src="<php echo base_url() ?>assets/plugins/tinymce/js/tinymce/tinymce.min.js"></script> -->
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        
        // ===========================================
        // INCLUDE THE PLUGIN
        // ===========================================
        
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages"
        ],
        
        // ===========================================
        // PUT PLUGIN'S BUTTON on the toolbar
        // ===========================================
        
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
        
        // ===========================================
        // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
        // ===========================================
        
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        
    });
    
    function tampilkanPreview(foto, idpreview) {
    var previewContainer = document.getElementById(idpreview); // Get the container
    previewContainer.innerHTML = ''; // Clear existing previews

    var gb = foto.files;
    for (var i = 0; i < gb.length; i++) {
        var gbPreview = gb[i];
        var imageType = /image.*/;
        var img = document.createElement('img'); // Create img element
        img.classList.add('preview-image'); // Add a class for styling
        previewContainer.appendChild(img); // Add img to the container
        var reader = new FileReader();
        if (gbPreview.type.match(imageType)) {
            reader.onload = (function(element) {
                return function(e) {
                    element.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(gbPreview);
        } else {
            alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
        }
    }
}

</script>
<script type="text/javascript">
    function tampilKota()
	{
        provinsi_id = document.getElementById("provinsi_id").value;
        $.ajax({
            url:"<?php echo base_url();?>auth/pilih_kota/"+provinsi_id+"",
            success: function(response){
                $("#kota_id").html(response);
            },
            dataType:"html"
        });
        return false;
	}
	</script>
<?php $this->load->view('back/js') ?>

</body>

</html>
