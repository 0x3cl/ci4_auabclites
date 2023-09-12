<div id="testimonial">
        <div class="container py-4">
                <?php 
                    if(!empty($data['site_testimonials'])) {
                        
                        echo '
                        <div class="section-title-left" data-aos="fade-up">
                            <div class="section-main">
                                <h1>TESTIMONIALS</h1>
                                <p>Discover our alumni insights and experiences.</p>
                            </div>
                        </div>
                        <hr>
                        ';
                        $testimonials = $data['site_testimonials'];
                        echo '
                        <div class="testimonial-content">
                            <div class="items-control">
                                    <div class="control-prev">
                                        <i class="bx bxs-chevrons-left"></i>
                                    </div>
                                    <div class="control-next">
                                        <i class="bx bxs-chevrons-right"></i>
                                    </div>
                                </div>
                        ';
                        echo '
                        <div class="item-content active" data-id="1">
                            <div class="items">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-5 d-sm-flex justify-content-center align-items-center">
                                        <div class="testimonial-image d-none d-md-flex">
                                            <img src="'.base_url('/assets/home/images/testimonials/'.$testimonials[0]->image.'').'" alt="" srcset="">
                                            <div class="overlay-bg">
                                                <div class="inner-overlay-bg"></div>
                                            </div>
                                            <div class="overlay-circles-1"></div>
                                            <div class="overlay-circles-2"></div>
                                            <div class="overlay-circles-3"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <div class="testimonial-details">
                                            <div class="testimonial-description">
                                                <p>'.$testimonials[0]->testimonial.'</p>
                                            </div>
                                            <div class="testimonial-author mt-4">
                                                <h1>'.ucwords($testimonials[0]->first_name . ' ' . $testimonials[0]->last_name).'</h1>
                                            </div>
                                            <div class="testimonial-pos mt-1">
                                                <p>Batch 2023 Graduate</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';

                        array_shift($testimonials);

                        foreach($testimonials as $key => $value) { 
                            $key = $key + 2;

                            echo '
                                <div class="item-content" data-id="'.$key.'">
                                    <div class="items">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-5 d-sm-flex justify-content-center align-items-center">
                                                <div class="testimonial-image d-none d-md-flex">
                                                    <img src="'.base_url('/assets/home/images/testimonials/'.$value->image.'').'" alt="" srcset="">
                                                    <div class="overlay-bg">
                                                        <div class="inner-overlay-bg"></div>
                                                    </div>
                                                    <div class="overlay-circles-1"></div>
                                                    <div class="overlay-circles-2"></div>
                                                    <div class="overlay-circles-3"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="testimonial-details">
                                                    <div class="testimonial-description">
                                                        <p class="text-clamp clamp-3">'.$value->testimonial.'</p>
                                                    </div>
                                                    <div class="testimonial-author mt-4">
                                                        <h1>'.ucwords($value->first_name . ' ' . $value->last_name).'</h1>
                                                    </div>
                                                    <div class="testimonial-pos mt-1">
                                                        <p>Batch 2023 Graduate</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            ';
                          
                        }

                    } else {
                        echo '
                        <div class="bulletin-info">
                            <div class="bulletin-title">
                                No Testimonials Found
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
        </div>
    </div>