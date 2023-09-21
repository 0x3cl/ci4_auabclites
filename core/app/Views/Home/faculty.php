<div id="faculty" class="py-4">
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
                echo '
                    <div class="carousel-description" data-order="'.$key.'">
                    <h1>'.ucwords($value->first_name . ' ' . $value->last_name).'</h1>
                    <h5>'.strtoupper($value->position).'</h5>
                    <div class="content mt-5 px-3">
                        '.$value->description.'
                    </div>
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
</div>