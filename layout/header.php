
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parkir PT.Gajah Tunggal Predator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <?php
                



                
                
                // Button Masuk Kendaraan
                $button1Text = $page === 'index' ? 'Kendaraan Masuk' : ($page === 'add_form' ? 'Kembali' : '');
                $button1Link = $page === 'index' ? './form_add.php' : ($page === 'add_form' ? './index.php' : '');

                if ($button1Text) {
                    echo '<a class="btn btn-primary me-2" href="' . $button1Link . '">' . $button1Text . '</a>';
                }

                // Button  
                $button2Text = $page === 'index' ? 'kendaraan Keluar' : ($page === 'history' ? 'Kembali' : '');
                $button2Link = $page === 'index' ? './history.php' : ($page === 'history' ? './index.php' : '');

                if ($button2Text) {
                    echo '<a class="btn btn-success me-2" href="' . $button2Link . '">' . $button2Text . '</a>';
                }          

                $buttonUserText = $page === 'index' ? 'Data Karyawan' : ($page === 'data_karyawan' ? 'Kembali' : '');
                $buttonUserLink = $page === 'index' ? './karyawan_data.php' : ($page === 'data_karyawan' ? './index.php' : '');

                if (hasUserRole($userId, 'admin')) {
                    // Admin specific code
                    if ($buttonUserText) {
                        echo '<a class="btn btn-secondary me-2" href="' . $buttonUserLink . '">' . $buttonUserText . '</a>';
                    }
                } else {
                    // Handle non-admin case
                    echo " ";
                }
                // Button data karyawan
                
                   
                    
    
             
               

                 // Button back
                 $button3Text = $page === 'edit_form' ? 'Kembali' : '';
                 $button3Link = $page === 'edit_form' ? './index.php' : '';
 
                 if ($button3Text) {
                     echo '<a class="btn btn-danger me-2" href="' . $button3Link . '">' . $button3Text . '</a>';
                 }
                ?>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarburgermenu" aria-controls="navbarburgermenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end me-3" id="navbarburgermenu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php

                            // BUTTON ADMIN 
                            $buttonAdminText = $page === 'index' ? 'Tambah Karyawan' : ($page === 'add_karyawan' ? 'Kembali' : '');
                            $buttonAdminLink = $page === 'index' ? './karyawan_tambah.php' : ($page === 'add_karyawan' ? './index.php' : '');

                            if ($buttonAdminText) {

                                echo '<a class="btn btn-primary me-2" href="' . $buttonAdminLink . '">' . $buttonAdminText . '</a>';
                            }

                            ?>
                            <a class="btn btn-danger" aria-current="page" href="auth/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>