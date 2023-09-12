<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Carl Llemos' Web Portfolio">
    <meta name="keywords" content="WebDeveloper, Web Developer, Web Dev, Front End, Back End, Full Stack Developer, Full Stack">
    <meta name="author" content="Carl Llemos">
    <meta name="theme-color" content="#191923">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/assets/home/images/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/assets/home/images/favicon/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/assets/home/images/favicon/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= base_url('/assets/home/images/favicon/site.webmanifest') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url('/assets/home/images/favicon/ms-icon-144x144.png') ?>">
    <meta name="theme-color" content="#ffffff">
    <!-- BOXICONS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/admin/css/default.css') ?>">
    <!-- JAVASCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?= (request()->uri->getPath() == '/auabclites/admin/login') ? '<link rel="stylesheet" href="'.base_url('/assets/admin/css/login.css').'">' : '<link rel="stylesheet" href="'.base_url('/assets/admin/css/app.css').'">'?>
    <title><?= $title ?></title>
</head>
<body>
