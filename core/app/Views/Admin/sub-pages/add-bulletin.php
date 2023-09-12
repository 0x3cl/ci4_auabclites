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
                            <small class="tle">ADD NEW BULLETIN</small>
                        </div>
                        <div class="card-body">
                        <div class="actions mt-5 d-flex justify-content-end">
                            <a href="<?= base_url('/admin/manage/page/bulletin') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                        </div>
                        <?php 
                            $flashdata = session()->getFlashData('flashdata');
                            readFlashData($flashdata);
                            $fields = isset($flashdata['fields']) ? $flashdata['fields'] : '';
                        ?>
                        <div class="mt-4">
                            <form action="<?= base_url('/admin/manage/page/bulletin/add') ?>" enctype="multipart/form-data" method="post">
                                <div class="row" id="news-form">
                                    <div class="col-12 col-md-12 mb-3">
                                        <select name="category" id="category" class="form-control">
                                            <option value="" selected>Choose Category</option>
                                            <option value="announcements" <?= (format_field_value($fields, 'category')) === 'announcements' ? 'selected' : ''  ?>>Announcement</option>
                                            <option value="news" <?= (format_field_value($fields, 'category')) === 'news' ? 'selected' : ''  ?>>News</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-12 mb-3">
                                        <div class="form-group">
                                            <input type="text" name="title" id="title" class="form-control" value="<?= format_field_value($fields, 'title')  ?>" autocomplete="disabled" required>
                                            <label for="title">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-3">
                                        <div class="form-group">
                                            <textarea name="content" id="content" cols="30" rows="10" class="form-control" autocomplete="disabled" required><?= format_field_value($fields, 'title')  ?></textarea>
                                            <label for="content">Content</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 col-md-12 mb-3">
                                        <label class="fw-bold">Banner Image</label>
                                        <div class="d-flex gap-3 mt-2">
                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                <input type="file" name="banner-image" id="banner-image" class="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="other">
                                        <?php 
                                            if(isset($flashdata["isNews"]) && $flashdata["isNews"] === 'true') {
                                                echo '
                                                <div class="col-12 col-md-12 mb-3">
                                                    <label class="fw-bold">Content Images</label>
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
                                </div>
                                <div class="action d-flex justify-content-end mt-4 w-100">
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