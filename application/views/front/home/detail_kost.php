<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KostQ |
        <?= $title ?>
    </title>
    <link rel="website icon" type="png" href="<?= base_url('assets/logo/logo8.png') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>templates/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>templates/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/dist/css/adminlte.min.css">
    <!--font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>templates/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>templates/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>templates/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url() ?>templates/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>templates/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>templates/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>templates/dist/js/demo.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>templates/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- jQuery 2 -->
    <script src="<?= base_url() ?>templates/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>templates/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>templates/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>templates/dist/js/demo.js"></script>
</head>
<!-- Default box -->
<div class="card card-solid">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3 class="d-inline-block d-sm-none">
                    <?= $kost->nama_kost ?>
                </h3>
                <div class="col-12">
                    <img src="<?= base_url('assets/images/kost/' . $kost->foto) ?>" class="product-image"
                        alt="Product Image" height="100px" width="100px">
                </div>
                <!-- <div class="col-12 product-image-thumbs">
                    <div class="product-image-thumb active"><img
                            src="<= base_url('assets/images/kost/' . $kost->foto) ?>" alt="Product Image">
                    </div> -->
                <!-- <php foreach ($gambar as $key => $value): ?>
                        <div class="product-image-thumb"><img
                                src="<= base_url('assets/gambarbarang/' . $value->gambar) ?>"></div>
                    <php endforeach; ?> -->

                <!-- </div> -->
            </div>
            <div class="col-12 col-sm-6">
                <h3 class="my-3">
                    <?= $kost->nama_kost ?>
                </h3>
                <p>kategori :
                    <?= $kost->kategori ?>
                </p>
                <p>Stok Produk :
                    <?= $kost->sisa_kost ?>
                </p>
                <p> <label for="">Keterangan :</label><br>
                    <?= $kost->deskripsi ?>
                </p>

                <hr>


                <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">
                        Rp.
                        <?= number_format($kost->harga, 0, ',', '.') ?>,-
                    </h2>
                </div>
                <?php echo form_open('cart/buy/');
                echo form_hidden('id', $kost->id_kost);

                echo form_hidden('price', $kost->harga);
                echo form_hidden('name', $kost->nama_kost);
                echo form_hidden('redirect_page', str_replace('index.php/', '', current_url())); ?>
                <div class="mt-4">
                    <!-- <div class="row">
                        <div class="col-2">
                            <input type="number" name="qty" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary btn-lg btn-flat swalDefaultSuccess">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div> -->
                </div>
                <?php echo form_close(); ?>
                <a href="<?php echo base_url('cart/buy/') . $kost->id_kost ?>">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart"></i> Booking Sekarang</button>
                </a>
                <a href="<?php echo base_url('') ?>">
                    <button class="btn btn-sm btn-primary">Kembali</button>
                </a>


                <div class="mt-4 product-share">
                    <a href="#" class="text-gray">
                        <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                        <i class="fab fa-twitter-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                        <i class="fas fa-envelope-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                        <i class="fas fa-rss-square fa-2x"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<!-- /.card -->

<script>
    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('.swalDefaultSuccess').click(function () {
            Toast.fire({
                icon: 'success',
                title: 'Produk Berhasil di Tambahkan dikeranjang.'
            })
        });
    });
</script>

</html>