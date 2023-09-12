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
                        <div class="actions mb-4 d-flex justify-content-end">
                            <a href="<?= base_url('/admin/manage/page/faculty') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small>UPDATE FACULTY MEMBER'S IMAGE</small>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('/admin/manage/page/faculty/update/image') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?= $data["get_faculty"][0]->id ?>">
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="d-block d-md-flex gap-3">
                                                <div class="user-content">
                                                    <div class="avatar-image">
                                                        <img src="<?= base_url('/assets/home/images/faculty/' . $data["get_faculty"][0]->image .'') ?>" alt="" srcset="">
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
                                <small>UPDATE FACULTY MEMBER'S INFORMATION</small>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('/admin/manage/page/faculty/update/data') ?>" method="post">
                                    <div class="row">
                                        <input type="hidden" name="id" value="<?= $data["get_faculty"][0]->id ?>">
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="firstname" id="firstname" class="form-control" autocomplete="disabled" value="<?= $data["get_faculty"][0]->first_name ?>" required>
                                                <label for="firstname">First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="lastname" id="lastname" class="form-control" autocomplete="disabled" value="<?= $data["get_faculty"][0]->last_name ?>" required>
                                                <label for="lastname">Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <select name="position" id="position" class="form-control">
                                                    <option value="">Select Position</option>
                                                    <?php
                                                        foreach($data['get_faculty_positions'] as $value) {
                                                            echo '<option value="'.$value->id.'" '.($value->id === $data["get_faculty"][0]->position_id ? 'selected' : '') .'>'.ucwords($value->position).'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" autocomplete="disabled" required><?= $data['get_faculty'][0]->description ?></textarea>
                                                <label for="description">Description</label>
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