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
                        <div class="card-body px-4">
                            <div class="mt-5">
                            <?php 
                                $flashdata = session()->getFlashData('flashdata');
                                readFlashData($flashdata);
                            ?>  
                            <div class="actions mb-4 d-flex justify-content-end">
                                <a href="<?= base_url('/admin/manage/page/testimonials') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                            </div>
                            <div class="description mb-4">
                                <div class="alert alert-info">
                                    <div class="alert-heading d-flex align-items-center gap-2">
                                        <i class='bx bxs-info-circle'></i>
                                        <h5 class="m-0">Add Testimonial</h5>
                                    </div>
                                    <hr>
                                    <p class="mt-3 mb-0 text-justify">The Alumni Testimonials section is a heartfelt tribute to the enduring impact of Arellano University's School of Information Technology Education (SITE) on the lives and careers of its graduates. This section serves as a repository of authentic and inspiring feedback and testimonies shared by SITE alumni. These stories resonate with the spirit of achievement, growth, and transformation that define the SITE experience.</p>
                                    <div class="mt-5"><b>Note: All <span class="text-danger fw-bold">*</span> are required</b></div>
                                </div>
                            </div>
                            <form action="<?= base_url('/admin/manage/page/testimonials/add') ?>" method="post" enctype="multipart/form-data">
                                <div class="row mt-5">
                                    <div class="col-12 col-md-12 mb-4">
                                        <label class="fw-bold">Profile Image <span class="text-danger fw-bold">*</span></label>
                                        <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                        <p class="text-muted">Maximum of 5MB</p>
                                        <div class="dropbox d-flex justify-content-center align-items-center">
                                            <input type="file" name="image" id="image" class="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="disabled" required>
                                            <label for="firstname">First Name <span class="text-danger fw-bold">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="disabled" required>
                                            <label for="lastname">Last Name <span class="text-danger fw-bold">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <textarea name="testimonial" id="editor" cols="30" rows="10" class="editor"></textarea>
                                            <label for="testimonial">Testimonial <span class="text-danger fw-bold">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="testimonial-label" id="testimonial-label" class="form-control" autocomplete="disabled" required>
                                            <label for="testimonial-label">Testimonial Label <span class="text-danger fw-bold">*</span></label>
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