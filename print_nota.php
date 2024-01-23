<?php
require('fpdf/fpdf.php'); // Sesuaikan dengan lokasi Anda menyimpan FPDF
require('function.php'); // Sesuaikan dengan lokasi file koneksi Anda

if (!isset($_SESSION["log"])) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit();
}
$idp = $_GET['idp'];

if(isset($_GET['idp'])){
    $idp = $_GET['idp'];
} else{
    header("location:view.php?idp=$idp");
}
class PDF extends FPDF {
    function Header() {
        header('Content-Type: application/pdf');
    }

    function Footer() {
        // Tambahkan footer PDF Anda di sini jika diperlukan
    }

    function GeneratePDF($data) {
        $this->SetLineWidth(0.2);
        
        $this->SetFont('Arial', '', 12);

        $this->Cell(10, 10, 'No.', 1, 0, 'C');
        $this->Cell(65, 10, 'Nama Barang', 1, 0, 'C');
        //$this->Cell(30, 10, 'Tanggal', 1, 0, 'C');
        $this->Cell(15, 10, 'QTY', 1, 0, 'C');
        $this->Cell(15, 10, 'Item', 1, 0, 'C');
        $this->Cell(30, 10, 'Harga', 1, 0, 'C');
        $this->Cell(20, 10, 'Diskon', 1, 0, 'C');
        $this->Cell(35, 10, 'Total', 1, 0, 'C');
        // $this->Cell(30, 10, 'Keterangan', 1, 0, 'C');
        $this->Ln();

        // Tulis konten nota Anda di sini
        $i = 1;
        $totalsemua = 0;
        $totaldiskon = 0;
        $totalsemua2 = 0;
        foreach ($data as $row) {
            $total = $row['qty'] * $row['harga'];
            $totaldiskon = $totaldiskon + $row['diskon'];
            $totalsemua2 = $total - $row['diskon'];
            $totalsemua = $totalsemua + $total;
            $this->Cell(10, 10, $i++, 1, 0, 'C');
            $mkText = strlen($row['namabarang']) > 30 ? substr($row['namabarang'], 0, 30) : $row['namabarang'];
            $this->Cell(65, 10, $mkText, 1);
            //$this->Cell(30, 10, $row['tanggal'], 1);
            $this->Cell(15, 10, $row['qty'], 1, 0, 'C');
            $this->Cell(15, 10, $row['item'], 1, 0, 'C');
            $this->Cell(30, 10, 'Rp. ' . number_format($row['harga'], 0, ',', '.'), 1);
            $this->Cell(20, 10, 'Rp. ' . number_format($row['diskon'], 0, ',', '.'),1);
            $this->Cell(35, 10, 'Rp. ' . number_format($totalsemua2, 0, ',', '.'), 1);
            // $this->Cell(30, 10, $row['mk'], 1);
            $this->Ln(); // Pindah ke baris berikutnya
        }
        $this->Cell(155, 10, 'Total', 1, 0, 'R');
        $this->Cell(35, 10, 'Rp. ' . number_format($totalsemua, 0, ',', '.'), 1);
        $this->Ln();
        $this->Cell(155, 10, 'Total Diskon', 1, 0, 'R');
        $this->Cell(35, 10, 'Rp. ' . number_format($totaldiskon, 0, ',', '.'), 1);
        $this->Ln();
        $this->Cell(155, 10, 'Total Semua', 1, 0, 'R');
        $this->Cell(35, 10, 'Rp. ' . number_format($totalsemua- $totaldiskon, 0, ',', '.'), 1);

        $this->Output(); // Output PDF
    }
}

$idp = $_GET['idp']; // Sesuaikan dengan cara Anda mendapatkan ID nota
$data = array(); // Inisialisasi array untuk data nota

//Ambil data nota berdasarkan ID nota (Anda perlu mengganti kueri SQL sesuai dengan tabel Anda)
$query = mysqli_query($conn, "SELECT *, k.keterangan as mk FROM keluarstock k, stock s WHERE idorder = $idp AND k.idbarang = s.idbarang");

$lihatnota = mysqli_query($conn, "SELECT * FROM orderan WHERE idorder=$idp");
$nota = mysqli_fetch_array($lihatnota);
$tanggal = $nota['tanggal'];
$pembeli = $nota['pembeli'];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

$pdf = new PDF();
$pdf->AddPage();
$imageFile = 'D:\xampp\htdocs\bintangmotor\BintangMotor.png';
$pdf->Image($imageFile, 20, 0, 70);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(250,10,'BINTANG MOTOR JAMBI',0,5,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(245,10,'Menjual Sparepart, Servis Motor,',0,5,'C');
$pdf->Cell(247,0,'Ganti Oli, Bongkar Pasang Mesin,',0,5,'C');
$pdf->Cell(235,10,'Tempel Ban Tubeless, DLL',0,5,'C');
$pdf->Cell(239,10,'Jl. Yunus Sanis No.82 RT.04',0,5,'C');
$pdf->Cell(224,0,'Kebun Handil, Jambi',0,5,'C');
$pdf->SetFont('Arial','B',14);
$pdf->SetLineWidth(1);
$pdf->Line(10, 60, 200, 60);
$pdf->SetXY(10, 55);
$pdf->Cell(150,20,'',0,5,'C');
$pdf->Cell(50,8,'Nota         : BM/NTJL/'.$idp,0,5);
$pdf->Cell(50,8,'Pembeli   : '.$pembeli,0,5);
$pdf->Cell(50,8,'Tanggal   : '.$tanggal,0,5);
$pdf->Cell(50,8,'',0,5);
$pdf->GeneratePDF($data);
?>






<!-- <?php
// Sertakan fungsi dan koneksi ke database yang diperlukan
require 'function.php';

function getNamaBarang($idbarang) {
    $conn = mysqli_connect("localhost", "root", "", "bintang_motor");
    // Query untuk mengambil data nama barang berdasarkan idbarang
    $namabarang = mysqli_query($conn, "SELECT namabarang FROM stock WHERE idbarang = $idbarang");
    $barang = mysqli_fetch_array($namabarang);
    $barangnya = $barang[0];
    return $barangnya;
}


//Periksa apakah ada item dalam keranjang
if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
    // Atur header Content-Type menjadi PDF
    header('Content-Type: application/pdf');
    
    // Buat dokumen PDF
    require('fpdf/fpdf.php'); // Sertakan library FPDF

    // Buat instance baru dari PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $imageFile = 'D:\xampp\htdocs\bintangmotor\BintangMotor.png';
    $pdf->Image($imageFile, 70, 0, 70);
    $pdf->SetFont('Arial','B',16);
    $pdf->SetXY(10, 55);
    $pdf->Cell(50,10,'Nota         : BM/NTBL/',0,5);
    $pdf->Cell(50,10,'Pembeli   : '.$_SESSION['pembeli'],0,5);
    $pdf->Cell(50,10,'Nama Barang','C');
    $pdf->Cell(50,10,'Harga','C');
    $pdf->Cell(20,10,'Qty','C');
    $pdf->Cell(30,10,'Diskon','C');
    $pdf->Cell(50,10,'Total','C',1);
    $total_diskon = 0;

    // Loop melalui item dalam keranjang dan tambahkan ke PDF
    foreach ($_SESSION['keranjang'] as $item) {
        $nama_barang = getNamaBarang($item['idbarang']); // Fungsi untuk mendapatkan nama barang berdasarkan idbarang
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50,10,$nama_barang,0,0);
        $pdf->Cell(50,10,"Rp." . number_format($item['harga'], 0, ',', '.'),0,0);
        $pdf->Cell(20,10,$item['qty_barang'],0,0);
        $pdf->Cell(30,10,"Rp." . number_format($item['diskon'], 0, ',', '.'),0,0);
        $pdf->Cell(50,10,"Rp." . number_format($item['total_pembayaran'], 0, ',', '.'),0,1);
        $total_diskon = $total_diskon + $item['hasil_diskon'];
    }
    $pdf->SetFont('Arial','B',13);
    $pdf->Cell(50,10,"JUMLAH: Rp." . number_format($_SESSION['totalsemua'], 0, ',', '.'),'C',1);
    $pdf->Cell(50,10,"TOTAL DISKON: Rp." . number_format($total_diskon, 0, ',', '.'),'C',1);
    $pdf->Cell(50,10,"TOTAL SEMUA: Rp." . number_format($_SESSION['totalsemua']-$total_diskon, 0, ',', '.'),'C',1);

    $pdf->Output();
} else {
    echo 'Tidak ada item dalam keranjang.';
}
//session_destroy();
?> -->
