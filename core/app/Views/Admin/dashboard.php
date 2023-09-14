<div class="dashboard-wrapper my-md-0">
    <?= view('admin/templates/sidebar') ?>
    <div class="content">
        <?= view('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">
                <div class="d-block d-md-flex justify-content-between align-items-center mt-5 mb-5">
                    <div class="greetings mb-3 mb-lg-0">
                        <h5>Welcome Back!</h5>
                        <h1 class="text-single"><?= strtoupper(session()->get('session_token')["first_name"] . ' ' . session()->get('session_token')["last_name"]) ?></h1>
                    </div>
                    <div class="shortcuts d-flex gap-2 ">
                        <button type="button" class="btn btn-primary btn-standard btn-icon" id="btn-toggle-theme"><i class='bx bx-moon'></i> Dark Mode </button>
                        <div class="my-2 my-md-2 my-lg-0"></div>
                        <button type="button" class="btn btn-outline-primary btn-standard btn-icon dropdown-toggle"><i class='bx bx-grid'></i> Shortcuts</button>
                    </div>
                </div>
                <hr>
                <?php 
                    if(empty($data['user_widgets'])) {
                        echo '
                            <div class="card mt-5">
                                <div class="card-body">
                                    No widgets currently enabled. Click <a href="/admin/widgets">here</a> to add.
                                </di>
                            </div>
                        ';
                    } else {
                        foreach($data['user_widgets'] as $value) {
                            if($value->widget_id == 1) {
                                echo '
                                <section class="mt-5 overview">
                                    <small>Overview</small>
                                    <div id="overview-dom">
                                        <div class="row mt-4 skeleton-container">
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4 mb-2 mb-md-3">
                                                <div class="card skeleton-card">
                                                    <div class="card-header bg-transparent border-0">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="skeleton-text skeleton-w-100"></div>
                                                        <div class="skeleton-text skeleton-w-50"></div>
                                                        <div class="skeleton-text skeleton-w-75"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                ';
                            }

                            if($value->widget_id == 2) {
                                echo '
                                <hr>
                                <section class="mt-5">
                                    <small>Site Visitors</small>
                                    <div class="row mt-4">
                                        <div class="col-12" id="graph-line-dom">
                                            <div class="card border-0 skeleton-card-default">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                ';
                            }

                            if($value->widget_id == 3) {
                                echo '
                                <hr>
                                <section class="mt-5">
                                    <small> Site Referrers </small>
                                    <div class="row mt-4">
                                        <div class="col-12" id="graph-bar-dom">
                                            <div class="card border-0 skeleton-card-default">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                ';
                            }

                            if($value->widget_id == 4) {
                            
                            ?>
                                <hr>
                                <section class="mt-5">
                                    <small>Site Activity Logs</small>
                                    <div class="row mt-5">
                                        <div class="col-12 col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Log ID</th>
                                                        <th>Username</th>
                                                        <th>Activity</th>
                                                        <th>Position</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach($data['get_logs'] as $value) {
                                                            echo '
                                                                <tr>
                                                                    <td>'.$value->id.'</td>
                                                                    <td>'.$value->first_name . ' ' . $value->last_name .'</td>
                                                                    <td>'.$value->activity.'</td>
                                                                    <td>'.format_position($value->position).'</td>
                                                                    <td>'.format_timestamp_to_date($value->date_updated).'</td>
                                                                    <td>'.format_timestamp_to_time($value->date_updated).'</td>
                                                                </tr>
                                                            ';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>   
                                        </div>    
                                    </div>
                                </section>
                               <?php 
                            }
                        }
                    }

                ?>
            </div>
        </div>
    </div>
</div>

