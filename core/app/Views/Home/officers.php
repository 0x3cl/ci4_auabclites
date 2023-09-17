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
                    <div id="light-gallery" class="mb-5 pb-5">
                        <?php 
                            $executives_id = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                            $editorial_id = [13, 14, 15, 16, 17];
                            $creatives_id = [18, 19, 20];
                            $representatives_id = [21, 22, 23, 24, 25];
                            
                            $new_data = [];
                            
                            foreach ($data['site_officers'] as $value) {
                                $category = '';
                                
                                if (in_array($value->position_id, $executives_id)) {
                                    $category = 'executives';
                                }
                                elseif (in_array($value->position_id, $editorial_id)) {
                                    $category = 'editorial';
                                }
                                elseif (in_array($value->position_id, $creatives_id)) {
                                    $category = 'creatives';
                                }
                                elseif (in_array($value->position_id, $representatives_id)) {
                                    $category = 'representatives';
                                }
                                
                                if (!empty($category)) {
                                    $new_data[$category][] = $value;
                                }
                            }
                        ?>
                        <div id="executives">
                            <div class="section-title-left mt-5 mb-4" data-aos="fade-up">
                                <div class="section-main">
                                    <h1 style="border: none">The Executive Board</h1>
                                </div>
                            </div>
                            <div class="row" data-aos="fade-up">
                                <?php
                                    foreach($new_data['executives'] as $value) {
                                        echo '
                                            <div class="col-6 col-md-4 col-xl-3 overlay-parent item mb-2" data-src="'.base_url('/assets/home/images/officers/'.$value->image).'" data-sub-html="'.ucwords($value->first_name.' ' .$value->last_name).' as '.strtoupper($value->position).'">
                                                <div class="position-relative card">
                                                    <img src="'.base_url('/assets/home/images/officers/'.$value->image).'">
                                                    <div class="overlay">
                                                        <div class="d-block text-center px-3">
                                                            <div class="name">'.$value->first_name.' ' .$value->last_name.'</div>
                                                            <div class="position">'.$value->position.'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                        <div id="editorial">
                            <div class="section-title-left mt-5 mb-4" data-aos="fade-up">
                                <div class="section-main">
                                    <h1 style="border: none">The Editorial Board</h1>
                                </div>
                            </div>
                            <div class="row" data-aos="fade-up">
                                <?php
                                    foreach($new_data['editorial'] as $value) {
                                        echo '
                                            <div class="col-6 col-md-4 col-xl-3 overlay-parent item mb-2" data-src="'.base_url('/assets/home/images/officers/'.$value->image).'" data-sub-html="'.ucwords($value->first_name.' ' .$value->last_name).' as '.strtoupper($value->position).'">
                                                <div class="position-relative card">
                                                    <img src="'.base_url('/assets/home/images/officers/'.$value->image).'">
                                                    <div class="overlay">
                                                        <div class="d-block text-center px-3">
                                                            <div class="name">'.$value->first_name.' ' .$value->last_name.'</div>
                                                            <div class="position">'.$value->position.'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                        <div id="creatives">
                            <div class="section-title-left mt-5 mb-4" data-aos="fade-up">
                                <div class="section-main">
                                    <h1 style="border: none">The Creatives</h1>
                                </div>
                            </div>
                            <div class="row" data-aos="fade-up">
                                <?php
                                    foreach($new_data['creatives'] as $value) {
                                        echo '
                                            <div class="col-6 col-md-4 col-xl-3 overlay-parent item mb-2" data-src="'.base_url('/assets/home/images/officers/'.$value->image).'" data-sub-html="'.ucwords($value->first_name.' ' .$value->last_name).' as '.strtoupper($value->position).'">
                                                <div class="position-relative card">
                                                    <img src="'.base_url('/assets/home/images/officers/'.$value->image).'">
                                                    <div class="overlay">
                                                        <div class="d-block text-center px-3">
                                                            <div class="name">'.$value->first_name.' ' .$value->last_name.'</div>
                                                            <div class="position">'.$value->position.'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                        <div id="representatives">
                            <div class="section-title-left mt-5 mb-4" data-aos="fade-up">
                                <div class="section-main">
                                    <h1 style="border: none">Representatives</h1>
                                </div>
                            </div>
                            <div class="row" data-aos="fade-up">
                                <?php
                                    foreach($new_data['representatives'] as $value) {
                                        echo '
                                            <div class="col-6 col-md-4 col-xl-3 overlay-parent item mb-2" data-src="'.base_url('/assets/home/images/officers/'.$value->image).'" data-sub-html="'.ucwords($value->first_name.' ' .$value->last_name).' as '.strtoupper($value->position).'">
                                                <div class="position-relative card">
                                                    <img src="'.base_url('/assets/home/images/officers/'.$value->image).'">
                                                    <div class="overlay">
                                                        <div class="d-block text-center px-3">
                                                            <div class="name">'.$value->first_name.' ' .$value->last_name.'</div>
                                                            <div class="position">'.$value->position.'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                        </div>
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
