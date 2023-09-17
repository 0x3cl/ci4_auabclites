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
                                <small>YOUR PROFILE IMAGE</small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/me/update/image') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?= $data["get_user_data"][0]->id ?>">
                                        <div class="col-12 col-md-12 mb-4">
                                            <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                            <p class="text-muted">Maximum of 5MB</p>
                                            <div class="d-block d-md-flex gap-3">
                                                <div class="user-content">
                                                    <div class="avatar-image">
                                                        <img src="<?= base_url('/assets/admin/uploads/avatar/' . $data["get_user_data"][0]->image . '') ?>" alt="" srcset="">
                                                    </div>
                                                </div>
                                                <div class="dropbox d-flex justify-content-center align-items-center">
                                                    <input type="file" name="image" id="image" class="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-3 w-100">
                                        <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small>YOUR PROFILE INFORMATION</small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/me/update/data') ?>" method="post">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?= $data["get_user_data"][0]->id ?>">
                                        <div class="col-12 col-md-4 mb-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" autocomplete="disabled" value="#<?= $data["get_user_data"][0]->id ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" autocomplete="disabled" value="<?= strtoupper(format_position($data["get_user_data"][0]->position)) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" autocomplete="disabled" value="<?= strtoupper($data["get_user_data"][0]->username) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="disabled" value="<?= $data["get_user_data"][0]->first_name ?>" required>
                                                <label for="firstname">First Name <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="disabled" value="<?= $data["get_user_data"][0]->last_name ?>" required>
                                                <label for="lastname">Last Name <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-3 w-100">
                                        <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                       
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>