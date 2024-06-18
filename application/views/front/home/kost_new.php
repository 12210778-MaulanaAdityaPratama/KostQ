<hr><h3 align="center"><b>KOST KAMI</b></h3><hr>
<div class="row">
<?php if (!empty($kost_new) && is_array($kost_new)) { ?>
    <?php foreach ($kost_new as $kost) { ?>
        <div class="col-lg-4 grid" width="500" height="1000">
            <div class="thumbnail">
                <?php if (!empty($kost->foto)): ?>
                    <?php $counter = 0; ?>
                    <?php foreach ($kost->foto as $foto): ?>
                        <?php if ($counter < 2): // Limit to 2 images ?>
                            <img class="card-img-top" src="<?php echo base_url('assets/images/kost/' . $foto); ?>" width="500" height="500">
                            <?php $counter++; ?>
                        <?php else: ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <img class="card-img-top" src="<?php echo base_url(); ?>assets/images/no_image_thumb.png" width="500" height="500">
                <?php endif; ?>
                <div class="caption">
                    <p class="card-text"><b><?php echo $kost->nama_kost; ?></b></p>
                    <p class="card-text"><b>Rp. <?php echo number_format($kost->harga); ?>/bulan</b></p>
                    <hr>
                    <a href="<?php echo base_url('cart/buy/').$kost->id_kost ?>">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-shopping-cart"></i> Booking Sekarang</button>
                    </a>
                    <a href="<?php echo base_url('home/detail_kost/').$kost->id_kost ?>">
                        <button class="btn btn-sm btn-primary"><i class="bi bi-info-square-fill"></i> Detail Kost</button>
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No kost available</p>
<?php } ?>
</div>
