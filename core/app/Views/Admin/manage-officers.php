<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <?php 
                    $flashdata = session()->getFlashData('flashdata');
                    readFlashData($flashdata);
                ?>
                <hr class="mt-2">   
                <section class="mt-5 overview">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-header border-0 py-4">
                                <small class="tle">MANAGE OFFICERS</small>
                            </div>
                            <div class="card-body">
                                <div class="actions mt-5 d-flex justify-content-end">
                                    <a href="<?= base_url('/admin/manage/page/officers/add') ?>" class="btn btn-primary"><i class="bx bx-user-plus"></i> Add Officer</a>
                                </div>
                                <div class="mt-4">
                                    <table class="table no-wrap">
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
                                                if(!empty($data['get_officers']))
                                                {
                                                    foreach($data['get_officers'] as $value)
                                                    {
                                                        echo '
                                                        <tr>
                                                            <td>#' . $value->id . '</td>
                                                            <td>
                                                                <img src="'.base_url('/assets/home/images/officers/'.$value->image.'').'">
                                                            </td>
                                                            <td>' . $value->first_name . ' ' . $value->last_name . '</td>
                                                            <td>' . $value->position . '</td>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <a href="'.base_url('/admin/manage/page/officers/update/'.$value->id.'') .'" class="btn btn-success"><i class="bx bx-edit" ></i> Update</a>
                                                                    <a href="'.base_url('/admin/manage/page/officers/delete/'.$value->id.'') .'" class="btn btn-danger"><i class="bx bxs-trash bx-tada" ></i> Delete</a>
                                                                </di>
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