<?php
// Mulai sesi
include 'check_activity.php';

// Periksa apakah pengguna belum login dan mencoba mengakses halaman CRUDProduct.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan pengguna kembali ke halaman login
    header("location: login.php");
    exit;
}

// Periksa apakah waktu terakhir akses dalam cookie sudah lebih dari 5 menit yang lalu
if (isset($_COOKIE['last_activity']) && (time() - $_COOKIE['last_activity']) > (5 * 60)) {
    // Hapus sesi pengguna
    session_destroy();

    // Redirect ke halaman login setelah logout otomatis
    header("location: login.php");
    exit;
}

// Perbarui waktu terakhir akses dalam cookie
setcookie('last_activity', time(), time() + (5 * 60), "/"); // Cookie akan diperbarui setiap kali pengguna mengakses halaman

// Halaman berikutnya
// Tambahkan konten halaman yang diinginkan di sini
require "koneksi.php";
// Proses penghapusan data
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if (hapusData($id)) {
        echo "Data motor berhasil dihapus.";
        header("Location: index.php?target=tabelproduct");
        exit;
    } else {
        echo "Gagal menghapus data motor.";
    }
}

// Mengambil semua data dari database
$data = ambilSemuaData();
?>

<body class="formulir">
    <div class="col-sm-8 mx-auto">
        <table class="table table-dark mt-5" style="width: 85%; margin:auto;">
            <tr>
                <th>ID Motor</th>
                <th>Nama Motor</th>
                <th>Nama Pemilik</th>
                <th>Harga</th>
                <th>Merk</th>
                <th>Satuan</th>
                <th>Tanggal Pembelian</th>
                <th>Jenis Pembayaran</th>
                <th>Asuransi</th>
                <th>Warna</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
            <?php
            foreach ($data as $row) {
                echo "<tr>";
                echo "<td>" . $row["id_motor"] . "</td>";
                echo "<td>" . $row["nama_motor"] . "</td>";
                echo "<td>" . $row["nama_pemilik"] . "</td>";
                echo "<td>Rp" . number_format($row["harga"], 0, ',', '.') . "</td>";
                echo "<td>" . $row["nama_merk"] . "</td>";
                echo "<td>" . $row["satuan"] . "</td>";
                echo "<td>" . $row["tanggal_pembelian"] . "</td>";
                echo "<td>" . $row["jenis_pembayaran"] . "</td>";
                echo "<td>" . ($row["asuransi"] == "yes" ? "Ya" : "Tidak") . "</td>";
                echo "<td>" . $row["warna"] . "</td>";
                echo "<td><img src='public/uploads/" . $row["foto"] . "' width='100' height='100' onerror=\"this.onerror=null; this.src='path/to/default/image.png'\"></td>";
                echo "<td>
                        <a href='index.php?target=edit&id=" . $row["id"] . "' class='btn btn-light'>Edit</a>
                        <a href='index.php?target=tabelproduct&delete_id=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data motor ini?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
