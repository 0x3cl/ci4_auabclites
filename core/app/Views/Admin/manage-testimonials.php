<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5 overview">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-header border-0 py-4">
                                <small class="tle">MANAGE TESTIMONIALS</small>
                            </div>
                            <?php
                                 $flashdata = session()->getFlashData('flashdata');
                                 readFlashData($flashdata);
                            ?>
                            <div class="card-body">
                                <div class="actions mt-5 d-flex justify-content-end">
                                    <a href="<?= base_url('/admin/manage/page/testimonials/add') ?>" class="btn btn-primary"><i class='bx bx-user-voice'></i> Add Testimonial</a>
                                </div>
                                <div class="mt-4">
                                    <table id="table" class="display">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(!empty($data['get_testimonials']))
                                                {
                                                    foreach($data['get_testimonials'] as $value)
                                                    {
                                                        echo '
                                                        <tr>
                                                            <td>' . $value->id . '</td>
                                                            <td>
                                                                <img src="'.base_url('/assets/home/images/testimonials/'.$value->image.'').'">
                                                            </td>
                                                            <td>' . $value->first_name .'</td>
                                                            <td>'. $value->last_name.'</td>
                                                            <td>
                                                                <a href="'.base_url('/admin/manage/page/testimonials/update/'.$value->id.'') .'" class="btn d-flex justify-content-center my-2 btn-success"><i class="bx bx-edit" ></i> Update</a>
                                                                <a href="'.base_url('/admin/manage/page/testimonials/delete/'.$value->id.'') .'" class="btn d-flex justify-content-center my-2 btn-danger"><i class="bx bxs-trash bx-tada" ></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                        ';
                                                    }
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