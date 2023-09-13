<div id="officers">
        <div class="container py-4">
            <?php 
                if(!(empty($data['site_officers']))) {
            ?>
                <div class="section-title-left" data-aos="fade-up">
                        <div class="section-main">
                            <h1>LITES Officers</h1>
                            <p>Heads up to league of information technology newly elected officers.</p>
                        </div>
                    </div>
                </div>
                <div class="container">
                <hr>
                </div>
                <div id="light-gallery" class="mb-5 pb-5">
                    <div class="row" data-aos="fade-up">
                    <?php
                        foreach($data['site_officers'] as $value)  {
                            echo '
                                <div class="col-12 col-md-4 col-xl-3 overlay-parent item" data-src="'.base_url('/assets/home/images/officers/'.$value->image).'" data-sub-html="'.ucwords($value->first_name.' ' .$value->last_name).' as '.strtoupper($value->position).'">
                                    <img src="'.base_url('/assets/home/images/officers/'.$value->image).'">
                                    <div class="overlay">
                                        <div class="d-block text-center">
                                            <div class="name">'.$value->first_name.' ' .$value->last_name.'</div>
                                            <div class="position">'.$value->position.'</div>
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
                    <div class="col-12">
                        <div class="bulletin-info">
                            <div class="bulletin-title">
                                No Officers Found
                            </div>
                            <div class="bulletin-date">
                                As of Now  • '.date('F d, Y').'
                            </div>
                            <hr>
                            <div class="bulletin-content">
                                Why Am I seeing this?
                                <ul class="mt-3">
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
