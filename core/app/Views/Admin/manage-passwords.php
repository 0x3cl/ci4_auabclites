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
                                <small>CHANGE PASSWORD</small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/me/update/password') ?>" method="post">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?= $data["get_user_data"][0]->id ?>">
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="password" name="old-password" id="old-password" class="form-control" autocomplete="disabled" required>
                                                <label for="old-password">Old Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="password" name="new-password" id="new-password" class="form-control" autocomplete="disabled" required>
                                                <label for="new-password">New Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="password" name="confirm-password" id="confirm-password" class="form-control" autocomplete="disabled" required>
                                                <label for="confirm-password">Confirm Password</label>
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