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
// Ambil data merk dari database
$merkQuery = "SELECT id_merk, nama_merk FROM merk";
$merkResult = mysqli_query($conn, $merkQuery);
$merkOptions = "";
while ($row = mysqli_fetch_assoc($merkResult)) {
    $merkOptions .= "<option value='{$row['id_merk']}'>{$row['nama_merk']}</option>";
}

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

    $nama_file = $_FILES["photo"]["name"];
    $ukuran_file = $_FILES["photo"]["size"];
    $nama_sementara = $_FILES["photo"]["tmp_name"];
    $lokasi_simpan = './public/uploads';
    $lokasi_simpan_file = $lokasi_simpan . '/' . $nama_file;

    if (move_uploaded_file($nama_sementara, $lokasi_simpan_file)) {
        // Memanggil fungsi untuk menyimpan data ke database
        if (tambahData($id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $nama_file, $id_merk)) {
            echo "<script>alert('Data berhasil disimpan.');window.location='index.php?target=tabel';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data.');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload foto.');</script>";
    }
}
?>

<body class="formulir">
    <div class="col-sm-8 mx-auto">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <table border="1" bgcolor="lightcyan" class="table table-striped table-hover">
                <tr>
                    <td>ID Motor</td>
                    <td><input type="text" name="id_motor" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Nama Motor</td>
                    <td><input type="text" name="nama_motor" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Nama Pemilik</td>
                    <td><input type="text" name="nama_pemilik" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="text" name="harga" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Merk</td>
                    <td>
                        <select name="id_merk" required="" class="form-control">
                            <?php echo $merkOptions; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Satuan</td>
                    <td><input type="text" name="satuan" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Tanggal Pembelian</td>
                    <td><input type="date" name="tanggal_pembelian" required="" class="form-control"></td>
                </tr>
                <tr>
                    <td>Jenis Pembayaran</td>
                    <td>
                        <div>
                            <input type="radio" id="cash" name="jenis_pembayaran" value="cash" required="">
                            <label for="cash">Cash</label>
                            <input type="radio" id="kredit" name="jenis_pembayaran" value="kredit">
                            <label for="kredit">Kredit</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Asuransi</td>
                    <td>
                        <div>
                            <input type="checkbox" id="asuransi" name="asuransi" value="yes">
                            <label for="asuransi">Ya</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td>
                        <select id="warna" name="warna" class="form-control" required="">
                            <option value="">Pilih Warna</option>
                            <option value="merah">Merah</option>
                            <option value="biru">Biru</option>
                            <option value="hitam">Hitam</option>
                            <option value="abu abu">Abu Abu</option>
                            <option value="warna lain">Warna Lain</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Foto Motor</td>
                    <td><input type="file" name="photo" class="form-control-file" required=""></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan Data</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
