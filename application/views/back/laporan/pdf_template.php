<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1><?php echo $title; ?></h1>

    <h2>Transaksi Belum Lunas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th>Nama Pengguna</th>
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
                        <td><?php echo date('d-m-Y', strtotime($transaction['created_date']));?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi belum lunas pada bulan ini</td>
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

    <h2>Transaksi Lunas</h2>
    <table>
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Grand Total</th>
                <th>Nama Pengguna</th>
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
                        <td><?php echo date('d-m-Y', strtotime($transaction['created_date']));?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi lunas pada bulan ini</td>
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
</body>
</html>
