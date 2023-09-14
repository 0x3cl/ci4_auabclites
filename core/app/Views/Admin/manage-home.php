<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <section class="mt-5 overview">
                    <?php 
                        $flashdata = session()->getFlashData('flashdata');
                        readFlashData($flashdata);
                    ?>
                    <hr class="my-5">
                    <div class="card mt-4">
                        <div class="card-header border-0 pt-4 bg-transparent">
                            <small class="tle">MANAGE LOGOS</small>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('/admin/manage/page/bulletin/update/banner/') ?>" method="post" enctype="multipart/form-data" id="form-banner">
                                <table id="table" class="display">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Logo</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $logo_data = array_splice($data['get_home_images'], 2);
                                            if(!empty($logo_data)) {
                                                foreach($logo_data as $value) {
                                                    echo '
                                                    <tr>
                                                        <td>'.$value->id.'</td>
                                                        <td>
                                                            <img src="'.base_url('/assets/home/images/logo/'.$value->image.'').'">
                                                        </td>
                                                        <td>'.$value->field.'</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="'.base_url('/admin/manage/page/home/logo/update/'.$value->id.'').'" class="btn btn-success mx-1"><i class="bx bxs-edit" ></i> Update</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>