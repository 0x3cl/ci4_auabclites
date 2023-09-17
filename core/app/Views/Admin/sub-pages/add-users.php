<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5">
                    <div class="card">
                        <div class="card-header border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small>Add User</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="mt-4">
                                <?php 
                                    $flashdata = session()->getFlashData('flashdata');
                                    readFlashData($flashdata);
                                ?>
                                <div class="actions d-flex justify-content-end mb-4">
                                    <a href="<?= base_url('/admin/manage/users') ?>" class="btn btn-primary icon"><i class='bx bx-arrow-back'></i> Go Back</a>
                                </div>
                                <div class="description mb-4">
                                    <div class="alert alert-info">
                                        <div class="alert-heading d-flex align-items-center gap-2">
                                            <i class='bx bxs-info-circle'></i>
                                            <h5 class="m-0">Add Users</h5>
                                        </div>
                                        <hr>
                                        <p class="mt-3 mb-0 text-justify"> These features empower administrators to manage and control access to the organization's digital resources and platforms, ensuring that only authorized individuals can perform specific actions and manage content.</p>
                                        <div class="mt-5"><b>Note: All <span class="text-danger fw-bold">*</span> are required</b></div>
                                    </div>
                                </div>
                                <form action="<?= base_url('/admin/manage/users/add') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row mt-5">
                                        <div class="col-12 col-md-12 mb-4">
                                            <label class="fw-bold">Profile Image <span class="text-danger fw-bold">*</span></label>
                                            <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                            <p class="text-muted">Maximum of 5MB</p>
                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                <input type="file" name="avatar" id="avatar" class="">
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
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <select name="position" id="position" class="form-control">
                                                    <option value="">Select Position <span class="text-danger fw-bold">*</span></option>
                                                    <?php
                                                        foreach($data['get_positions'] as $value) {
                                                            echo '<option value="'.$value->id.'">'.ucwords($value->name).'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="username" id="username" class="form-control" autocomplete="disabled" required>
                                                <label for="username">Username <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="password" name="password" id="password" class="form-control" autocomplete="disabled" required>
                                                <label for="password">Password <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="password" name="confirm-password" id="confirm-password" class="form-control" autocomplete="disabled" required>
                                                <label for="confirm-password">Confirm Password <span class="text-danger fw-bold">*</span></label>
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