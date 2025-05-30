<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'koneksi.php';

// Proses upload atau edit foto portfolio
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, "img/" . $img);
    mysqli_query($conn, "INSERT INTO portfolio (title, description, image_url) VALUES ('$title', '$desc', '$img')");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if ($img !== '') {
        move_uploaded_file($tmp, "img/" . $img);
        mysqli_query($conn, "UPDATE portfolio SET title='$title', description='$desc', image_url='$img' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE portfolio SET title='$title', description='$desc' WHERE id=$id");
    }
}

// Hitung jumlah data untuk ditampilkan di dashboard
$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$total_messages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM messages"));
$total_portfolio = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM portfolio"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Harmoni Living</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-house"></i>
                </div>
                <div class="sidebar-brand-text mx-2">Harmoni Living</div>
            </a>
            
            <hr class="sidebar-divider">
            
            <ul class="nav flex-column">
                <li class="nav-item active">
                    <a class="nav-link" href="#dashboard" data-section="dashboard">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#users" data-section="users">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#messages" data-section="messages">
                        <i class="bi bi-envelope"></i>
                        <span>Pesan Masuk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#portfolio" data-section="portfolio">
                        <i class="bi bi-images"></i>
                        <span>Portfolio</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer text-center p-3">
                <a href="index2.html" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="bg-light">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="mb-0 text-gray-800">Admin Dashboard</h4>
                </div>
            </nav>
            
            <!-- Dashboard Content -->
            <div class="container-fluid section-content" id="dashboard-section">
                <div class="content-header">
                    <h1 class="h3 mb-0 text-gray-800">Selamat datang, Admin!</h1>
                </div>
                
                <div class="row">
                    <!-- Total Pengguna Card -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2 stat-card stat-card-primary">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pengguna</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people fa-2x text-gray-300 stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pesan Masuk Card -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2 stat-card stat-card-success">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pesan Masuk</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_messages ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-envelope fa-2x text-gray-300 stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Portfolio Card -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2 stat-card stat-card-info">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Item Portfolio</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_portfolio ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-images fa-2x text-gray-300 stat-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        


            <!-- Users Content -->
            <div class="container-fluid section-content" id="users-section" style="display: none;">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = mysqli_query($conn, "SELECT username, email FROM users");
                                    while ($user = mysqli_fetch_assoc($users)) {
                                        echo "<tr><td>{$user['username']}</td><td>{$user['email']}</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Content -->
            <div class="container-fluid section-content" id="messages-section" style="display: none;">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pesan Masuk</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Pesan</th>
                                        <th>Dikirim Pada</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pesan = mysqli_query($conn, "SELECT id, username, email, message, created_at FROM messages ORDER BY created_at DESC");
                                    while ($row = mysqli_fetch_assoc($pesan)) {
                                        $id = $row['id'];
                                        $username = htmlspecialchars($row['username']);
                                        $email = htmlspecialchars($row['email']);
                                        $message = nl2br(htmlspecialchars($row['message']));
                                        $created_at = date('d M Y H:i', strtotime($row['created_at']));
                                        echo "
                                        <tr>
                                            <td>$username</td>
                                            <td>$email</td>
                                            <td>$message</td>
                                            <td>$created_at</td>
                                            <td>
                                                <form method='POST' action='hapus_pesan.php' onsubmit=\"return confirm('Yakin ingin menghapus pesan ini?');\">
                                                    <input type='hidden' name='id' value='$id'>
                                                    <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                                                </form>
                                                <a href='mailto:$email' class='btn btn-primary btn-sm'>Balas</a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Portfolio Content -->
            <div class="container-fluid section-content" id="portfolio-section" style="display: none;">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kelola Portfolio</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="image" class="form-control-file">
                            </div>
                            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                        </form>

                        <div class="row">
                            <?php
                            $portfolio = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY created_at DESC");
                            while ($item = mysqli_fetch_assoc($portfolio)) {
                                echo "
                                <div class='col-lg-4 mb-4'>
                                    <div class='card'>
                                        <img src='img/{$item['image_url']}' class='card-img-top'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>{$item['title']}</h5>
                                            <p class='card-text'>{$item['description']}</p>
                                            <form method='POST' action='' enctype='multipart/form-data'>
                                                <input type='hidden' name='id' value='{$item['id']}'>
                                                <div class='form-group'>
                                                    <input type='text' name='title' value='{$item['title']}' class='form-control mb-2' required>
                                                </div>
                                                <div class='form-group'>
                                                    <textarea name='description' class='form-control mb-2' required>{$item['description']}</textarea>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='file' name='image' class='form-control-file mb-2'>
                                                </div>
                                                <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.nav-link[data-section]');
            const sections = document.querySelectorAll('.section-content');

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-section');

                    // Sembunyikan semua section
                    sections.forEach(section => {
                        section.style.display = 'none';
                    });

                    // Hapus class active dari semua nav item
                    document.querySelectorAll('.nav-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Tampilkan section yang dipilih
                    const targetSection = document.getElementById(`${target}-section`);
                    if (targetSection) {
                        targetSection.style.display = 'block';
                    }

                    // Tandai nav item sebagai aktif
                    this.parentElement.classList.add('active');
                });
            });

            // Tampilkan section pertama (dashboard) saat halaman pertama kali dimuat
            const defaultSection = document.getElementById('dashboard-section');
            if (defaultSection) {
                defaultSection.style.display = 'block';
            }
        });
    </script>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Navigation between sections
        document.querySelectorAll('[data-section]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Hide all sections
                document.querySelectorAll('.section-content').forEach(section => {
                    section.style.display = 'none';
                });
                
                // Show selected section
                const sectionId = this.getAttribute('data-section');
                document.getElementById(`${sectionId}-section`).style.display = 'block';
                
                // Update active link
                document.querySelectorAll('[data-section]').forEach(item => {
                    item.parentElement.classList.remove('active');
                });
                this.parentElement.classList.add('active');
            });
        });
    </script>

    

    
</body>
</html>