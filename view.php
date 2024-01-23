<?php
require 'function.php';
if (!isset($_SESSION["log"])) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit();
}
$idp = $_GET['idp'];

if(isset($_GET['idp'])){
    $idp = $_GET['idp'];
} else{
    header('location:keluarstock.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Bintang Motor</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Stock</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masukstock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluarstock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Keluar
                            </a>
                            <div class="sb-sidenav-menu-heading">Suplier</div>
                            <a class="nav-link" href="suplier.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Suplier
                            </a>
                            <div class="sb-sidenav-menu-heading">Laporan</div>
                            <a class="nav-link" href="laporan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Keuangan
                            </a>
                            <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a> -->
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pesanan: NTJL<?=$idp;?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Daftar pesanan</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                            </button>
                            <a href="print_nota.php?idp=<?=$idp;?>" target="_blank" class="btn btn-primary">Print Nota</a>

                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Barang</th>
                                            <th>Tanggal</th>
                                            <th>QTY</th>
                                            <th>Item</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                            $ambilsemuadatastok = mysqli_query($conn, "select *, k.keterangan as mk from keluarstock k, stock s where idorder = $idp AND k.idbarang = s.idbarang");
                                            $i=1;
                                            $totalsemua2=0;
                                            while($data=mysqli_fetch_array($ambilsemuadatastok)){
                                                $idbarang = $data['idbarang'];
                                                $namabarang = $data['namabarang'];
                                                $tanggal = $data['tglks'];
                                                $qty = $data['qty'];
                                                $item = $data['item'];
                                                $harga = $data['harga'];
                                                $keterangan = $data['mk'];
                                                $idks = $data['idks'];
                                                $diskon = $data['diskon'];
                                                $total = $qty * $harga;
                                                $totaldiskon = $diskon;
                                                $totalsemua = $total - $totaldiskon;
                                                $totalsemua2=$totalsemua2+$totalsemua;
                                        ?>
                                        <tr>
                                            <td> <?=$i++.".";?> </td>
                                            <td> <?=$namabarang;?> </td>
                                            <td> <?=$tanggal;?> </td>
                                            <td> <?=$qty;?> </td>
                                            <td> <?=$item;?> </td>
                                            <td> <?="Rp.".number_format($harga, 0, ',', '.');?> </td>
                                            <td> <?="Rp.".number_format($diskon, 0, ',', '.');?> </td>
                                            <td> <?="Rp.".number_format($totalsemua, 0, ',', '.');?> </td>
                                            <td> <?=$keterangan;?> </td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idks;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idks;?>">
                                                    Delete
                                                </button>
                                            </td>
                                            
                                        </tr>
                                        

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$idks;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang <?=$namabarang;?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                    <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                    <br>
                                                    <input type="text" name="keterangan" value="<?=$keterangan;?>" class="form-control">
                                                    <br>
                                                    <input type="hidden" name="idbarang" value="<?=$idbarang;?>">
                                                    <input type="hidden" name="idorder" value="<?=$idp;?>">
                                                    <input type="hidden" name="idks" value="<?=$idks;?>">
                                                    <input type="hidden" name="totalsemua2" value="<?=$totalsemua2;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatebarang2">Submit</button>
                                                </div>
                                                </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?=$idks;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus <?=$namabarang;?>?
                                                    <input type="hidden" name="idbarang" value="<?=$idbarang;?>">
                                                    <input type="hidden" name="qty" value="<?=$qty;?>">
                                                    <input type="hidden" name="idks" value="<?=$idks;?>">
                                                    <input type="hidden" name="idorder" value="<?=$idp;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarang2">Hapus</button>
                                                </div>
                                                </form>

                                                </div>
                                            </div>
                                        </div>


                                        <?php
                                            };
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total Keseluruhan:</strong></td>
                                            <td><?="Rp.".number_format($totalsemua2, 0, ',', '.');?></td>
                                            <?php
                                                $conn = mysqli_connect("localhost", "root", "", "bintang_motor");
                                                $updatetotalbiaya = mysqli_query($conn, "update orderan set totalbiaya='$totalsemua2' where idorder='$idp'");
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form method="post">
                <div class="modal-body">
                    <select name="barangnya" class="form-control" id="barangSelect">
                        <?php
                            $ambilsemuadata = mysqli_query($conn, "select * from stock");
                            while($fetcharray = mysqli_fetch_array($ambilsemuadata)){
                                $namabarang = $fetcharray['namabarang'];
                                $idbarang = $fetcharray['idbarang'];
                                $harga = $fetcharray['harga'];
                        ?>
                        <option value="<?=$idbarang;?>" data-harga="<?=$harga;?>"> <?=$namabarang;?> </option>
                        <?php
                            }
                        ?>
                    </select>
                    <br>
                    <input type="number" class="form-control" id="harga" name="harga"  required>
                    <script>
                        const barangSelect = document.getElementById("barangSelect");
                        const hargaInput = document.getElementById("harga");

                        barangSelect.addEventListener("change", function() {
                            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
                            const selectedHarga = selectedOption.getAttribute("data-harga");
                            hargaInput.value = selectedHarga;
                        });
                        // Set initial harga based on the first option
                        const firstOption = barangSelect.options[0];
                        const initialHarga = firstOption.getAttribute("data-harga");
                        hargaInput.value = initialHarga;
                    </script>
                    <br>
                    <input type="number" name="qty" placeholder="Qty" class="form-control" required>
                    <br>
                    <input type="number" name="diskon" placeholder="Diskon" class="form-control">
                    <br>
                    <input type="text" name="keterangann" placeholder="Keterangan" class="form-control">
                    <input type="hidden" name="idorder" value="<?=$idp;?>">
                    <input type="hidden" name="totalsemua2" value="<?=$totalsemua2;?>">
                    <br>
                    <button type="submit" class="btn btn-primary" name="adddetail">Submit</button>
                </div>
                </form>

                </div>
            </div>
        </div>
    </body>
</html>
