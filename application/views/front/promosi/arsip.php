<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url() ?>">Home</a></li>
		<li><a href="#">PROMOSI</a></li>
		<li class="active">Semua Promosi</li>
	</ol>

	<div class="row">
		<div class="col-md-8"><h1>SEMUA PROMOSI</h1><hr>
			<?php foreach($promosi_all as $promosi){ ?>
				<h2><a href="<?php echo base_url('promosi/').$promosi->slug_promosi ?>"><?php echo $promosi->nama_promosi ?></a></h2>
				<a href="<?php echo base_url("promosi/$promosi->slug_promosi ") ?>">
					<?php
					if(empty($promosi->foto)) {echo "<img class='img-responsive' src='".base_url()."./assets/images/no_image_thumb.png'>";}
					else { echo " <img class='img-responsive' src='".base_url()."./assets/images/promosi/".$promosi->foto.'_thumb'.$promosi->foto_type."'> ";}
					?>
				</a>
				<p>
					<i class="fa fa-user"></i> <?php echo $promosi->created_by ?>
					<i class="fa fa-calendar"></i> <?php echo date("j F Y", strtotime($promosi->created_at)); ?>
				</p>
				<p><?php echo character_limiter($promosi->deskripsi,350) ?></p>
				<a class="btn btn-sm btn-primary" href="<?php echo base_url("promosi/$promosi->slug_promosi ") ?>">Selengkapnya <i class="fa fa-angle-right"></i></a>
			<?php } ?>
			<div align="center"><?php echo $this->pagination->create_links() ?></div>
		</div>
		<?php $this->load->view('front/sidebar'); ?>
	</div>
</div>
<?php $this->load->view('front/footer'); ?>
