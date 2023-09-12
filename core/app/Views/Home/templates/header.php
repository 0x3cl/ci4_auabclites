<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Kimuel Mariano, Carl Llemos, John Paul Asis, Jehmielle Lacdao">
    <meta name="description" content="">
    <meta name="keywords" content="SITES, School of Information Technology Education, AULITES, AUABCLITES AUABCSITES">
    <meta name="theme-color" content="#801313">
    <meta property="og:image" content="/">
    <meta property="og:title" content="SITES | ARELLANO UNIVERSITY ANDRES BONIFACIO CAMPUS">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/assets/home/images/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/assets/home/images/favicon/favicon-32x32.png') ?> ">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/assets/home/images/favicon/favicon-16x16.png') ?> ">
    <link rel="manifest" href="<?= base_url('/assets/home/images/favicon/site.webmanifest') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery-bundle.min.css" integrity="sha512-nUqPe0+ak577sKSMThGcKJauRI7ENhKC2FQAOOmdyCYSrUh0GnwLsZNYqwilpMmplN+3nO3zso8CWUgu33BDag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lightgallery.min.css" integrity="sha512-F2E+YYE1gkt0T5TVajAslgDfTEUQKtlu4ralVq78ViNxhKXQLrgQLLie8u1tVdG2vWnB3ute4hcdbiBtvJQh0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?= $title;?></title>
    <!-- BS5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- BOXICONS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/home/libraries/css/app.css') ?>">
    <?php echo (request()->uri->getPath() === '/auabclites/form/enroll') ? '<link rel="stylesheet" href="' . base_url('/assets/home/libraries/css/form.css') . '"' : '' ?>
</head>
<body>
<div class="cookie-policy">
    <div class="container p-4">
        <div class="d-md-flex justify-content-between">
            <div class="cookie-description">
                <small>
                    This website uses cookies to ensure you get the best experience on our website.
                    By using our website you agree on the following <a href="#">Cookie Policy</a>,
                    <a href="#" class="privacy-link">Privacy Policy</a> and <a href="#">Term Of Use</a>
                </small>
            </div>
            <div class="d-flex d-md-block mt-4 m-md-0">
                <button class="btn-custom btn-custom-light" id="cookie-accept">Accept</button>
                <button class="btn-custom btn-custom-outline-light" id="cookie-decline">Decline</button>
            </div>
        </div>
    </div>
</div>
<!-- <div class="loader">
    <div class="loader-primary"></div>
    <div class="loader-secondary"></div>
    <div class="loader-tertiary"></div>
    <div class="loader-content">
        <div>
            <div class="logo-content">
                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][5]->image . '') ?>" alt="" srcset="">
                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][6]->image . '') ?>" alt="" srcset="">
                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][2]->image . '') ?>" alt="" srcset="">
                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][3]->image . '') ?>" alt="" srcset="">
                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][4]->image . '') ?>" alt="" srcset="">
            </div>
        </div>
    </div>
</div> -->
<div class="scroll-top">
    <i class='bx bxs-up-arrow' ></i>
</div>
<?= $this->include('home/templates/navigation') ?>
