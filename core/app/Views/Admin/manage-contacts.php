<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5">
                    <?php 
                        $flashdata = session()->getFlashData('flashdata');
                        readFlashData($flashdata);
                    ?>
                    <div class="mt-5">
                        <div class="card">
                            <div class="card-header border-0 py-4">
                                <small class="tle">MANAGE CONTACTS</small>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('/admin/manage/page/contacts') ?>" method="post">
                                    <div class="row mt-4">
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="fb-link" id="fb-link" class="form-control" value="<?= $data['get_contacts'][0]->value; ?>" autocomplete="disabled" required>
                                                <label for="fb-link">Facebook</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="ig-link" id="ig-link" class="form-control" value="<?= $data['get_contacts'][1]->value;?>" autocomplete="disabled" required>
                                                <label for="ig-link">Instagram</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="twi-link" id="twi-link" class="form-control" value="<?= $data['get_contacts'][2]->value; ?>" autocomplete="disabled" required>
                                                <label for="twi-link">Twitter</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="email" id="email" class="form-control" value="<?= $data['get_contacts'][3]->value; ?>" autocomplete="disabled" required>
                                                <label for="email">Email</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="landline" id="landline" class="form-control" value="<?= $data['get_contacts'][4]->value; ?>" autocomplete="disabled" required>
                                                <label for="landline">Landline</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="phone" id="phone" class="form-control" value="<?= $data['get_contacts'][5]->value; ?>" autocomplete="disabled" required>
                                                <label for="phone">Phone</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <textarea name="address" id="address" class="form-control" autocomplete="disabled" required><?= $data['get_contacts'][6]->value; ?></textarea>
                                                <label for="address">Address</label>
                                            </div>
                                        </div>
                                        <div class="action d-flex justify-content-end mt-5 w-100">
                                            <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                        </div>
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