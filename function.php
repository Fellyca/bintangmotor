<?php
session_start();

//connect to database
$conn = mysqli_connect("localhost", "root", "", "bintang_motor");

//tambah barang baru
if(isset($_POST['addnewbarang'])){
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $stock = $_POST['stock'];
    $item = $_POST['item'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($conn, "insert into stock (kodebarang, namabarang, stock, item, harga, keterangan) values('$kodebarang', '$namabarang', '$stock', '$item', '$harga', '$keterangan')");
    if($addtotable){
        header('location:index.php');
    }
    else{
        echo 'Gagal';
        header('location:index.php');
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $idbeli = $_POST['idbeli'];
    $qtymasuk = $_POST['qtymasuk'];
    $keteranganmasuk = $_POST['keteranganmasuk'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $penambahan = $stocksekarang + $qtymasuk;

    $addtomasuk = mysqli_query($conn, "insert into masukstock (idbarang, idbeli, qty, keterangan) values('$barangnya', '$idbeli', '$qtymasuk', '$keteranganmasuk')");
    $updatestokmasuk = mysqli_query($conn, "update stock set stock='$penambahan' where idbarang='$barangnya'");
    if($addtomasuk && $updatestokmasuk){
        header("location:viewmasuk.php?idp=$idbeli");
    }
    else{
        echo 'Gagal';
        header("location:viewmasuk.php?idp=$idbeli");
    }
}

if (isset($_POST['nota'])){
    $pembeli = $_POST['pembeli'];
    $nohp = $_POST['nohp'];
    $addtomasuk = mysqli_query($conn, "insert into orderan (pembeli, nohp) values('$pembeli', '$nohp')");
    if($addtomasuk){
        header('location:keluarstock.php');
    }
    else{
        echo 'Gagal';
        header('location:keluarstock.php');
    }
}

if (isset($_POST['notabeli'])){
    $supliernya = $_POST['supliernya'];
    $totalbiaya = $_POST['totalbiaya'];
    $addtomasuk = mysqli_query($conn, "insert into belian (idsuplier, totalbiaya) values('$supliernya', '$totalbiaya')");
    if($addtomasuk){
        header('location:masukstock.php');
    }
    else{
        echo 'Gagal';
        header('location:masukstock.php');
    }
}

if (isset($_POST['adddetail'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangann'];
    $idp = $_POST['idorder'];
    $diskon = $_POST['diskon'];
    $totalsemua2 = $_POST['totalsemua2'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $pengurangan = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "insert into keluarstock (idbarang, qty, keterangan, idorder, diskon) values('$barangnya', '$qty', '$keterangan', '$idp', '$diskon')");
    $updatestokkeluar = mysqli_query($conn, "update stock set stock='$pengurangan' where idbarang='$barangnya'");
    
    if($addtokeluar && $updatestokkeluar){
        header("location:view.php?idp=$idp");
    }
    else{
        echo 'Gagal';
        header("location:view.php?idp=$idp");
    }
}

//mengurang barang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $pembelinya = $_POST['pembelinya'];
    $qtykeluar = $_POST['qtykeluar'];
    $keterangankeluar = $_POST['keterangankeluar'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $pengurangan = $stocksekarang - $qtykeluar;

    $addtokeluar = mysqli_query($conn, "insert into keluarstock (idbarang, idpembeli, qty, keterangan) values('$barangnya', '$pembelinya', '$qtykeluar', '$keterangankeluar')");
    $updatestokkeluar = mysqli_query($conn, "update stock set stock='$pengurangan' where idbarang='$barangnya'");
    if($addtokeluar && $updatestokkeluar){
        header('location:keluarstock.php');
    }
    else{
        echo 'Gagal';
        header('location:keluarstock.php');
    }
}

//update barang
if(isset($_POST['updatebarang'])){
    $idbarang = $_POST['idbarang'];
    $kodebarang = $_POST['kodebarang'];
    $namabarang = $_POST['namabarang'];
    $item = $_POST['item'];
    $harga = $_POST['harga'];
    $keterangan = $_POST['keterangan'];

    $update = mysqli_query($conn, "update stock set kodebarang = '$kodebarang', namabarang = '$namabarang', item = '$item', harga = '$harga', keterangan='$keterangan' where idbarang = '$idbarang'");
    if($update){
        header('location:index.php');
    }
    else{
        echo 'Gagal';
        header('location:index.php');
    }
    
}

//delete barang
if(isset($_POST['hapusbarang'])){
    $idbarang = $_POST['idbarang'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang = '$idbarang'");
    if($hapus){
        header('location:index.php');
    }
    else{
        echo 'Gagal';
        header('location:index.php');
    }
    
}

//update barang masuk
if(isset($_POST['updatemasuk'])){
    $idp = $_POST['idbeli'];
    $idms = $_POST['idms'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];
    $idbarang = $_POST['idbarang'];
   
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
    $lihatqty = mysqli_query($conn, "select * from masukstock where idms='$idms'");
    $qtynya = mysqli_fetch_array($lihatqty);
    $qtyskrg = $qtynya['qty'];

    $selisih = $qty - $qtyskrg;
    $kurangin = $stockskrg + $selisih;
    if($kurangin < 0){
        $message = "<div class='alert alert-danger alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Gagal!</strong> Stock menjadi kurang/minus.
      </div>";
      
    }
    else{
        $message="";
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang = '$idbarang'");
        $updatenya = mysqli_query($conn, "update masukstock set qty='$qty', keterangan='$keterangan' where masukstock.idms='$idms'");
        
        if($kuranginstocknya&&$updatenya){
            header("location:viewmasuk.php?idp=$idp");
        }
        else{
            echo 'Gagal';
            header("location:viewmasuk.php?idp=$idp");
        }
    }
    file_put_contents('data.txt', $message);
    
    
}

if(isset($_POST['hapusmasuk'])){
    $idms = $_POST['idms'];
    $kty = $_POST['kty'];
    $idp = $_POST['idbeli'];
    $idbarang = $_POST['idbarang'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $selisih = $stockskrg - $kty;
    $kuranginstocknya = mysqli_query($conn, "update stock set stock='$selisih' where idbarang = '$idbarang'");
    $hapus = mysqli_query($conn, "delete from masukstock where idms = '$idms'");
    if($hapus){
        header("location:viewmasuk.php?idp=$idp");
    }
    else{
        echo 'Gagal';
        header("location:viewmasuk.php?idp=$idp");
    }
    
}

if(isset($_POST['hapusbarang2'])){
    $idks = $_POST['idks'];
    $qty = $_POST['qty'];
    $idbarang = $_POST['idbarang'];
    $idp = $_POST['idorder'];
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
    $selisih = $stockskrg + $qty;
    $kuranginstocknya = mysqli_query($conn, "update stock set stock='$selisih' where idbarang = '$idbarang'");
    $hapus = mysqli_query($conn, "delete from keluarstock where idks = '$idks'");
    if($hapus){
        header("location:view.php?idp=$idp");
    }
    else{
        echo 'Gagal';
        header("location:view.php?idp=$idp");
    }
    
}
if(isset($_POST['updatebarang2'])){
    $idks = $_POST['idks'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];
    $idp = $_POST['idorder'];
    $idbarang = $_POST['idbarang'];
    $totalsemua2 = $_POST['totalsemua2'];
   
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
    $lihatqty = mysqli_query($conn, "select * from keluarstock where idks='$idks'");
    $qtynya = mysqli_fetch_array($lihatqty);
    $qtyskrg = $qtynya['qty'];

    $selisih = $qty - $qtyskrg;
    $kurangin = $stockskrg - $selisih;
    if($kurangin < 0){
        $message = "<div class='alert alert-danger alert-dismissible'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Gagal!</strong> Stock menjadi kurang/minus.
      </div>";
      
    }
    else{
        $message="";
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang = '$idbarang'");
        $updatenya = mysqli_query($conn, "update keluarstock set qty='$qty', keterangan='$keterangan' where keluarstock.idks='$idks'");
        
        if($kuranginstocknya&&$updatenya){
            header("location:view.php?idp=$idp");
        }
        else{
            echo 'Gagal';
            header("location:view.php?idp=$idp");
        }
    }
    file_put_contents('data.txt', $message);
    
    
}
if(isset($_POST['hapusnota'])){
    $idp = $_POST['idorder'];
    $check = TRUE;

    // Ambil semua item yang terkait dengan nota
    $lihatitem = mysqli_query($conn, "SELECT * FROM keluarstock WHERE idorder='$idp'");
    
    while ($barangnya = mysqli_fetch_array($lihatitem)) {
        $idks = $barangnya['idks'];
        $qty = $barangnya['qty'];
        $idbarang = $barangnya['idbarang'];
        
        // Ambil stok saat ini
        $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
        $stocknya = mysqli_fetch_array($lihatstock);
        $stockskrg = $stocknya['stock'];

        // Hitung stok baru
        $selisih = $stockskrg + $qty;
        
        // Update stok barang
        $kuranginstocknya = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang = '$idbarang'");
        
        // Hapus item barang
        $hapus = mysqli_query($conn, "DELETE FROM keluarstock WHERE idks = '$idks'");
        
        // Jika ada kesalahan dalam menghapus atau mengupdate stok, tampilkan pesan error
        if (!$hapus || !$kuranginstocknya) {
            echo 'Gagal menghapus item barang atau mengupdate stok';
            $check = FALSE;
            exit; // Keluar dari loop jika terjadi kesalahan
        }
    }
    $hapus = mysqli_query($conn, "delete from orderan where idorder = '$idp'");
    if($hapus&&$check=TRUE){
        header("keluarstock.php");
    }
    else{
        echo 'Gagal';
        header("keluarstock.php");
    }
}

if(isset($_POST['hapusnotabeli'])){
    $idp = $_POST['idbeli'];
    $check = TRUE;

    // Ambil semua item yang terkait dengan nota
    $lihatitem = mysqli_query($conn, "SELECT * FROM masukstock WHERE idbeli='$idp'");
    
    while ($barangnya = mysqli_fetch_array($lihatitem)) {
        $idms = $barangnya['idms'];
        $qty = $barangnya['qty'];
        $idbarang = $barangnya['idbarang'];
        
        // Ambil stok saat ini
        $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
        $stocknya = mysqli_fetch_array($lihatstock);
        $stockskrg = $stocknya['stock'];

        // Hitung stok baru
        $selisih = $stockskrg - $qty;
        
        // Update stok barang
        $kuranginstocknya = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang = '$idbarang'");
        
        // Hapus item barang
        $hapus = mysqli_query($conn, "DELETE FROM masukstock WHERE idms = '$idms'");
        
        // Jika ada kesalahan dalam menghapus atau mengupdate stok, tampilkan pesan error
        if (!$hapus || !$kuranginstocknya) {
            echo 'Gagal menghapus item barang atau mengupdate stok';
            $check = FALSE;
            exit; // Keluar dari loop jika terjadi kesalahan
        }
    }
    $hapus = mysqli_query($conn, "delete from belian where idbeli = '$idp'");
    if($hapus&&$check=TRUE){
        header("masukstock.php");
    }
    else{
        echo 'Gagal';
        header("masukstock.php");
    }
}

// if(isset($_POST['hapusnota'])){
//     $idp = $_POST['idorder'];

//     $idks = $_POST['idks'];
//     $qty = $_POST['qty'];
//     $idbarang = $_POST['idbarang'];
    
//     $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idbarang'");
//     $stocknya = mysqli_fetch_array($lihatstock);
//     $stockskrg = $stocknya['stock'];

//     $lihatitem = mysqli_query($conn, "select * from keluarstock where idorder='$idp'");
//     $barangnya = mysqli_fetch_array($barangnya);
//     $qty = $barangnya['qty'];


    
//     $selisih = $stockskrg + $qty;
//     $kuranginstocknya = mysqli_query($conn, "update stock set stock='$selisih' where idbarang = '$idbarang'");
//     $hapus = mysqli_query($conn, "delete from keluarstock where idks = '$idks'");
//     if($hapus){
//         header("location:view.php?idp=$idp");
//     }
//     else{
//         echo 'Gagal';
//         header("location:view.php?idp=$idp");
//     }
    
// }

//tambah barang baru
if(isset($_POST['addnewsuplier'])){
    $namasuplier = $_POST['namasuplier'];
    $keterangan = $_POST['keterangan'];
    $nohp = $_POST['nohp'];

    $addtotable = mysqli_query($conn, "insert into suplier (namasuplier, keterangan, nohp) values('$namasuplier', '$keterangan', '$nohp')");
    if($addtotable){
        header('location:suplier.php');
    }
    else{
        echo 'Gagal';
        header('location:suplier.php');
    }
}

if(isset($_POST['updatesuplier'])){
    $idsuplier = $_POST['idsuplier'];
    $namasuplier = $_POST['namasuplier'];
    $keterangan = $_POST['keterangan'];
    $nohp = $_POST['nohp'];

    $update = mysqli_query($conn, "update suplier set namasuplier = '$namasuplier', keterangan='$keterangan', nohp='$nohp' where idsuplier = '$idsuplier'");
    if($update){
        header('location:suplier.php');
    }
    else{
        echo 'Gagal';
        header('location:suplier.php');
    }  
}

if(isset($_POST['hapussuplier'])){
    $idsuplier = $_POST['idsuplier'];

    $hapus = mysqli_query($conn, "delete from suplier where idsuplier = '$idsuplier'");
    if($hapus){
        header('location:suplier.php');
    }
    else{
        echo 'Gagal';
        header('location:suplier.php');
    }
    
}