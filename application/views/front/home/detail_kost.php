<?php $this->load->view('front/header'); ?>
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
                        alt="Product Image" height="100px" width="100px" >
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