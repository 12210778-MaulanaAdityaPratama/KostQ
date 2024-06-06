<hr><h3 align="center"><b>PROMOSI TERBARU</b></h3><hr>
<div class="row">
  <?php foreach($promosi_new as $promosi){ ?>

      <div class="col-lg-4">
        <div class="thumbnail">
          <a href="<?php echo base_url("promosi/$promosi->slug_promosi ") ?>">
            <?php
            if(empty($promosi->foto)) {echo "<img src='".base_url()."assets/images/no_image_thumb.png'>";}
            else { echo " <img src='".base_url()."assets/images/promosi/".$promosi->foto.'_thumb'.$promosi->foto_type."'> ";}
            ?>
          </a>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="caption">
          <h4><a href="<?php echo base_url("promosi/$promosi->slug_promosi ") ?>"><?php echo character_limiter($promosi->nama_promosi,100) ?></a></h4>
          <i class="fa fa-calendar"></i> <?php echo date("j F Y", strtotime($promosi->created_at)); ?>
          <br><br>
          <p><?php echo character_limiter($promosi->deskripsi,400) ?></p>
          <br>
          <p align="right">
            <a href="<?php echo base_url("promosi/$promosi->slug_promosi") ?>">
              <button type="button" name="button" class="btn btn-sm btn-success">Selengkapnya</button>
            </a>
          </p>
        </div>
      </div>
    <br>
  <?php } ?>
</div>
