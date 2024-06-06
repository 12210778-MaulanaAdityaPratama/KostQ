<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container">
	<ol class="breadcrumb">
	  <li><a href="<?php echo base_url() ?>">Home</a></li>
	  <li><a href="#">Promosi</a></li>
	  <li class="active"><?php echo $kost_detail->nama_kost ?></li>
	</ol>

	<div class="row">
		<div class="col-md-8"><h1><?php echo strtoupper($kost_detail->nama_kost) ?></h1>
			<a href="<?php echo base_url('assets/images/promosi/').$kost_detail->foto.$kost_detail->foto ?>" title="<?php echo $kost_detail->nama_kost ?>">
				<img src="<?php echo base_url('assets/images/promosi/').$kost_detail->foto.'_thumb'.$kost_detail->foto ?>" alt="<?php echo $promosi_detail->nama_promosi ?>" class="img-responsive">
			</a>

	    <i class="fa fa-user"></i> <?php echo $kost_detail->created_by ?></a> | <i class="fa fa-calendar"></i> <?php echo date("j F Y", strtotime($kost_detail->created_at)); ?>

			<p><?php echo $kost_detail->deskripsi ?></p>

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