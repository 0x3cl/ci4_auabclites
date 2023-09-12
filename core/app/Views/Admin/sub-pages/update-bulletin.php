<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5 overview">
                    <div class="actions mt-5 d-flex justify-content-end">
                        <a href="<?= base_url('/admin/manage/page/bulletin') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                    </div>
                    <?php 
                        $flashdata = session()->getFlashData('flashdata');
                        readFlashData($flashdata);
                        $fields_data = !empty($data['get_bulletin_data']) ? $data['get_bulletin_data'][0] : '';
                        $fields_image = !empty($data['get_bulletin_images']) ? $data['get_bulletin_images'] : '';
                        $image_path = ($fields_data->category == 1) ? 'announcements' : (($fields_data->category == 2) ? 'news' : '');
                    ?>
                    <div class="mt-4">
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small class="tle">UPDATE BULLETIN</small>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('/admin/manage/page/bulletin/update/' .$fields_data->id .'') ?>" enctype="multipart/form-data" method="post" id="form-details">
                                    <div class="row" id="news-form">
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="title" id="title" class="form-control" value="<?= format_timestamp_to_date($fields_data->date_created)  ?>" autocomplete="disabled" disabled>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <select name="category" id="category" class="form-control">
                                                <option value="" selected>Choose Category</option>
                                                <option value="announcements" <?= (format_field_value($fields_data, 'category')) === '1' ? 'selected' : ''  ?>>Announcement</option>
                                                <option value="news" <?= (format_field_value($fields_data, 'category')) === '2' ? 'selected' : ''  ?>>News</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="title" id="title" class="form-control" value="<?= format_field_value($fields_data, 'title')  ?>" autocomplete="disabled" required>
                                                <label for="title">Title</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <textarea name="content" id="content" cols="30" rows="10" class="form-control" autocomplete="disabled" required><?= format_field_value($fields_data, 'content')  ?></textarea>
                                                <label for="content">Content</label>
                                            </div>
                                        </div>
                                        <div class="action d-flex justify-content-end mt-5 w-100">
                                            <input type="hidden" name="id" value="<?= $fields_data->id ?>">
                                            <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small class="tle">UPDATE BANNER IMAGE</small>
                            </div>
                            <div class="card-body">
                                <div class="col-12 col-md-12 mb-3">
                                    <form action="<?= base_url('/admin/manage/page/bulletin/update/banner/'.$fields_data->id .'') ?>" method="post" enctype="multipart/form-data" id="form-banner">
                                        <div class="d-block d-md-flex gap-3">
                                            <div class="user-content">
                                                <div class="avatar-image w-100">
                                                    <img src="<?= base_url('/assets/home/images/bulletin/' . $image_path . '/' . $fields_data->image . '') ?>" alt="" srcset="">
                                                </div>
                                            </div>
                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                <input type="hidden" name="id" value="<?= $fields_data->id; ?>">
                                                <input type="file" name="banner-image" id="banner-image" class="">
                                            </div>
                                        </div>
                                        <div class="action d-flex justify-content-end mt-5 w-100">
                                            <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php 
                            if(isset($flashdata["isNews"]) && $flashdata["isNews"] === 'true' || ($fields_data->category) == 2) {
                                echo '
                                <div class="card mb-5">
                                    <div class="card-header border-0 py-4">
                                        <small class="tle">UPDATE CONTENT IMAGES</small>
                                    </div>
                                    <div class="card-body">
                                        <form action="'.base_url('/admin/manage/page/bulletin/image/add').'" method="post" enctype="multipart/form-data" id="form-add-image">
                                            <div class="col-12 col-md-12 mb-3">
                                                <div class="d-flex gap-3 mt-3">
                                                    <div class="dropbox d-flex justify-content-center align-items-center">
                                                        <input type="hidden" name="id" value="'.$fields_data->id.'">
                                                        <input type="file" name="content-image[]" id="content-image" class="" multiple>
                                                    </div>
                                                </div>
                                                <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                                    <button class="btn btn-primary p-3"><i class="bx bxs-save" ></i> Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                ';
                            ?>
                            <form action="<?= base_url('/admin/manage/page/bulletin/image/delete') ?>" method="post" id="form-image">
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th>Images</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(empty($fields_image)) {

                                            } else {
                                                foreach($fields_image as $value) {
                                                    echo ' 
                                                    <tr>
                                                        <td>
                                                            <img src="'.base_url('/assets/home/images/bulletin/' . $image_path . '/' . $value->image . '').'"
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="#" class="btn btn-success mx-1">View</a>
                                                                <button  class="btn btn-danger mx-1" name="id" value="'.$value->image_id.'">Delete</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                            <?php
                            echo '
                                    </div>
                                </div>
                            </div>
                            ';
                                }
                            ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>