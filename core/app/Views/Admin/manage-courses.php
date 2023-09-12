<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <section class="mt-5 overview">
                    <small class="tle">MANAGE CAROUSEL</small>
                    <?php
                         $flashdata = session()->getFlashData('flashdata');
                         readFlashData($flashdata);
                    ?>
                    <div class="card border-0 mt-5">
                        <div class="card-header border-0 py-4 bg-transparent">
                            <div class="actions d-flex justify-content-end">
                                <a href="<?= base_url('/admin/manage/page/home') ?>" class="btn btn-primary">Go Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('/admin/manage/page/home/carousel') ?>" method="post" enctype="multipart/form-data">
                                <div class="d-flex gap-3 mt-3">
                                    <div class="dropbox d-flex justify-content-center align-items-center">
                                        <input type="file" name="images[]" id="content-image" class="" multiple>
                                    </div>
                                </div>
                                <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                    <button class="btn btn-primary p-3">Save Changes</button>
                                </div>
                            </form>
                            <form action="<?= base_url('/admin/manage/page/home/carousel/delete') ?>" method="post">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(empty($data)) {

                                            } else {
                                                foreach($data['carousel_images'] as $value) {
                                                    echo ' 
                                                    <tr>
                                                        <td>#'.$value->id.'</td>
                                                        <td>
                                                            <img src="'.base_url('/assets/home/images/carousel/'.$value->image.'').'">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger mx-1" name="id" value="'.$value->id.'">Delete</button>
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