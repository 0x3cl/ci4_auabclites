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
                                <small>MANAGE SMTP</small>
                            </div>
                            <div class="card-body px-4">
                                <div class="description mb-5">
                                    <div class="alert alert-info">
                                        <div class="alert-heading d-flex align-items-center gap-2">
                                            <i class='bx bxs-info-circle'></i>
                                            <h5 class="m-0">SMTP</h5>
                                        </div>
                                        <hr>
                                        <p class="mt-3 mb-0 text-justify">SMTP, which stands for Simple Mail Transfer Protocol, is an essential component for sending emails. It operates as a structured and interactive system within your email setup, demanding specific details such as the hostname, port number, username, password, and sender's email. These details are crucial for configuring SMTP and ensuring that emails are sent successfully, much like the Admin Bulletin Board serves as a well-organized platform for efficient internal communication and information sharing among administrators and teams.</p>
                                        <div class="mt-5"><b>Note: All <span class="text-danger fw-bold">*</span> are required</b></div>
                                    </div>
                                </div>
                                <form action="<?= base_url('/admin/manage/smtp/update/data') ?>" method="post">
                                    <div class="row mt-4">
                                        <div class="col-12 col-md-4 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="port" id="port" class="form-control" autocomplete="disabled" value="<?= $data["get_smtp"][0]->port ?>" required>
                                                <label for="port">Port <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="hostname" id="hostname" class="form-control" autocomplete="disabled" value="<?= $data["get_smtp"][0]->hostname ?>" required>
                                                <label for="hostname">Host Name <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="sender" id="sender" class="form-control" autocomplete="disabled" value="<?= $data["get_smtp"][0]->sender ?>" required>
                                                <label for="sender">Sender <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="username" id="username" class="form-control" autocomplete="disabled" value="<?= $data["get_smtp"][0]->username ?>" required>
                                                <label for="username">Username <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="password" id="password" class="form-control" autocomplete="disabled" value="<?= $data["get_smtp"][0]->password ?>" required>
                                                <label for="password">Password <span class="text-danger fw-bold">*</span></label>
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