<?php
require 'function.php';

if (!isset($_SESSION["log"])) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit();
}

$laporan = [];
// Proses form jika ada input tanggal
if (isset($_POST['submit'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    
    // Validasi tanggal
    if ($startDate != '' && $endDate != '') {
        // Ambil data transaksi
        $laporan = getLaporanKeuangan($conn, $startDate, $endDate);
    } else {
        $error = "Mohon masukkan range tanggal dengan benar.";
    }
}

function getLaporanKeuangan($conn, $startDate, $endDate)
{
    $dataStok = array();

    $query = "SELECT * FROM (SELECT idbeli AS id, DATE(tanggal) AS tanggal, totalbiaya, 'Kredit' AS type FROM belian
          UNION
          SELECT idorder AS id, DATE(tanggal) AS tanggal, totalbiaya, 'Debit' AS type FROM orderan) AS combined
          WHERE tanggal BETWEEN '$startDate' AND '$endDate'";

    $result = mysqli_query($conn, $query);

    while ($data = mysqli_fetch_array($result)) {
        $dataStok[] = array(
            'id' => $data['id'],
            'tanggal' => $data['tanggal'],
            'totalbiaya' => $data['totalbiaya'],
            'type' => $data['type'],
        );
    }

    // Sort the array based on the 'tanggal' field
    usort($dataStok, function ($a, $b) {
        return strtotime($a['tanggal']) - strtotime($b['tanggal']);
    });

    return $dataStok;
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
        <title>Laporan Keuangan</title>
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
                        <h1 class="mt-4">Laporan Keuangan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Laporan Keuangan</li>
                        </ol>

                        <form method="post" action="">
                            <div class="form-row" style="display: flex; gap: 10px;">
                                <div class="form-group col-md-3">
                                    <label for="start_date">Mulai Tanggal</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="end_date">Sampai Tanggal</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" name="submit">Tampilkan Laporan</button>
                        </form>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <br>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        $saldo = 0;
                                        foreach ($laporan as $data) {
                                            $tanggal = $data['tanggal'];
                                            $totalbiaya = $data['totalbiaya'];

                                            // Update saldo based on the transaction type
                                            if ($data['type'] === 'Debit') {
                                                $saldo += $totalbiaya;
                                            } else {
                                                $saldo -= $totalbiaya;
                                            }
                                        ?>

                                        <tr>
                                            <td> <?= $i++; ?> </td>
                                            <td> <?= $tanggal; ?> </td>
                                            <td> <?= ($data['type'] === 'Debit') ? 'Rp ' . number_format($totalbiaya, 0, ',', '.') : ''; ?> </td>
                                            <td> <?= ($data['type'] === 'Kredit') ? 'Rp ' . number_format($totalbiaya, 0, ',', '.') : ''; ?> </td>
                                            <td> <?= 'Rp ' . number_format($saldo, 0, ',', '.'); ?> </td>
                                        </tr>

                                        <?php
                                        }
                                        ?>
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
    </body>
</html>
