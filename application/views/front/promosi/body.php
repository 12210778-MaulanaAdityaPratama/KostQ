<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="#">promosi</a></li>
	  <li class="active"><?php echo $promosi_detail->nama_promosi ?></li>
	</ol>

	<div class="row">
		<div class="col-md-8"><h1><?php echo strtoupper($promosi_detail->nama_promosi) ?></h1>
			<a href="<?php echo base_url('assets/images/promosi/').$promosi_detail->foto.$promosi_detail->foto_type ?>" title="<?php echo $promosi_detail->nama_promosi ?>">
				<img src="<?php echo base_url('assets/images/promosi/').$promosi_detail->foto.'_thumb'.$promosi_detail->foto_type ?>" alt="<?php echo $promosi_detail->nama_promosi ?>" class="img-responsive">
			</a>

	    <i class="fa fa-user"></i> <?php echo $promosi_detail->created_by ?></a> | <i class="fa fa-calendar"></i> <?php echo date("j F Y", strtotime($promosi_detail->created_at)); ?>

			<p><?php echo $promosi_detail->deskripsi ?></p>

			<p>
				<div class="sharethis-inline-share-buttons"></div>
				<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5ae2ee03de20620011e03337&product=inline-share-buttons"></script>
			</p>

			<?php $this->load->view('front/modul/mod_komen'); ?>
		</div>
		<?php $this->load->view('front/sidebar'); ?>
	</div>
</div>
<?php $this->load->view('front/footer'); ?>
