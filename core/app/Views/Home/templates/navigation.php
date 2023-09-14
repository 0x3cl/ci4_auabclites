<div class="navigation">
    <div class="header-top">
        <div class="container d-sm-flex align-items-center">
            <ul class="list-inline mb-0 d-flex justify-content-center">
                <li class="list-inline-item">
                    <a href="<?= $data['site_contacts'][0]->value ?>" target="_blank" class="nav-link">
                        <i class='bx bxl-facebook'></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="<?= $data['site_contacts'][1]->value ?>" target="_blank" class="nav-link">
                        <i class='bx bxl-instagram'></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="<?= $data['site_contacts'][2]->value ?>" target="_blank" class="nav-link">
                        <i class='bx bxl-twitter'></i>
                    </a>
                </li>
                <li class="list-inline-item d-none d-md-inline-block">
                    <a href="mailto:contact@auabclites.com" target="_blank" class="nav-link">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <i class='bx bxs-envelope'></i>
                            <span><?= $data['site_contacts'][3]->value ?></span>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="list-inline mb-0 d-flex justify-content-center d-md-inline-block ms-auto mt-2 mt-md-0">
                <li class="list-inline-item">   
                    <a href="https://www.topservelms.com/" target="_blank" class="text-link">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <i class='bx bxs-left-arrow-square bx-rotate-180' ></i>
                            <span>Learning Management System</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <nav class="navbar header navbar-expand-lg">
        <div class="container">
            <div class="logo solo">
                <a href="https://www.facebook.com/AU.SITePasig" target="_blank" rel="noopener noreferrer"><img src="<?= base_url('/assets/home/images/logo/' .$data['site_images'][3]->image .'') ?>" alt="" srcset=""></a>
            </div>
            <a href="<?= base_url('/home') ?>" class="navbar-brand d-none d-lg-block">
                <div>School of Information</div> 
                <div>Technology Education</div>
            </a>
            <div class="hamburger-wrapper">
                <div class="hamburger"></div>
            </div>
            <div class="logo group">
                <img src="<?= base_url('/assets/home/images/logo/' .$data['site_images'][5]->image .'') ?>" alt="" srcset="">
                <img src="<?= base_url('/assets/home/images/logo/' .$data['site_images'][6]->image .'') ?>" alt="" srcset="">
                <a href="https://www.facebook.com/LITESofficial" target="_blank" rel="noopener noreferrer"><img src="<?= base_url('/assets/home/images/logo/' .$data['site_images'][4]->image .'') ?>" alt="" srcset=""></a>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <ul class="navbar-nav d-flex justify-content-center gap-3 w-100 my-3 d-none d-md-flex sidebar">
                <li class="nav-item">
                    <a href="<?= base_url('/home') ?>" class="nav-link <?= $active === 'home' ? 'active' : ''?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/admission') ?>" class="nav-link <?= $active === 'admission' ? 'active' : ''?>">Admission</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/bulletin') ?>" class="nav-link <?= $active === 'bulletin' ? 'active' : ''?>">Bulletin</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/faculty') ?>" class="nav-link <?= $active === 'faculty' ? 'active' : ''?>">Faculty</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/officers') ?>" class="nav-link <?= $active === 'officers' ? 'active' : ''?>">Officers</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/research') ?>" class="nav-link <?= $active === 'research' ? 'active' : ''?>">Research</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/testimonial') ?>" class="nav-link <?= $active === 'testimonial' ? 'active' : ''?>">Testimonial</a>
                </li>
            </ul>
        </div>
    </nav>
</div>