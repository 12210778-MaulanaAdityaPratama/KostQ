<?php $this->load->view('back/meta') ?>
<div class="wrapper">
    <?php $this->load->view('back/navbar') ?>
    <?php $this->load->view('back/sidebar') ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-11">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h1>Laporan Transaksi</h1>
                            <form method="post" action="<?php echo base_url('admin/laporan'); ?>">
                                <div class="form-group">
                                    <label for="month">Bulan:</label>
                                    <select name="month" id="month" class="form-control" <?php echo ($show_all) ? 'disabled' : ''; ?>>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == $selected_month) ? 'selected' : ''; ?>>
                                                <?php echo date('F', mktime(0, 0, 0, $i, 10)); ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="year">Tahun:</label>
                                    <select name="year" id="year" class="form-control" <?php echo ($show_all) ? 'disabled' : ''; ?>>
                                        <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == $selected_year) ? 'selected' : ''; ?>>
                                                <?php echo $i; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="show_all">
                                        <input type="checkbox" name="show_all" id="show_all" value="1" <?php echo ($show_all) ? 'checked' : ''; ?>> Tampilkan Semua Transaksi
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>

                            <!-- Tabel untuk transaksi yang belum lunas -->
                            <h2>Transaksi Belum Lunas</h2>
                            <div class="table-responsive">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th>Nama Pengguna</th>
                <th>Status</th>
                <th>Tanggal Pesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan_unpaid)): ?>
                <?php foreach ($laporan_unpaid as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['id_invoice']; ?></td>
                        <td>Rp.<?php echo number_format($transaction['subtotal'], 0, ',', '.'); ?></td>
                        <td>Rp.<?php echo number_format($transaction['diskon'], 0, ',', '.'); ?></td>
                        <td>Rp.<?php echo number_format($transaction['grand_total'], 0, ',', '.'); ?></td>
                        <td><?php echo $transaction['user_name']; ?></td>
                        <td>
                            <?php 
                                if ($transaction['status'] == 0) {
                                    echo 'Belum Checkout';
                                } elseif ($transaction['status'] == 1) {
                                    echo 'Belum Lunas';
                                }
                            ?>
                        </td>
                        <td><?php echo date('d-m-Y', strtotime($transaction['created_date']));?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi belum lunas pada bulan ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="1">Total</th>
                <th>Rp.<?php echo number_format($totals_unpaid['subtotal'] ?? 0, 0, ',', '.'); ?></th>
                <th>Rp.<?php echo number_format($totals_unpaid['diskon'] ?? 0, 0, ',', '.'); ?></th>
                <th>Rp.<?php echo number_format($totals_unpaid['grand_total'] ?? 0, 0, ',', '.'); ?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
                            </div>

                            <!-- Tabel untuk transaksi yang sudah lunas -->
                            <h2>Transaksi Lunas</h2>
                            <div class="table-responsive">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th>Nama Pengguna</th>
                <th>Status</th>
                <th>Tanggal Pesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan_paid)): ?>
                <?php foreach ($laporan_paid as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['id_invoice']; ?></td>
                        <td>Rp.<?php echo number_format($transaction['subtotal'], 0, ',', '.'); ?></td>
                        <td>Rp.<?php echo number_format($transaction['diskon'], 0, ',', '.'); ?></td>
                        <td>Rp.<?php echo number_format($transaction['grand_total'], 0, ',', '.'); ?></td>
                        <td><?php echo $transaction['user_name']; ?></td>
                        <td>Lunas</td>
                        <td><?php echo date('d-m-Y', strtotime($transaction['created_date']));?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi lunas pada bulan ini</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="1">Total</th>
                <th>Rp.<?php echo number_format($totals_paid['subtotal'] ?? 0, 0, ',', '.'); ?></th>
                <th>Rp.<?php echo number_format($totals_paid['diskon'] ?? 0, 0, ',', '.'); ?></th>
                <th>Rp.<?php echo number_format($totals_paid['grand_total'] ?? 0, 0, ',', '.'); ?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
                            </div>
                            <form method="post" action="<?php echo base_url('admin/laporan/generate_pdf'); ?>">
    <input type="hidden" name="month" value="<?php echo $selected_month; ?>">
    <input type="hidden" name="year" value="<?php echo $selected_year; ?>">
    <input type="hidden" name="show_all" value="<?php echo $show_all ? 1 : 0; ?>">
    <button type="submit" class="btn btn-success">Generate PDF</button>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php $this->load->view('back/footer') ?>
<?php $this->load->view('back/js') ?>
<link href="<?php echo base_url('assets/plugins/')?>datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="<?php echo base_url('assets/plugins/')?>datepicker/js/bootstrap-datepicker.js"></script>
<script>
    document.getElementById('show_all').addEventListener('change', function() {
        var isChecked = this.checked;
        document.getElementById('month').disabled = isChecked;
        document.getElementById('year').disabled = isChecked;
    });
</script>
</body>
</html>
