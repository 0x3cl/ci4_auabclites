

<div class="group-content">
    <div id="news">
        <div class="container py-5">
            <div class="section-title-left" data-aos="fade-up">
                <div class="section-main">
                    <h1>LATEST NEWS</h1>
                    <p>Stay updated on the most recent news.</p>
                </div>
            </div>
            <hr>
            <div class="row my-5">
                <?php 
                    if(!empty($data['site_news'])) {
                        $total_page = ceil($data['set']['total_pages']);
                        $current_page = $data['set']['current_page'] ?? 1;
                        echo '
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                <li class="breadcrumb-item"><a href="'.base_url('/bulletin/news/page/1').'" class="text-link">News</a></li>
                                <li class="breadcrumb-item active">Page'.$current_page.'</a></li>
                            </ol>
                        </nav>
                        ';
                        foreach($data['site_news'] as $key => $value) {
                            $title = strtolower(preg_replace('/-+/', '-', str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '', trim($value->title)))));
                            echo '
                            <div class="col-12 col-md-6">
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
                            </div>
                            ';
                        }
                        
                        if($total_page > 1) {
                            if($current_page == 1) {
                                echo '
                                <div class="action d-flex gap-3 justify-content-center mt-5">
                                    <a href="'.base_url('/bulletin/news/page/'.($current_page + 1)).'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1">Next <i class="bx bxs-chevrons-right" style="margin-top: 2px"></i></a>
                                </div>
                                ';
                            } else if($current_page == $total_page) {
                                echo '
                                <div class="action d-flex gap-3 justify-content-center mt-5">
                                    <a href="'.base_url('/bulletin/news/page/'.($current_page - 1)).'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1"><i class="bx bxs-chevrons-left" style="margin-top: 2px"></i>Prev</a>
                                </div>
                                ';
                            } else {
                                echo '
                                <div class="action d-flex gap-3 justify-content-center mt-5">
                                    <a href="'.base_url('/bulletin/news/page/'.($current_page - 1)).'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1"><i class="bx bxs-chevrons-left" style="margin-top: 2px"></i>Prev</a>
                                    <a href="'.base_url('/bulletin/news/page/'.($current_page + 1)).'" class="btn-custom btn-custom-outline text-link d-flex align-items-center gap-1">Next <i class="bx bxs-chevrons-right" style="margin-top: 2px"></i></a>
                                </div>
                                ';
                            }
                        }
                       
                    } else {
                        echo '
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                                <li class="breadcrumb-item"><a href="'.base_url('/bulletin').'" class="text-link">Bulletin</a></li>
                                <li class="breadcrumb-item"><a href="'.base_url('/bulletin/news/page/1').'" class="text-link">News</a></li>
                                <li class="breadcrumb-item active">404 Not Found</a></li>
                            </ol>
                        </nav>
                        <div class="col-12">
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
                ?>
            </div>
        </div>
    </div>