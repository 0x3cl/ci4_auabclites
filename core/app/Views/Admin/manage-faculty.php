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
                                <small class="tle">MANAGE FACULTY</small>
                            </div>
                            <?php
                                 $flashdata = session()->getFlashData('flashdata');
                                 readFlashData($flashdata);
                            ?>
                            <div class="card-body">
                                <div class="actions mt-5 d-flex justify-content-end">
                                    <a href="<?= base_url('/admin/manage/page/faculty/add') ?>" class="btn btn-primary"><i class="bx bx-user-plus"></i> Add Faculty</a>
                                </div>
                                <div class="mt-4">
                                    <table id="table" class="display">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Full Name</th>
                                                <th>Position</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(!empty($data['get_faculty'])) {
                                                    foreach($data['get_faculty'] as $value) {
                                                        echo '
                                                        <tr>
                                                            <td>' . $value->id . '</td>
                                                            <td>
                                                                <img src="'.base_url('/assets/home/images/faculty/'.$value->image.'').'">
                                                            </td>
                                                            <td>' . $value->first_name . ' ' . $value->last_name . '</td>
                                                            <td>' . $value->position . '</td>
                                                            <td>
                                                                <a href="'.base_url('/admin/manage/page/faculty/update/'.$value->id.'').'" class="btn my-2 d-flex justify-content-center btn-success"><i class="bx bx-edit" ></i> Update</a>
                                                                <a href="'.base_url('/admin/manage/page/faculty/delete/'.$value->id.'').'" class="btn my-2 d-flex justify-content-center btn-danger"><i class="bx bxs-trash bx-tada" ></i> Delete</a>
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