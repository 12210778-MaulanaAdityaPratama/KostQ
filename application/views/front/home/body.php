<?php $this->load->view('front/header'); ?>
<?php $this->load->view('front/navbar'); ?>

<div class="container bg-primary">
	<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
	<?php $this->load->view('front/home/search'); ?>
	<?php $this->load->view('front/home/slider'); ?>
	<?php $this->load->view('front/home/kost_new'); ?>
	<!-- <php $this->load->view('front/home/promosi_new'); ?> -->
</div>

<?php $this->load->view('front/footer'); ?>
