<div id="research">
    <div class="container py-4">
        <?php
            if(!empty($data['site_research'])) {
                echo '
                <div class="section-title-left" data-aos="fade-up">
                    <div class="section-main">
                        <h1>Capstone Research</h1>
                        <p>The culmination of a student&apos;s academic journey and showcasing their expertise and innovative solutions in a comprehensive project.</p>
                    </div>
                </div>
                ';
            }
        ?>
        <div class="row">
            <?php
                if(!empty($data['site_research'])) {
                    foreach ($data['site_research'] as $key => $value) {
                        $title = strtolower(preg_replace("/[^A-Za-z0-9-]+/", '-', str_replace("'", '', $value->title)));
                        echo '
                        <div class="col-12 col-md-4 col-xl-3" data-aos="fade-up">
                            <a href="'.base_url('/research/view/'.$value->id.'/'.$title.'').'" class="text-link">
                                <div class="card card-design-2">
                                    <div class="card-image">
                                        <img src="'.base_url('/assets/home/images/research/'.$value->image.'').'" alt="research">
                                    </div>
                                    <div class="card-body">
                                        <div class="card-date">
                                            <small>'.format_timestamp_to_date($value->date_updated).'</small>
                                        </div>
                                        <div class="card-title text-clamp clamp-1">
                                            <h5>'.ucwords($value->title).'</h5>
                                        </div>
                                        <div class="ins">
                                            <small>(Click to view)</small>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <a href="'.base_url('/research/page/1') .'" class="btn-custom btn-custom-outline text-link">See More</a>
                        </div>
                        ';   
                    }
                    
                } else {
                    echo '
                    <div class="col-12">
                        <div class="bulletin-info">
                            <div class="bulletin-title">
                                No Capstone Research Found
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
</div>