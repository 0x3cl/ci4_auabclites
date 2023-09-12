<div class="group-content">
    <div id="research" class="mb-5">
        <div class="container py-5">
            <?php 
                if(!empty($data['site_research_data'])) {
            ?>
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=  base_url('/home') ?>" class="text-link">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/research') ?>" class="text-link">Capstone Research</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $data['site_research_data'][0]->title; ?></li>
                </ol>
            </nav>
            <div class="section-title-center mt-5 mb-5" data-aos="fade-up">
                <div class="section-main">
                    <h1><?= $data['site_research_data'][0]->title ?></h1>
                </div>
            </div>
            <div class="research-preview" data-aos="fade-up">
                <img src="<?= base_url('/assets/home/images/research/' . $data['site_research_data'][0]->image) ?>" alt="" srcset="">
            </div>
            <?php 
                if(!empty($data['site_research_images'])) {
                    echo '
                    <div id="light-gallery" class="image-grid single mt-3 overlay">
                        <div class="gallery-contaier">
                    ';
                    foreach($data['site_research_images'] as $key => $value) {
                        echo '
                            <div class="item mini-thumbnail" data-src="'.base_url('/assets/home/images/research/'.$value->image.'').'">
                                <img src="'.base_url('/assets/home/images/research/'.$value->image.'').'">
                            </div>        
                        ';
                    }
                    echo '
                        </div>
                    </div>
                    <p class="mt-3 text-center"><i>Click images to view more</i></p>
                    ';
                }
            ?>
            <div class="row my-5 mb-5">
                <div class="col-12 col-lg-6 mb-3" data-aos="fade-up">
                    <div class="card card-design-secondary bg-transparent border-0">
                        <div class="card-header p-4 bg-transparent">
                            <h4 class="card-title mb-0">Development Details</h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Posted:</div>
                                <div>
                                    <span><?= format_timestamp_to_date($data['site_research_data'][0]->date_updated) ?></span>
                                </div>
                            </div>
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Authors:</div>
                                <div>
                                    <?php
                                        if(!empty($data['site_research_authors'][0])) {
                                            echo '
                                                <span>'.$data['site_research_authors'][0]->firstname. ' ' . $data['site_research_authors'][0]->lastname . '</span>
                                            ';
                                        } else {
                                            echo '<span style="text-decoration: line-through">Author/s are currently not available</span>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Platform:</div>
                                <div>
                                    <span><?= ucwords($data['site_research_data'][0]->platform) ?></span>
                                </div>
                            </div>
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Technologies:</div>
                                <div>
                                    <?php
                                        $technologies = [];
                                        foreach($data['site_research_technologies'] as $key => $value) {
                                            $technologies[] = $value->technologies;
                                        }

                                        echo implode(', ', $technologies);
                                        
                                    ?>
                                </div>
                            </div>
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Features:</div>
                                <div>
                                    <?php
                                         $description = explode("\n", $data['site_research_data'][0]->features);
                                         echo '
                                             <ul>
                                         ';
                                         
                                         foreach($description as $value) {
                                             echo '<li>'.$value.'</li>';
                                         }
                                         echo'
                                             </ul>
                                         ';
                                    ?>
                                </div>
                            </div>
                            <div class="d-flex item justify-content-start align-items-start gap-3 mb-3">
                                <div>Repositories:</div>
                                <div>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="<?= $data['site_research_data'][0]->link ?>" class="text-link d-flex align-items-center gap-1">
                                                <?= repo_icon($data['site_research_data'][0]->repository); ?>
                                                <span><?= strtoupper($data['site_research_data'][0]->repository) ?></span>
                                            </a>
                                        </li>
                                    </ul> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-3" data-aos="fade-up">
                    <div class="card bg-transparent border-0">
                        <div class="card-header p-4 bg-transparent">
                            <h4 class="card-title mb-0">Abstract</h4>
                        </div>
                        <div class="card-body text-justify p-4">
                            <p class=>
                                <?= $data['site_research_data'][0]->abstract ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="developer-profiles" data-aos="fade-up">
                <h2 class="sub-section-title">Author Profiles</h2>
                <div class="row">
                    <?php
                        if(!empty($data['site_research_authors'])) {
                            foreach($data['site_research_authors'] as $key => $value) {
                                $about = explode("\n", $value->about);
                                echo '
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card border-0 shadow">
                                        <div class="card-header">
                                            <img src="'.base_url('/assets/home/images/authors/'.$value->image.'').'" alt="author">
                                        </div>
                                        <div class="card-body">
                                            <div class="author-name">
                                                <h4>'.ucwords($value->firstname . ' ' . $value->lastname).'</h4>
                                            </div>
                                            <div class="author-description mt-3 text-start">
                                                <ul class="list-unstyled mt-3">
                                        ';
                                        foreach($about as $value) {
                                                echo 
                                                '<li>
                                                    <div class="d-flex align-items-start">
                                                        <span class="faculty-check"><i class="bx bx-check"></i></span>
                                                        <p class="m-0">'.$value.'</p>
                                                    </div>
                                                </li>
                                                    ';
                                            }
                                echo '
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        } else {
                            echo '
                            <div class="col-12 mb-3">
                                div class="bulletin-info mt-4">
                                    <div class="bulletin-date">
                                        As of Now  • '.date('F d, Y').'
                                    </div>
                                    <div class="bulletin-title">
                                        No Research Found
                                    </div>
                                    <div class="bulletin-posted-by">
                                        Posted by: System
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
            <?php
                } else {
                    echo '
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="'.base_url('/home').'" class="text-link">Home</a></li>
                            <li class="breadcrumb-item"><a href="'.base_url('/bulletin/news').'" class="text-link">Research</a></li>
                            <li class="breadcrumb-item active" aria-current="page">404 Not Found</li>
                        </ol>
                    </nav>
                    <div class="col-12 mb-3 mt-5">
                        <div class="alert alert-danger text-center">
                            <small>OOPS, LOOKS LIKE YOUR&apos;RE TRYING TO ACCESS INVALID LINK</small>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
    </div>