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
                <li class="active"><?php echo $title ?></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            <div class="table-responsive no-padding">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">No.</th>
                                            <th style="text-align: center">Nama Kost</th>
                                            <th style="text-align: center">gambar</th>
                                            <th style="text-align: center">total gambar</th>
                                            <th style="text-align: center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1;
                                foreach ($gambarkost as $value): ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $no++; ?>
                                        </td>
                                        <td>
                                            <?= $value->nama_kost ?>
                                        </td>
                                        <td class="text-center"><img
                                                src="<?= base_url('assets/images/kost/' . $value->foto) ?>" width="100px">
                                        </td>
                                        <td class="text-center">
                                            <h4><span class="badge bg-primary">
                                                    <?= $value->total_gambar ?>
                                                </span></h4>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/gambarkost/tambah/' . $value->id_kost) ?>"
                                                class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Gambar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view('back/footer') ?>
</div><!-- ./wrapper -->
<?php $this->load->view('back/js') ?>
<!-- DATA TABLES-->
<link href="<?php echo base_url('assets/plugins/') ?>datatables/dataTables.bootstrap.css" rel="stylesheet"
    type="text/css" />
<script src="<?php echo base_url('assets/plugins/') ?>datatables/jquery.dataTables.min.js"
    type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/') ?>datatables/dataTables.bootstrap.min.js"
    type="text/javascript"></script>
<script type="text/javascript">
    $('#datatable').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aaSorting": [[0, 'desc']],
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Semua"]]
    });
</script>
</body>

</html>