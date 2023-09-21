

<div class="group-content">
    <div id="news">
        <div class="container">
            <div class="row my-5">
                <?php 
                    $request = (request()->uri->getSegments())[1];
                    if($request == 'announcement') {
                        if(!empty($data['bulletin_data'])) {
                            echo '
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin/announcement').'" class="text-link">Announcements</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">'.$data['bulletin_data'][0]->title.'</li>
                                </ol>
                            </nav>
                            <div class="col-12 col-md-7">
                                <div class="card">
                                    <img src="'.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category)) . '/' . $data['bulletin_data'][0]->image .''.'">
                                </div>
                                <div class="bulletin-info mt-4">
                                    <div class="bulletin-title">
                                        <span class="announce"><i class="bx bxs-megaphone"></i></span>'. ucwords($data['bulletin_data'][0]->title).'
                                    </div>
                                    <div class="bulletin-date">
                                        Posted on: '. format_timestamp_to_date($data['bulletin_data'][0]->date_updated).'
                                    </div>
                                    <div class="bulletin-date">
                                       By: '.ucwords($data['bulletin_data'][0]->source).'
                                    </div>
                                    <div class="bulletin-content mt-4">
                                        '. $data['bulletin_data'][0]->content .'
                                    </div>
                                    ';
    
                                    if(!empty($data['bulletin_images'])) {
                                        echo '
                                        <div class="mt-5">
                                            <div id="light-gallery" class="image-grid">
                                        ';
                                        foreach($data['bulletin_images'] as $key => $value) {
                                            echo '
                                            <div class="item" data-src="'.base_url(''.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category).'/'. $value->image.'').'').'">
                                                <img src="'.base_url(''.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category).'/'. $value->image.'').'').'">                                        
                                            </div>
                                            ';
                                        }
                                        
                                        echo '
                                            </div>
                                        </div>
                                        ';
                                    }
    
                                echo 
                                '<hr class="mt-5">
                                    <div class="bulletin-share">
                                        <h6 class="text-muted">Share this page <i class="bx bxs-share share"></i></h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bx bxs-share share"></i>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u='.base_url('/bulletin/announcement/'.$data['bulletin_data'][0]->id.'').'" target="_blank" class="text-link">
                                                <i class="bx bxl-facebook-square"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url='.base_url('/bulletin/announcement/'.$data['bulletin_data'][0]->id.'').'" target="_blank" class="text-link">
                                                <i class="bx bxl-twitter"></i>
                                            </a>
                                            <a href="fb-messenger://share/?link='.base_url('/bulletin/announcement/'.$data['bulletin_data'][0]->id.'').'" target="_blank">
                                                <i class="bx bxl-messenger"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        } else {
                            echo '
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin/announcement').'" class="text-link">Announcements</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">404 Not Found</li>
                                </ol>
                            </nav>
                            <div class="col-12 col-md-7">
                                <div class="card">
                                    <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'">
                                </div>
                                <div class="bulletin-info mt-4">
                                    <div class="bulletin-date">
                                        As of Now  • '.date('F d, Y').'
                                    </div>
                                    <div class="bulletin-title">
                                        No Announcement Found
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

                        if(!empty($data['bulletin_other'])) {
                            echo '
                            <div class="col-12 col-md-5">
                                ';

                            foreach($data['bulletin_other'] as $value) {
                                echo '
                                <div class="redirect-page" data-src="'.base_url('/bulletin/news/'.$value->id).'">
                                    <div class="d-flex align-items-center gap-0 gap-md-3 mb-2 news-content" data-aos="fade-up">
                                        <div class="news-image pe-3 pe-md-0 ">
                                            <img src="'.base_url('/assets/home/images/bulletin/announcements/'.$value->image.'').'" alt="news">
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
                              
                            if(count($data['bulletin_other']) >= 8) {
                                echo '
                                    <div class="action d-flex gap-3 justify-content-center mt-5">
                                        <a href="'.base_url('/bulletin/announcement/page/1').'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1">More</a>
                                    </div>
                                ';
                            }

                            echo '
                            </div>
                            ';

                        } else {
                            echo '
                            <div class="col-12 col-md-5">
                                <div class="d-flex align-items-start gap-3 mb-2 news-content" data-aos="fade-up">
                                    <div class="news-image w-100">
                                        <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'" alt="news">
                                    </div>
                                    <div class="news-title w-50 mt-2">
                                        <h5 class="text">No Other Announcements</h5>
                                        <p class="tiny-date">As of Now</p>
                                        <small class="text-clamp clamp-3"></small>
                                    </div>
                                </div>
                            </div>
                            ';
                        }

                    }
                    if($request == 'news') {
                        if(!empty($data['bulletin_data'])) {
                            echo '
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin/news').'" class="text-link">News</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">'.$data['bulletin_data'][0]->title.'</li>
                                </ol>
                            </nav>
                            <div class="col-12 col-md-7">
                                <div class="card">
                                    <img src="'.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category)) . '/' . $data['bulletin_data'][0]->image .''.'">
                                </div>
                                <div class="bulletin-info mt-4">
                                    <div class="bulletin-title">
                                        '. ucwords($data['bulletin_data'][0]->title).'
                                    </div>
                                    <div class="bulletin-date">
                                        Posted on: '. format_timestamp_to_date($data['bulletin_data'][0]->date_updated).'
                                    </div>
                                    <div class="bulletin-date">
                                       By: '.ucwords($data['bulletin_data'][0]->source).'
                                    </div>
                                    <div class="bulletin-content mt-4">
                                        '. $data['bulletin_data'][0]->content .'
                                    </div>
                                    ';
    
                                    if(!empty($data['bulletin_images'])) {
                                        echo '
                                        <div class="mt-5">
                                            <div id="light-gallery" class="image-grid">
                                        ';
                                        foreach($data['bulletin_images'] as $key => $value) {
                                            echo '
                                            <div class="item" data-src="'.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category).'/'. $value->image.'').'">
                                                <img src="'.base_url('/assets/home/images/bulletin/'.format_bulletin_category($data['bulletin_data'][0]->category).'/'. $value->image.'').'">                                        
                                            </div>
                                            ';
                                        }
                                        
                                        echo '
                                            </div>
                                        </div>
                                        <p class="mt-3"><i>Click Images to view more</i></p>
                                        ';
                                    }
    
                                echo 
                                '<hr class="mt-5">
                                    <div class="bulletin-share">
                                        <h6 class="text-muted">Share this page <i class="bx bxs-share share"></i></h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u='.base_url('/bulletin/news/'.$data['bulletin_data'][0]->id.'').'" target="_blank" class="text-link">
                                                <i class="bx bxl-facebook-square"></i>
                                            </a>
                                            <a href="https://twitter.com/intent/tweet?url='.base_url('/bulletin/news/'.$data['bulletin_data'][0]->id.'').'" target="_blank" class="text-link">
                                                <i class="bx bxl-twitter"></i>
                                            </a>
                                            <a href="fb-messenger://share/?link='.base_url('/bulletin/news/'.$data['bulletin_data'][0]->id.'').'" target="_blank">
                                                <i class="bx bxl-messenger"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        } else {
                            echo '
                            <nav aria-label="breadcrumb" class="mb-3">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                    <li class="breadcrumb-item"><a href="'.base_url('/bulletin/news').'" class="text-link">News</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">404 Not Found</li>
                                </ol>
                            </nav>
                            <div class="col-12 col-md-7">
                                <div class="card">
                                    <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'">
                                </div>
                                <div class="bulletin-info mt-4">
                                    <div class="bulletin-date">
                                        As of Now  • '.date('F d, Y').'
                                    </div>
                                    <div class="bulletin-title">
                                        No News Found
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

                        if(!empty($data['bulletin_other'])) {
                            echo '
                            <div class="col-12 col-md-5">
                                ';
                            
                            foreach($data['bulletin_other'] as $value) {
                                echo '
                                <div class="redirect-page" data-src="'.base_url('/bulletin/news/'.$value->id).'">
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
                            
                            if(count($data['bulletin_other']) >= 8) {
                                echo '
                                    <div class="action d-flex gap-3 justify-content-center mt-5">
                                        <a href="'.base_url('/bulletin/news/page/1').'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1">More</a>
                                    </div>
                                ';
                            }

                            echo '
                            </div>
                            ';
                            

                        } else {
                            echo '
                            <div class="col-12 col-md-5">
                                <div class="d-flex align-items-start gap-3 mb-2 news-content" data-aos="fade-up">
                                    <div class="news-image w-100">
                                        <img src="'.base_url('/assets/home/images/defaults/no-records-found.jpg').'" alt="news">
                                    </div>
                                    <div class="news-title w-50 mt-2">
                                        <h5 class="text">No Other News</h5>
                                        <p class="tiny-date">As of Now</p>
                                        <small class="text-clamp clamp-3"></small>
                                    </div>
                                </div>
                            </div>
                            ';
                        }

                    }
                ?>
            </div>
        </div>
    </div>