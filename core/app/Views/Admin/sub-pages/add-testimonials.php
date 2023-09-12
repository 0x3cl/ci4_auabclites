<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <section class="mt-5">
                    <div class="card">
                        <div class="card-header border-0 py-4">
                            <small>ADD TESTIMONIAL</small>
                        </div>
                        <div class="card-body">
                            <div class="mt-5">
                            <?php 
                                $flashdata = session()->getFlashData('flashdata');
                                readFlashData($flashdata);
                            ?>  
                            <div class="actions mb-4 d-flex justify-content-end">
                                <a href="<?= base_url('/admin/manage/page/testimonials') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                            </div>
                            <form action="<?= base_url('/admin/manage/page/testimonials/add') ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 col-md-12 mb-4">
                                        <div class="dropbox d-flex justify-content-center align-items-center">
                                            <input type="file" name="image" id="image" class="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="disabled" required>
                                            <label for="firstname">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="disabled" required>
                                            <label for="lastname">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <textarea name="testimonial" id="testimonial" cols="30" rows="10" class="form-control" autocomplete="disabled" required></textarea>
                                            <label for="testimonial">Testimonial</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="action d-flex justify-content-end mt-3 w-100">
                                    <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>