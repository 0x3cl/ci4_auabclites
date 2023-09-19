<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5 overview">
                    <div class="card">
                        <div class="card-header border-0 py-4">
                            <small class="tle">ADD BULLETIN</small>
                        </div>
                        <div class="card-body px-4">
                            <div class="actions mt-5 mb-5 d-flex justify-content-end">
                                <a href="<?= base_url('/admin/manage/page/bulletin') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                            </div>
                            <div class="description mb-4">
                                <div class="alert alert-info">
                                    <div class="alert-heading d-flex align-items-center gap-2">
                                        <i class='bx bxs-info-circle'></i>
                                        <h5 class="m-0">Add Bulletin</h5>
                                    </div>
                                    <hr>
                                    <p class="mt-3 mb-0 text-justify">The Admin Bulletin Board is a dynamic and organized feature within your admin panel that facilitates the efficient management and dissemination of news and announcements. It serves as a central hub where administrators can create, categorize, and publish bulletins to keep the entire team informed and engaged. This versatile tool is designed to streamline internal communication and ensure that vital information reaches the right people at the right time.</p>
                                    <div class="mt-5"><b>Note: All <span class="text-danger fw-bold">*</span> are required</b></div>
                                </div>
                            </div>
                            <?php 
                                $flashdata = session()->getFlashData('flashdata');
                                readFlashData($flashdata);
                                $fields = isset($flashdata['fields']) ? $flashdata['fields'] : '';
                            ?>
                            <div class="mt-4">
                                <form action="<?= base_url('/admin/manage/page/bulletin/add') ?>" enctype="multipart/form-data" method="post">
                                    <div class="row" id="news-form">
                                        <div class="col-12 col-md-12 mb-4">
                                            <select name="category" id="category" class="form-control" autocomplete="disabled">
                                                <option value="" selected>Choose Category  <span class="text-danger fw-bold">*</span></option>
                                                <option value="announcements" <?= (format_field_value($fields, 'category')) === 'announcements' ? 'selected' : ''  ?>>Announcement</option>
                                                <option value="news" <?= (format_field_value($fields, 'category')) === 'news' ? 'selected' : ''  ?>>News</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="title" id="title" class="form-control" value="<?= format_field_value($fields, 'title')  ?>" autocomplete="disabled" required>
                                                <label for="title">Title  <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <textarea name="content" id="editor " cols="30" rows="10" class="form-control"><?= format_field_value($fields, 'title')  ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <label class="fw-bold">Banner Image <span class="text-danger fw-bold">*</span></label>
                                            <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                            <p class="text-muted">Maximum of 5MB</p>
                                            <div class="d-flex gap-3 mt-2">
                                                <div class="dropbox d-flex justify-content-center align-items-center">
                                                    <input type="file" name="banner-image" id="banner-image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="other">
                                            <?php 
                                                if(isset($flashdata["isNews"]) && $flashdata["isNews"] === 'true') {
                                                    echo '
                                                    <div class="col-12 col-md-12 mb-4">
                                                        <label class="fw-bold">Content Images</label>
                                                        <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                                        <p class="text-muted">Maximum of 5MB</p>
                                                        <div class="d-flex gap-3 mt-2">
                                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                                <input type="file" name="content-image[]" id="content-image" class="" multiple>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ';
                                                }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="send_email mb-5">
                                            <div class="form-check d-flex align-items-start gap-2">
                                                <input class="form-check-input" type="checkbox" value="1" name="send_enail" id="send_email">
                                                <label class="form-check-label" for="send_email" style="margin-top: 1px">
                                                    Share this bulletin as a newsletter with the people who have opted to receive it via email.                                              
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-5 w-100">
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