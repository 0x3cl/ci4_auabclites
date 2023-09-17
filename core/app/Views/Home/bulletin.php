<div class="group-content">
    <div id="news">
        <div class="container py-5">
            <div class="header-wrapper d-flex justify-content-center" data-aos="fade-up">
                <div>
                <div class="section-title">
                    <div class="section-main">
                        <h2>Latest Updates</h2>
                    </div>
                </div>
                <div class="section-sub-title"></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6">
                    <div class="announcements">
                        <?php 
                            if(!empty($data['site_announcements'])) {
                                foreach ($data['site_announcements'] as $key => $value) {
                                    $title = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '', trim($value->title))));
                                    echo '
                                    <a href="'.base_url('/bulletin/announcement/'.$value->id.'/'.$title.'').'">
                                        <div class="card card-design mb-3" data-aos="fade-up">
                                            <div class="overlay-pin">
                                                <img src="'.base_url('/assets/home/images/bg/pin.png').'" alt="pin">
                                            </div>
                                            <img src="'.base_url('/assets/home/images/bulletin/announcements/'.$value->image.'').'" alt="bulletin">
                                            <div class="card-body">
                                                <div class="card-date">
                                                    <small>'.format_timestamp_to_date($value->date_updated).'</small>
                                                </div>
                                                <div class="card-title text-clamp">
                                                    <h4>'.$value->title.'</h4>
                                                    <small class="text-clamp clamp-2">'.$value->content.'</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    ';
                                }

                                if(count($data['site_announcements']) >= 3) {
                                    echo '
                                    <div class="d-flex justify-content-center my-5">
                                        <a href="'.base_url('/bulletin/announcement/page/1').'" class="btn-custom btn-custom-outline text-link">View All</a>
                                    </div>
                                    ';
                                }

                            } else {
                                echo '
                                <div class="card card-design mb-3" data-aos="fade-up">
                                    <div class="overlay-pin">
                                        <img src="'.base_url('/assets/home/images/bg/pin.png').'" alt="pin">
                                    </div>
                                    <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'" alt="bulletin">
                                    <div class="card-body">
                                        <div class="card-date">
                                            <small>As of Now  • '.date('F d, Y').'</small>
                                        </div>
                                        <div class="card-title text-clamp">
                                            <h4>No Available Announcements</h4>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        ?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <?php 
                                if(!empty($data['site_news'])) {
                                    foreach($data['site_news'] as $key => $value) {
                                        $title = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '', trim($value->title))));
                                        echo '
                                        <div class="redirect-page" data-src="'.base_url('/bulletin/news/'.$value->id.'/'.$title.'').'">
                                            <div class="d-flex align-items-center gap-0 gap-md-3 mb-2 news-content" data-aos="fade-up">
                                                <div class="news-image pe-3 pe-md-0 ">
                                                    <img src="'.base_url('/assets/home/images/bulletin/news/'.$value->image.'').'" alt="news">
                                                </div>
                                                <div class="news-title">
                                                    <h5 class="text-clamp clamp-1 m-0">'.$value->title.'</h5>
                                                    <p class="tiny-date">'.format_timestamp_to_date($value->date_updated).'</p>
                                                    <div class="description">
                                                        <small class="text-clamp clamp-3">'.$value->content.'</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        ';
                                    }

                                    if(count($data['site_news']) >= 6) {
                                        echo '
                                        <div class="d-flex justify-content-center my-5">
                                            <a href="'.base_url('/bulletin/news/page/1').'" class="btn-custom btn-custom-outline text-link">View All</a>
                                        </div>
                                        ';
                                    }

                                } else {
                                    echo '
                                    <div class="d-flex align-items-center gap-3 mb-2 news-content" data-aos="fade-up">
                                        <div class="news-image">
                                            <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'" alt="news">
                                        </div>
                                        <div class="news-title">
                                            <h5 class="text-clamp clamp-1 m-0">No Available News</h5>
                                            <p class="tiny-date">As of Now  • '.date('F d, Y').'</p>
                                            <small class="text-clamp clamp-3">Not yet updated | If you continue to see this message, please contact the administrator.</small>
                                        </div>
                                    </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>