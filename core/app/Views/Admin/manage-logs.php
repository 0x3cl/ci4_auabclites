<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5">
                    <div class="mt-5">
                        <?php 
                            $flashdata = session()->getFlashData('flashdata');
                            readFlashData($flashdata);
                        ?>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <div>
                                    <small>USERS ACTIVITY LOGS</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mt-5">
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
                                                            <td>'.$value->username.'</td>
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
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>