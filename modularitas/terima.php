<?php
echo "<div class='terima'>";
// Pastikan form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form
    $namaMotor = $_POST['nama_motor'];
    $idMotor = $_POST['id_motor'];
    $namaPemilik = $_POST['nama_pemilik'];
    $harga = $_POST['harga'];
    $satuan = $_POST['satuan'];
    $tanggalPembelian = $_POST['tanggalPembelian'];
    $jenisPembayaran = $_POST['jenisPembayaran'];
    $asuransi = isset($_POST['asuransi']) ? 'Ya' : 'Tidak';
    $warna = $_POST['warna'];

    if ($namaMotor == "" || $idMotor == "" || $namaPemilik == "" || $harga == "" || $satuan == "" || $tanggalPembelian == "" || $jenisPembayaran == "" || $warna == "") {
        echo "<div class='text-center'><img src='./public/Failed.png' alt='Failed' class='img-fluid' /><h1 class='text-3xl text-white font-semibold mb-5'>Add Motor Failed</h1></div>";
        return;
    }

    // Tangkap foto yang diunggah
    $nama_file = $_FILES['photo']['name']; // Nama file yang diunggah
    $ukuran_file = $_FILES['photo']['size']; // Ukuran file yang diunggah
    $nama_sementara = $_FILES['photo']['tmp_name']; // Lokasi sementara file yang diunggah

    // Pindahkan file yang diunggah ke lokasi yang diinginkan
    $lokasi_simpan = './public/uploads'; // Tentukan lokasi direktori penyimpanan foto
    $lokasi_simpan_file = $lokasi_simpan . '/' . $nama_file;
    move_uploaded_file($nama_sementara, $lokasi_simpan_file);

    // Buat data yang akan disimpan
    $data = "$nama_file, $namaMotor, $idMotor, $namaPemilik, $harga, $satuan, $tanggalPembelian, $jenisPembayaran, $asuransi, $warna";

    // Simpan data ke dalam file teks
    $file = fopen("data-motor.txt", "a");
    fwrite($file, $data . PHP_EOL);
    fclose($file);

    // Tampilkan pesan sukses dan data yang diinput
    echo "<div class='text-center'>";
    echo "<img src='./public/Success.png' alt='Success' class='img-fluid' />";
    echo "<h1 class='text-3xl text-white font-semibold mb-5'>Add Data Succeed</h1>";
    echo "<table class='table table-dark'>";
    echo "<thead><tr><th scope='col'>Field</th><th scope='col'>Value</th></tr></thead>";
    echo "<tbody>";
    echo "<tr><th scope='row'>Nama Motor</th><td>$namaMotor</td></tr>";
    echo "<tr><th scope='row'>ID Motor</th><td>$idMotor</td></tr>";
    echo "<tr><th scope='row'>Nama Pemilik</th><td>$namaPemilik</td></tr>";
    echo "<tr><th scope='row'>Harga</th><td>$harga</td></tr>";
    echo "<tr><th scope='row'>Satuan</th><td>$satuan</td></tr>";
    echo "<tr><th scope='row'>Tanggal Pembelian</th><td>$tanggalPembelian</td></tr>";
    echo "<tr><th scope='row'>Jenis Pembayaran</th><td>$jenisPembayaran</td></tr>";
    echo "<tr><th scope='row'>Asuransi</th><td>$asuransi</td></tr>";
    echo "<tr><th scope='row'>Warna</th><td>$warna</td></tr>";
    echo "<tr><th scope='row'>Foto</th><td><img src='$lokasi_simpan_file' alt='Motor Image'></td></tr>";
    echo "</tbody></table>";
    echo "<a href='index.php?target=all-products' class='btn btn-primary mt-3'>Show All Products</a>";
    echo "</div>";
echo "</div>";
?>