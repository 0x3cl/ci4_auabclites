<div class="group-content">
    <div id="home">
        <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <div class="d-flex justify-content-center gap-5 align-items-center h-100">
                        <div class="text-banner exagg text-center">
                            <h1>Arellano University Andres Bonifacio Campus</h1>
                            <h2>School of Information Technology Education</h2>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <div class="d-flex justify-content-center gap-5 align-items-center h-100">
                        <div class="image-banner d-none d-lg-flex">
                            <div class="image-box">
                                <img src="<?= base_url('/assets/home/images/defaults/enrollment.jpg') ?>" alt="" srcset="">
                            </div>
                        </div>
                        <div class="text-banner">
                            <h1>Online & Walk In Enrollment</h1>
                            <hr>
                            <ul>
                                <li>Bachelor of Science in Information Technology: Comprehensive IT program.</li>
                                <li>Bachelor of Science in Computer Science: In-depth computer science curriculum.</li>
                                <li>No Entrance Examination: Open admission policy.</li>
                                <li>Quality Education: Experienced faculty and modern teaching methods.</li>
                                <li>15% Tuition Fee Discount for AU SHS Alumni: Alumni discount available.</li>
                            </ul>
                            <div class="d-flex justify-content-center">
                                <a href="<?= base_url('/form/enroll'); ?>" class="btn-custom btn-custom-outline-light text-link mt-3">Reserve</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <div class="d-flex justify-content-center gap-5 align-items-center h-100">
                        <div class="image-banner d-none d-lg-flex">
                            <div class="image-box">
                                <img src="<?= base_url('/assets/home/images/defaults/online.jpg') ?>" alt="" srcset="">
                            </div>
                        </div>
                        <div class="text-banner">
                            <h1>Online Learning</h1>
                            <hr>
                            <ul>
                                <li>Arellano's LMS: Interactive learning with course access, assignments, and collaboration.</li>
                                <li>Virtual Classes: Real-time online classes via Google Meet, MS Teams, or Zoom.</li>
                                <li>Programming Webinars: Stay updated with local and foreign webinars.</li>
                                <li>Career Talk Sessions: Gain insights from industry professionals.</li>
                                <li>Cybersecurity Workshops: Enhance cybersecurity skills with expert-led workshops.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="10000">
                    <div class="d-flex justify-content-center gap-5 align-items-center h-100">
                        <div class="image-banner d-none d-lg-flex">
                            <div class="image-box">
                                <img src="<?= base_url('/assets/home/images/defaults/traditional.jpg') ?>" alt="" srcset="">
                            </div>
                        </div>
                        <div class="text-banner">
                            <h1>Traditional Learning</h1>
                            <hr>
                            <ul>
                                <li>Hands-on Learning: Engage in practical activities, experiments, and group projects for a deeper understanding of the subject.</li>
                                <li>Structured Schedule: Follow a fixed class schedule for a disciplined learning routine.</li>
                                <li>Access to Resources: Utilize on-campus libraries, laboratories, and other facilities for comprehensive learning.</li>
                                <li>Extracurricular Activities: Participate in clubs, sports, and events to enhance your overall college experience.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div id="news">
        <div class="container py-5">
            <div class="row my-4">
                <?php 
                    if(!empty($data['site_bulletin'])) {
                        echo '
                        <div class="section-title-left" data-aos="fade-up">
                            <div class="section-main">
                                <h1>Bulletin</h1>
                                <p>Read about the latest news and announcements.</p>
                            </div>
                        </div>
                        <hr>
                        ';
                        foreach ($data['site_bulletin'] as $key => $value) {
                            $title = strtolower(preg_replace("/[\s]+/", '-', preg_replace("/[^A-Za-z0-9\s-]+/", '', $value->title)));
                            $path = format_bulletin_category($value->category);
                            $link_path = '';
                            if($path == 'announcements') {
                                $link_path = 'announcement';
                            } else {
                                $link_path = $path;
                            }
                            echo '
                           <div class="col-12 col-md-6 mb-3">
                                <a href="'.base_url('/bulletin/'.$link_path.'/'.$value->id.'/'.$title.'').'" class="text-link">
                                    <div class="d-flex align-items-start gap-3 mb-2 news-content" data-aos="fade-up">
                                        <div class="news-image">
                                            <img src="'.base_url('/assets/home/images/bulletin/'.$path.'/'.$value->image.'').'" alt="news">
                                        </div>
                                        <div class="news-title">
                                            <h5 class="text-clamp clamp-1 m-0">'.$value->title.'</h5>
                                            <p class="tiny-date">'.format_timestamp_to_date($value->date_updated).'</p>
                                            <small class="text-clamp clamp-3">'.$value->content.'</small>
                                        </div>
                                    </div>
                                </a>
                           </div>
                            ';
                        }
                        echo '
                        <div class="d-flex justify-content-center mt-5">
                            <a href="'.base_url('/bulletin').'" class="btn-custom btn-custom-outline text-link">See More</a>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="col-12 mb-3" data-aos="fade-up">
                            <div class="bulletin-info">
                                <div class="bulletin-title">
                                    No Bulletin Found
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
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
        <div class="news-letter" data-aos="fade-up">
            <div class="inner-wrapper">
                <h5>Receive Latest Updates</h5>
                <div class="d-sm-flex justify-content-center align-items-center gap-3 my-3">
                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class='bx bx-envelope-open'></i></span>
                        <input type="text" name="newsletter-email" id="newsletter-email" class="form-control" placeholder="Your Email Address">
                    </div>
                    <button class="btn-custom btn-custom-light mb-2" id="btn-subscribe">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
    <div id="courses">
        <div class="container py-5">
            <div class="row">
                <div class="col-12 col-md-6 mb-5" data-aos="fade-up">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="course-logo">
                                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][5]->image .'') ?>" alt="logo">
                            </div>
                            <div class="course-title">
                                <h3>Bachelor of Science in Information Technology</h3>
                            </div>
                            <div class="course-description">
                                <p>
                                    Focuses on using technology in real-world applications, like building websites, managing computer networks, and ensuring data security. It prepares you for jobs in IT support, software development, and more.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6" data-aos="fade-up">
                    <div class="card">
                        <div class="card-body">
                            <div class="course-logo">
                                <img src="<?= base_url('/assets/home/images/logo/' . $data['site_images'][6]->image .'') ?>" alt="logo">
                            </div>
                            <div class="course-title">
                                <h3>Bachelor of Science in Computer Science</h3>
                            </div>
                            <div class="course-description">
                                <p>Understanding the core concepts of computer science, like algorithms and software design. It's for those who want to become programmers, software developers, or work on advanced computing projects.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="enrol-action">
                <a href="<?= base_url('/form/enroll') ?>" class="btn-custom btn-custom-outline-light text-link">Enroll Now</a>
            </div>
        </div>
    </div>
    <div id="alumni">
        <div class="container">
            <?php 
                if(!empty($data['site_testimonials'])) {
                    echo '
                    <div class="d-lg-flex justify-content-between gap-5 mt-5">
                        <div class="d-lg-flex align-items-center gap-3 left-content mb-5" data-aos="fade-up">
                            <div class="section-title-left">
                                <div class="section-main mb-4">
                                    <h1>Alumni</h1>
                                    <p>Read testimonials of our alumni and their journey.</p>
                                </div>
                                <hr>
                                <div class="section-sub text-justify mt-3">
                                    <p>This serves as a vibrant showcase of our educational journey. Here, we celebrate the remarkable achievements and contributions of our esteemed alumni, providing insights into their career successes, personal milestones, and community involvement. Additionally, this page offers authentic testimonials from current and alumni students who generously share their positive experiences and valuable feedback about our school.</p>
                                </div>
                            </div>
                            <div class="divider ms-4"></div>
                        </div>
                        <div class="right-content">
                            <div class="row">
                    ';
                    foreach($data['site_testimonials'] as $key => $value) {
                        echo '
                        <div class="col-12 col-md-6 mb-3" data-aos="fade-up">
                            <a href="'.base_url('/testimonial').'" class="text-link">
                                <div class="card card-design">
                                    <img src="'.base_url('/assets/home/images/testimonials/'.$value->image.'').'" alt="alumni">
                                    <div class="card-body">
                                        <div class="alumni-date">
                                            <small>'.format_timestamp_to_date($value->date_updated).'</small>
                                        </div>
                                        <div class="alumni-name">
                                            <h4>'.ucwords($value->first_name . ' ' . $value->last_name).'</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <a href="'.base_url('/testimonial').'" class="btn-custom btn-custom-outline text-link">See More</a>
                        </div>
                        ';
                    }
                    echo '
                            </div>
                        </div>
                    </div>
                    ';
                } else {
                    echo '
                        <div class="col-12 mb-3" data-aos="fade-up">
                            <div class="bulletin-info">
                                <div class="bulletin-title">
                                    No Alumni Found
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
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
