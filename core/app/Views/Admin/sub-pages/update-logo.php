<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <section class="mt-">
                    <div class="mt-5">
                        <?php 
                            $flashdata = session()->getFlashData('flashdata');
                            readFlashData($flashdata);
                        ?>
                        <div class="actions mb-4 d-flex justify-content-end">
                            <a href="<?= base_url('/admin/manage/page/home') ?>" class="btn btn-primary"><i class='bx bx-arrow-back'></i> Go Back</a>
                        </div>
                        <form action="<?= base_url('/admin/manage/page/home/logo/update') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="card delete shadow">
                                        <div class="card-header p-4 border-0">
                                            <h5 class="card-title m-0">UPDATE LOGO</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="user-content">
                                                <div class="user-content">
                                                    <div class="avatar-image">
                                                        <input type="hidden" name="id" value="<?= $data['get_home_images'][0]->id ?>">
                                                        <input type="hidden" name="target" value="logo">
                                                        <img src="<?= base_url('/assets/home/images/logo/'.$data["get_home_images"][0]->image .'') ?>" alt="" srcset="">
                                                    </div>
                                                </div>
                                                <div class="dropbox d-flex justify-content-center align-items-center">
                                                    <input type="file" name="image" id="image" class="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="action d-flex justify-content-end mt-3 w-100">
                                <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>