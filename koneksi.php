<?php
$host = "localhost"; // Hostname
$user = "root"; // MySQL username (ubah sesuai dengan pengguna MySQL Anda)
$password = ""; // MySQL password (ubah sesuai dengan kata sandi MySQL Anda)
$database = "motor_db"; // Nama database

// Buat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menyimpan data ke database
function tambahData($id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $foto, $id_merk) {
    global $conn;
    $sql = "INSERT INTO motor (id_motor, nama_motor, nama_pemilik, harga, satuan, tanggal_pembelian, jenis_pembayaran, asuransi, warna, foto, id_merk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $foto, $id_merk);
    return $stmt->execute();
}

// Fungsi untuk mengambil semua data dari database
function ambilSemuaData() {
    global $conn;
    $sql = "SELECT motor.*, merk.nama_merk FROM motor 
            JOIN merk ON motor.id_merk = merk.id_merk";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk mengambil data berdasarkan ID
function ambilDataBerdasarkanId($id) {
    global $conn;
    $sql = "SELECT motor.*, merk.nama_merk FROM motor 
            JOIN merk ON motor.id_merk = merk.id_merk 
            WHERE motor.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fungsi untuk menghapus data dari database
function hapusData($id) {
    global $conn;
    $sql = "DELETE FROM motor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Fungsi untuk mengupdate data di database
function updateData($id, $id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $foto, $id_merk) {
    global $conn;
    $sql = "UPDATE motor 
            SET id_motor = ?, nama_motor = ?, nama_pemilik = ?, harga = ?, satuan = ?, tanggal_pembelian = ?, jenis_pembayaran = ?, asuransi = ?, warna = ?, foto = ?, id_merk = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $id_motor, $nama_motor, $nama_pemilik, $harga, $satuan, $tanggal_pembelian, $jenis_pembayaran, $asuransi, $warna, $foto, $id_merk, $id);
    return $stmt->execute();
}
?>
