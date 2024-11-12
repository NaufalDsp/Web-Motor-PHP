<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga_motor = $_POST["harga_motor"];
    $uang_muka_persen = $_POST["uang_muka"];
    $tenor = $_POST["tenor"];
    $bunga_pinjaman = $_POST["bunga_pinjaman"] / 100;
    $metode_perhitungan = $_POST["motor_anda"];

    $uang_muka = $harga_motor * ($uang_muka_persen / 100);
    $jumlah_pinjaman = $harga_motor - $uang_muka;

    switch ($metode_perhitungan) {
        case "Flat":
            $bunga_total = $jumlah_pinjaman * $bunga_pinjaman * $tenor;
            $angsuran_per_bulan = ($jumlah_pinjaman + $bunga_total) / ($tenor * 12);
            $total_pembayaran = $angsuran_per_bulan * ($tenor * 12);
            break;
        case "Floating":
            $bunga_per_bulan = $jumlah_pinjaman * $bunga_pinjaman / 12;
            $angsuran_pokok_per_bulan = $jumlah_pinjaman / ($tenor * 12);
            $angsuran_per_bulan = $angsuran_pokok_per_bulan + $bunga_per_bulan;
            $total_pembayaran = $angsuran_per_bulan * ($tenor * 12);
            break;
        case "Fixed":
            $bunga_per_bulan = $jumlah_pinjaman * $bunga_pinjaman / 12;
            $angsuran_pokok_per_bulan = $jumlah_pinjaman / ($tenor * 12);
            $angsuran_per_bulan = $angsuran_pokok_per_bulan + $bunga_per_bulan;
            $total_pembayaran = $angsuran_per_bulan * ($tenor * 12);
            break;
        case "Effective":
            $bunga_efektif = (pow(1 + $bunga_pinjaman, 1 / 12) - 1);
            $angsuran_per_bulan = $jumlah_pinjaman * $bunga_efektif * pow(1 + $bunga_efektif, $tenor * 12) / (pow(1 + $bunga_efektif, $tenor * 12) - 1);
            $total_pembayaran = $angsuran_per_bulan * ($tenor * 12);
            break;
        case "Annuity":
            $angsuran_per_bulan = ($jumlah_pinjaman * $bunga_pinjaman * pow(1 + $bunga_pinjaman, $tenor * 12)) / (pow(1 + $bunga_pinjaman, $tenor * 12) - 1);
            $total_pembayaran = $angsuran_per_bulan * ($tenor * 12);
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Kredit Motor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
   
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<table class="table table-striped table-hover">
    <tr class="table-dark">
        <th colspan="3" class="text-center">HASIL SIMULASI KREDIT MOTOR</th>
    </tr>
    <tr>
        <th>Data Anda</th>
        <th colspan="2"></th>
    </tr>
    <tr>
        <td>Harga Motor</td>
        <td colspan="2">Rp <?php echo number_format($harga_motor, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Uang Muka</td>
        <td colspan="2">Rp <?php echo number_format($uang_muka, 0, ',', '.'); ?> (<?php echo $uang_muka_persen; ?>%)</td>
    </tr>
    <tr>
        <td>Tenor</td>
        <td colspan="2"><?php echo $tenor; ?> Tahun</td>
    </tr>
    <tr>
        <td>Margin Bank</td>
        <td colspan="2"><?php echo ($bunga_pinjaman * 100); ?>%</td>
    </tr>
    <tr>
        <td>Perhitungan Margin</td>
        <td colspan="2"><?php echo $metode_perhitungan; ?></td>
    </tr>
</table>

<table class="table table-striped table-hover">
    <tr class="table-dark">
        <th>Pinjaman Anda</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td>Plafon Pinjaman</td>
        <td colspan="2">Rp <?php echo number_format($jumlah_pinjaman, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Angsuran per Bulan</td>
        <td colspan="2">Rp <?php echo number_format($angsuran_per_bulan, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Total Periode</td>
        <td colspan="2"><?php echo $tenor; ?> Tahun</td>
    </tr>
    <tr>
        <td>Total Pembayaran</td>
        <td colspan="2">Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></td>
    </tr>
</table>

<table class="table table-striped table-hover">
    <tr class="table-dark">
        <th>Penghasilan Minimum per Bulan</th>
        <th></th>
    </tr>
    <tr>
        <td>Angsuran 25% dari Penghasilan</td>
        <td>Rp <?php echo number_format($angsuran_per_bulan * 0.25, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Angsuran 30% dari Penghasilan</td>
        <td>Rp <?php echo number_format($angsuran_per_bulan * 0.3, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Angsuran 1/3 dari Penghasilan</td>
        <td>Rp <?php echo number_format($angsuran_per_bulan * (1/3), 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Angsuran 35% dari Penghasilan</td>
        <td>Rp <?php echo number_format($angsuran_per_bulan * 0.35, 0, ',', '.'); ?></td>
    </tr>
    <tr>
        <td>Angsuran 40% dari Penghasilan</td>
        <td>Rp <?php echo number_format($angsuran_per_bulan * 0.4, 0, ',', '.'); ?></td>
    </tr>
</table>
    
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $harga_motor = $_POST["harga_motor"];
    $uang_muka_persen = $_POST["uang_muka"];
    $tenor = $_POST["tenor"];
    $bunga_pinjaman = $_POST["bunga_pinjaman"] / 100;
    $metode_perhitungan = $_POST["motor_anda"];
    $uang_muka = $harga_motor * ($uang_muka_persen / 100);
    $jumlah_pinjaman = $harga_motor - $uang_muka;
    $tenor_bulan = $tenor * 12;
    echo "<h3 class='mt-5'>Tabel Angsuran</h3>";
    echo "<table class='table table-striped table-hover'>";
    echo "<tr><th>Bulan</th><th>Angsuran Margin</th><th>Angsuran Pokok</th><th>Total Angsuran</th><th>Sisa Pinjaman</th></tr>";
    switch ($metode_perhitungan) {
        case "Flat":
            $angsuran_per_bulan = $jumlah_pinjaman / $tenor_bulan;
            $bunga_total = $jumlah_pinjaman * $bunga_pinjaman * $tenor;
            $angsuran_margin_per_bulan = $bunga_total / $tenor_bulan;
            $angsuran_pokok_per_bulan = $angsuran_per_bulan - $angsuran_margin_per_bulan;
            $sisa_pinjaman = $jumlah_pinjaman;
            $total_angsuran_margin = 0;
            $total_angsuran_pokok = 0;
            $total_angsuran = 0;
            $bulan = 1;
            while ($sisa_pinjaman > 0) {
                echo "<tr>";
                echo "<td>" . $bulan . "</td>";
                echo "<td>Rp " . number_format($angsuran_margin_per_bulan, 2, ',', '.') . "</td>";
    
                // Menghitung angsuran pokok dengan memastikan tidak minus
                $angsuran_pokok_saat_ini = min($angsuran_pokok_per_bulan, $sisa_pinjaman);
                echo "<td>Rp " . number_format($angsuran_pokok_saat_ini, 2, ',', '.') . "</td>";
    
                echo "<td>Rp " . number_format($angsuran_per_bulan, 2, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($sisa_pinjaman, 2, ',', '.') . "</td>";
                echo "</tr>";
    
                $sisa_pinjaman -= $angsuran_pokok_saat_ini;
                $total_angsuran_margin += $angsuran_margin_per_bulan;
                $total_angsuran_pokok += $angsuran_pokok_saat_ini;
                $total_angsuran += $angsuran_per_bulan;
                $bulan++;
            }
            echo "<tr>";
            echo "<td>" . $bulan . "</td>";
            echo "<td>Rp " . number_format($angsuran_margin_per_bulan, 2, ',', '.') . "</td>";
            echo "<td>Rp " . number_format($sisa_pinjaman, 2, ',', '.') . "</td>";
            echo "<td>Rp " . number_format($sisa_pinjaman + $angsuran_margin_per_bulan, 2, ',', '.') . "</td>";
            echo "<td>Rp 0</td>";
            echo "</tr>";
            $total_angsuran_margin += $angsuran_margin_per_bulan;
            $total_angsuran_pokok += $sisa_pinjaman;
            $total_angsuran += $sisa_pinjaman + $angsuran_margin_per_bulan;
            echo "<tr><td><strong>Total</strong></td><td><strong>Rp " . number_format($total_angsuran_margin, 2, ',', '.') . "</strong></td><td><strong>Rp " . number_format($total_angsuran_pokok, 2, ',', '.') . "</strong></td><td><strong>Rp " . number_format($total_angsuran, 2, ',', '.') . "</strong></td><td></td></tr>";
            break;
    }
    echo "</table>";
}
?>
        <?php else: ?>
            <p>Silakan isi form kredit motor terlebih dahulu.</p>
        <?php endif; ?>
    </div>
</body>
</html>