<div class="col-md-12">
    <div class="card card-warning shadow-none">
        <div class="card-header">
            <h3 class="card-title">Tambah Gambar barang |
                <?= $kost->nama_kost ?>
            </h3>

            <div class="card-tools">

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php if (
                $this->session->flashdata('pesan')
            ) {
                echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i>';
                echo $this->session->flashdata('pesan');
                echo '</h5></div>';
            }
            ?>
            <?php
            echo validation_errors('<div class="alert alert-warning alert-dismissible">
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h5><i class="icon fas fa-info"></i>', '</h5></div>');
            if (isset($error_upload)) {
                echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-info"></i>' . $error_upload . '</h5></div>';
            }
            echo form_open_multipart('gambarbarang/tambah/' . $kost->id_kost) ?>
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label>keterangan gambar</label>
                            <input type="text" name="ket" class="form-control" value="<?= set_value('ket') ?>"
                                placeholder="keterangan Barang " required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>upload gambar</label>
                            <input type="file" name="gambar" class="form-control" id="review_gambar">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <img src="<?= base_url('assets/images/no_image.jpg') ?>" id="gambar_load" width="250px"
                                required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">simpan</button>
                        <a href="<?= base_url('admin/gambarkost') ?>" class="btn btn-success btn-sm">kembali</a>
                    </div>
                </div>
            </form>
            <?php echo form_close() ?>
            <hr>
            <div class="row">
                <?php foreach ($gambar as $value): ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <img src="<?= base_url('assets/gambarkost/' . $value->foto) ?>" id="gambar_load"
                                width="250px" height="200px">
                        </div>
                        <p for="">keterangan
                            <?= $value->ket ?>
                        </p>
                        <a class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete<?= $value->id_gambar ?>"><i class="fa-solid fa-trash"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!--modal = #delete -->
<?php
foreach ($gambar as $value):
    ?>
    <div class="modal fade" id="delete<?= $value->id_gambar ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus foto
                        <?= $value->ket ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">

                    <h5>
                        <p>apakah anda yakin menghapus foto secara permanen</p>
                        <img src="<?= base_url('assets/images/kost/' . $value->foto) ?>" width="100px" height="100px">
                    </h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('gambarkost/delete/' . $value->id_kost . '/' . $value->id_gambar) ?>"
                        class="btn btn-danger">Dihapus</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    </div>
<?php endforeach; ?>
<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#gambar_load').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#review_gambar').change(function () {
        bacaGambar(this);
    });
</script>