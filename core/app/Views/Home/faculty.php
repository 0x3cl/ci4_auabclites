<div id="faculty">
    <div class="container py-4">
        <?php 
            if(!empty($data['site_faculty'])) {
                echo '
                <div class="container pb-5">
                    <div class="section-title-center" data-aos="fade-up">
                        <div class="section-main">
                            <h1>MEET OUR FACULTY</h1>
                            <h5>SITE DEPARTMENT</h5>
                        </div>
                    </div>
                </div>
            ';
        ?>
        <div class="carousel-content m-auto">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center" id="carousel-container" data-aos="fade-up">
                    <?php 
                        foreach ($data['site_faculty'] as $key => $value) {
                            echo '
                            <div class="carousel-image" data-order="'.$key.'">
                                <img src="'.base_url('/assets/home/images/faculty/'.$value->image.'').'" alt="faculty member">
                            </div>
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="controls" data-aos="fade-up">
                <div class="control-prev">
                    <i class="bx bxs-chevrons-left" ></i>
                    <span>Prev</span>
                </div>
                <div class="control-next"   >
                    <span>Next</span>
                    <i class="bx bxs-chevrons-right"></i>
                </div>
            </div>
            <div class="d-sm-flex justify-content-center mt-4" data-aos="fade-up">
                <?php
                foreach ($data['site_faculty'] as $key => $value) {
                    $description = explode("\n", $value->description);
                    echo '
                    <div class="carousel-description" data-order="'.$key.'">
                        <h1>'.ucwords($value->first_name . ' ' . $value->last_name).'</h1>
                        <h5>'.strtoupper($value->position).'</h5>
                        <ul class="list-unstyled mt-3">
                    ';
                    
                    foreach($description as $value) {
                        echo '<li>
                                <div class="d-flex align-items-start">
                                    <span class="faculty-check"><i class="bx bx-check"></i></span>
                                    <p class="m-0">'.$value.'</p>
                                </div>
                            </li>
                            ';
                    }

                    echo'
                        </ul>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
        <?php
            } else {
                echo '
                <div class="bulletin-info">
                    <div class="bulletin-title">
                        No Faculty Members Found
                    </div>
                    <div class="bulletin-date">
                        As of Now  • '.date('F d, Y').'
                    </div>
                    <hr>
                    <div class="bulletin-content">
                        Why Am I seeing this?
                        <ul class="mt-3">
                            <li>The page you&apos;re trying to access is not yet updated.</li>
                            <li>The page you&apos;re trying to access is invalid</li>
                            <li>The page you&apos;re trying to access doesn&apos;t exist</li>
                            <li>The page you&apos;re trying to access is temporarily unavailable</li>
                        </ul>
                    </div>
                </div>
                ';
            }
        ?>
        <div id="other-orgs" class="my-5">
            <hr>
            <div class="organization mt-5 pb-5">
                <div class="d-lg-flex justify-content-center gap-4 text-center" data-aos="fade-up">
                    <a href="https://www.arellanolaw.edu/news/latest.html" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/ausl_logo.png') ?>" alt="" srcset="">
                    </a>
                    <a hreg="https://arellanoinp.com/">
                        <img src="<?= base_url('/assets/home/images/organizations/cbe_logo.png') ?>" alt="" srcset="">
                    </a>    
                    <a href="https://www.arellano.edu.ph/international-programs/" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/ipd_logo.png') ?>" alt="" srcset="">
                    </a>
                    <a href="https://www.arellanolaw.edu/news/latest.html" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/new_phil_logo.png') ?>" alt="" srcset="">
                    </a>
                    <a href="https://dev.arellano.edu.ph/sites/default/files/2022-09/the_standard_one.png" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/standard.png') ?>" alt="" srcset="">
                    </a>
                    <a href="https://dev.arellano.edu.ph/sites/default/files/2023-06/chiefs-logo-low-res.png" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/chiefs.png') ?>" alt="" srcset="">
                    </a>
                    <a href="https://www.arellano.edu.ph/student-council/arellano-university-student-council/" target="_blank" class="text-link">
                        <img src="<?= base_url('/assets/home/images/organizations/ssc.png') ?>" alt="" srcset="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>