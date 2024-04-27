<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>

<body>
    <div id="login-wrapper">
        <h1>Sign In</h1>
        <?php if (session()->getFlashdata('flash_msg')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif; ?>
        <form action="/loginProcess" method="post">
            <div class="mb-3">
                <label for="InputForEmail" class="form-label">Email
                    address</label>
                <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
            </div>
            <div class="mb-3">

                <label for="InputForPassword" class="form-label">Password</label>

                <input type="password" name="password" class="form-control" id="InputForPassword">

            </div>
            <button type="submit" class="btn btn-primary

Modul Praktikum Pemrograman Web 2

Agung Nugroho (agung@pelitabangsa.ac.id) 55
Universitas Pelita Bangsa, Bekasi
">Login</button>
        </form>
    </div>
</body>

</html>