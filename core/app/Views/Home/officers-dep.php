<div class="group-content">
    <div id="officers">
        <div class="officers-content">
            <div class="container py-5">     
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div class="officer-names" data-aos="fade-right">
                        <ul class="list-unstyled">
                            <?php 
                                if(!empty($data['site_officers'])) {

                                    $officers = $data['site_officers'];

                                    echo '
                                    <li class="list-unstyled">
                                        <a href="javascript:void(0)" class="active" id="select-officer" data-id="1">
                                            <span class="overlay-count">01</span>
                                            '.$officers[0]->last_name.'
                                        </a>
                                    </li>
                                    ';

                                    array_shift($officers);

                                    foreach($officers as $key => $value) {
                                        $key = $key + 2;
                                        echo '
                                        <li class="list-unstyled">
                                            <a href="javascript:void(0)" class="" id="select-officer" data-id="'.$key.'">
                                                <span class="overlay-count">0'.$key.'</span>
                                                '.$value->last_name.'
                                            </a>
                                        </li>
                                        ';
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="officer-image" data-aos="fade-left">
                        <?php 
                            if(!empty($data['site_officers'])) {
                                $officers = $data['site_officers'];

                                echo '
                                <div class="item active" data-id="1">
                                    <img src="'.base_url('/assets/home/images/officers/'.$officers[0]->image.'').'" alt="" srcset="">
                                    <div class="name-overlay" data-aos="fade-up" data-aos-duration="1500">
                                        <h1>'.$officers[0]->position.'</h1>
                                    </div>
                                </div>
                                ';

                                array_shift($officers);

                                foreach($officers as $key => $value) { 
                                    $key = $key + 2;

                                    echo '
                                    <div class="item" data-id="'.$key.'">
                                        <img src="'.base_url('/assets/home/images/officers/'.$value->image.'').'" alt="" srcset="">
                                        <div class="name-overlay" data-aos="fade-up" data-aos-duration="1500">
                                            <h1>'.$value->position.'</h1>
                                        </div>
                                    </div>
                                    ';
                                }

                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="about-officer">
            <div class="container p-3">
                <?php 
                
                if(!empty($data['site_officers'])) {
                    $officers = $data['site_officers'];

                    echo '
                    <div class="item active" data-id="1">
                        <div class="card">
                            <div class="card-body py-0">
                                <div class="border-ab">
                                    <div class="py-5">
                                        <div class="about-item">
                                            <div class="label-rem">
                                                // Role
                                            </div>
                                            <div class="header">
                                                <h1>'.$officers[0]->position.'</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    array_shift($officers);

                    foreach($officers as $key => $value) {
                        $key = $key + 2;
                        echo '
                        <div class="item" data-id="'.$key.'">
                            <div class="card">
                                <div class="card-body py-0">
                                    <div class="border-ab">
                                        <div class="py-5">
                                            <div class="about-item">
                                                <div class="label-rem">
                                                    // Role
                                                </div>
                                                <div class="header">
                                                    <h1>'.$value->position.'</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
</div>