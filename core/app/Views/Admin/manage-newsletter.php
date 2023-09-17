<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <?php 
                    $flashdata = session()->getFlashData('flashdata');
                    readFlashData($flashdata);
                ?>
                <section class="mt-5">
                    <div class="mt-5">
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <div>
                                    <small>Emails Recieving Newsletter</small>
                                </div>
                            </div>
                            <div class="card-body px-4">
                                <div class="mt-5">
                                    <table id="table" class="display">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($data['emails'] as $value) {
                                                    echo '
                                                        <tr>
                                                            <td>'.$value->id.'</td>
                                                            <td>'.$value->email.'</td>
                                                            <td>'.format_timestamp_to_date($value->date_updated).'</td>
                                                            <td>'.format_timestamp_to_time($value->date_updated).'</td>
                                                            <td>
                                                                <a href="'. base_url('/admin/manage/newsletter/delete/'.$value->id).'" class="btn my-2 btn-danger"><i class="bx bx-trash" ></i> Delete</a>
                                                            </td>
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