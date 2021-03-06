<?php
    include '../connection.php';
    session_start();

    // Cek jika sudah login dan memiliki otorisasi
    if (empty($_SESSION['email']) && empty($_SESSION['role'])) {
        echo "<script type='text/javascript'> alert('Anda belum login! Harap login terlebih dahulu!'); document.location.href = '../index.php'; </script>";
    } else if ($_SESSION['role'] != 1) {
        echo "<script type='text/javascript'> alert('Anda tidak memiliki otorisasi!'); document.location.href = '../logout.php'; </script>";
    }

    // Array status pendaftaran
    $pendaftaran = [
        'Menunggu', 'Tidak Diterima', 'Cadangan', 'Diterima'
    ];

    // Query
    $query = mysqli_query($conn, "SELECT * FROM data_pendaftaran INNER JOIN users_tb ON data_pendaftaran.user_id = users_tb.user_id WHERE data_pendaftaran.user_id = '$_GET[user_id]'");
    $data = mysqli_fetch_array($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />

    <title>Detail Pendaftaran PSB Admin</title>

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css"/>

    <script src="https://kit.fontawesome.com/a3764fe608.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-success flex-md-nowrap p-0 shadow">
       <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">BNSP 2021</a>
        <ul class="navbar-nav w-100">
            <li class="nav-item">
                <h4 style="color:white" class="text-center mb-2">PSB Pendaftaran Siswa Baru - SMKN 35</h4>
            </li>
        </ul>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="../logout.php" onclick="return confirm('Apakah anda yakin ingin melakukan logout?');">Sign out</a>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">
                            <span><i class="fas fa-home"></i></span>
                            Beranda
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                        <span>Admin</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="informasi_user.php">
                            <span><i class="fas fa-users"></i></span>
                            Informasi User
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3>Detail Pendaftaran <?= $data['no_pendaftaran'] ?></h3>
                </div>
                <div id="content">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th>No. Pendaftaran</th>
                                <td>:</th>
                                <td><?= $data['no_pendaftaran'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td><?= $data['nama'] ?></td>
                            </tr>
                            <tr>
                                <th>No. Identitas (NIK)</th>
                                <td>:</td>
                                <td><?= $data['nik'] ?></td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>:</td>
                                <td><?= $data['agama'] ?></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>:</td>
                                <td><?= $data['jenis_kelamin'] == 'L' ? 'Laki - laki' : 'Perempuan' ?></td>
                            </tr>
                            <tr>
                                <th>No. Handphone</th>
                                <td>:</td>
                                <td><?= $data['no_telepon'] ?></td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>:</td>
                                <td><?= !empty($data['tempat_lahir']) && !empty($data['tgl_lahir']) ? $data['tempat_lahir'] . ', ' . date('d M Y', strtotime($data['tgl_lahir'])) : '-'?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td><?= !empty($data['alamat']) ? $data['alamat'] : '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Orang Tua/Wali</th>
                                <td>:</td>
                                <td><?= !empty($data['nama_ortu']) ? $data['nama_ortu'] : '-'?></td>
                            </tr>
                            <tr>
                                <th>No. Handphone Orang Tua/Wali</th>
                                <td>:</td>
                                <td><?= !empty($data['no_telepon_ortu']) ? $data['no_telepon_ortu'] : '-'?></td>
                            </tr>
                            <tr>
                                <th>Berkas</th>
                                <td>:</td>
                                <td><?= $data['pas_foto'] && $data['ijazah'] && $data['surat_pernyataan'] ? 'LENGKAP' : 'BELUM LENGKAP' ?></td>
                            </tr>
                            <tr>
                                <th>Status Pendaftaran</th>
                                <td>:</td>
                                <td>
                                    <form action="../functions.php" method="post">
                                        <input type="hidden" name="type" value="updateStatusPendaftaran">
                                        <input type="hidden" name="pendaftaran_id" value="<?= $data['pendaftaran_id'] ?>">
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <select class="form-select form-select-sm" name="status_pendaftaran" id="status_pendaftaran">
                                                    <?php foreach($pendaftaran as $pend) : ?>
                                                        <option value="<?= $pend ?>" <?= !empty($data['status_pendaftaran']) && $data['status_pendaftaran'] == $pend ? ' selected="selected"' : ''?>><?= $pend ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <input type="submit" value="Ubah" class="btn btn-success btn-sm">
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <a href="index.php" class="btn btn-primary">Kembali</a>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
