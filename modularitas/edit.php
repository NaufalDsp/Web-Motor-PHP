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
$id = $_GET['id']; // Gunakan $id untuk mengambil dan memperbarui record
$data = ambilDataBerdasarkanId($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_motor = $_POST["id_motor"];
    $nama_motor = $_POST["nama_motor"];
    $nama_pemilik = $_POST["nama_pemilik"];
    $harga = $_POST["harga"];
    $id_merk = $_POST["id_merk"];
    $satuan = $_POST["satuan"];
    $tanggal_pembelian = $_POST["tanggal_pembelian"];
    $jenis_pembayaran = $_POST["jenis_pembayaran"];
    $asuransi = isset($_POST['asuransi']) ? 'yes' : 'no';
    $warna = $_POST["warna"];

    $nama_file = $_FILES['photo']['name'];
    $ukuran_file = $_FILES['photo']['size'];
    $nama_sementara = $_FILES['photo']['tmp_name'];
    $lokasi_simpan = './public/uploads';
    $lokasi_simpan_file = $lokasi_simpan . '/' . $nama_file;

    if ($nama_file != '') {
        move_uploaded_file($nama_sementara, $lokasi_simpan_file);
    } else {
        $nama_file = $data['foto'];
    }

    // Update data menggunakan parameter yang benar
    if (updateData($id, $id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $nama_file, $id_merk)) {
        echo "<script>alert('Data berhasil diupdate.');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data.');</script>";
    }
}
?>

<body class="formulir">
    <div class="col-sm-8 mx-auto">
        <table border="1" bgcolor="lightcyan" class="table table-striped table-hover">
            <div class="card-body">
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <tr>
                        <td>ID Motor</td>
                        <td><input type="text" name="id_motor" required="" class="form-control" value="<?= $data['id_motor']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Nama Motor</td>
                        <td><input type="text" name="nama_motor" required="" class="form-control" value="<?= $data['nama_motor']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Nama Pemilik</td>
                        <td><input type="text" name="nama_pemilik" required="" class="form-control" value="<?= $data['nama_pemilik']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td><input type="text" name="harga" required="" class="form-control" value="<?= $data['harga']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Merk</td>
                        <td>
                            <select name="id_merk" required="" class="form-control">
                                <?php
                                $merkQuery = "SELECT id_merk, nama_merk FROM merk";
                                $merkResult = mysqli_query($conn, $merkQuery);
                                while ($row = mysqli_fetch_assoc($merkResult)) {
                                    echo "<option value='{$row['id_merk']}' " . ($data['id_merk'] == $row['id_merk'] ? 'selected' : '') . ">{$row['nama_merk']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Satuan</td>
                        <td><input type="text" name="satuan" required="" class="form-control" value="<?= $data['satuan']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembelian</td>
                        <td><input type="date" name="tanggal_pembelian" required="" class="form-control" value="<?= $data['tanggal_pembelian']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Jenis Pembayaran</td>
                        <td>
                            <div>
                                <input type="radio" id="cash" name="jenis_pembayaran" value="cash" <?= ($data['jenis_pembayaran'] == 'cash') ? 'checked' : ''; ?>>
                                <label for="cash">Cash</label>
                                <input type="radio" id="kredit" name="jenis_pembayaran" value="kredit" <?= ($data['jenis_pembayaran'] == 'kredit') ? 'checked' : ''; ?>>
                                <label for="kredit">Kredit</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Asuransi</td>
                        <td>
                            <div>
                                <input type="checkbox" id="asuransi" name="asuransi" value="yes" <?= ($data['asuransi'] == 'yes') ? 'checked' : ''; ?>>
                                <label for="asuransi">Ya</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Warna</td>
                        <td>
                            <select id="warna" name="warna" class="form-control" required="">
                                <option value="merah" <?= ($data['warna'] == 'merah') ? 'selected' : ''; ?>>Merah</option>
                                <option value="biru" <?= ($data['warna'] == 'biru') ? 'selected' : ''; ?>>Biru</option>
                                <option value="hitam" <?= ($data['warna'] == 'hitam') ? 'selected' : ''; ?>>Hitam</option>
                                <option value="abu abu" <?= ($data['warna'] == 'abu abu') ? 'selected' : ''; ?>>Abu Abu</option>
                                <option value="warna lain" <?= ($data['warna'] == 'warna lain') ? 'selected' : ''; ?>>Warna Lain</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Foto Motor</td>
                        <td>
                            <div>
                                <img src="./public/uploads/<?= $data['foto']; ?>" alt="Motor Image" width="100">
                                <input type="file" name="photo" class="form-control-file">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" class="btn btn-primary" name="submit" value="update">Update Data</button></td>
                    </tr>
                </form>
            </div>
        </table>
    </div>
</body>
