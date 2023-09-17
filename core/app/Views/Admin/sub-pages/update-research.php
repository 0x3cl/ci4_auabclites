<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="mx-3 pb-5">
            <div class="container">
                <hr class="mt-2">   
                <section class="mt-5 overview">
                    <div class="actions mt-5 d-flex justify-content-end">
                        <a href="<?= base_url('/admin/manage/page/research') ?>" class="btn btn-primary"><i class='bx bx-arrow-back' ></i> Go Back</a>
                    </div>
                    <?php 
                        $flashdata = session()->getFlashData('flashdata');
                        readFlashData($flashdata);
                        if(!empty($data['get_technologies'])) {
                            $frontend = array_filter($data['get_technologies'], function($var) {
                                return $var->type == 1;
                            });

                            $backend = array_filter($data['get_technologies'], function($var) {
                                return $var->type == 2;
                            });

                            $cloudStorage = array_filter($data['get_technologies'], function($var) {
                                return $var->type == 3;
                            });

                            $codeEditor = array_filter($data['get_technologies'], function($var) {
                                return $var->type == 4;
                            });
                        }

                        $tech_id = [];

                        if(!empty($data['get_research_technologies'])) {
                            foreach($data['get_research_technologies'] as $tech) {
                                $tech_id[] = $tech->technologies_id;
                            }
                        }
                        
                    ?>
                    <div class="mt-4">
                        <form action="<?= base_url('/admin/manage/page/research/update/data') ?>" enctype="multipart/form-data" method="post" id="form-details">
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4 mb-4">
                                    <small class="tle">RESEARCH INFORMATION</small>
                                </div>
                                <div class="card-bodypx-4">
                                    <div class="row" id="news-form">
                                        <input type="hidden" name="id" value="<?= $data['get_research_data'][0]->id ?>">
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="title" id="title" class="form-control" value="<?= $data['get_research_data'][0]->title?>" autocomplete="disabled" required>
                                                <label for="title">Title <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <textarea name="abstract" id="abstract" cols="30" rows="10" class="form-control pt-4" autocomplete="disabled" required><?= $data['get_research_data'][0]->abstract?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <p class="mt-2 text-muted m-0"><em>Note: Features are presented in the form of lists, with each list item appearing on its own line.</em></p>
                                            <div class="form-group mt-4">
                                                <textarea name="features" id="features" cols="30" rows="10" class="form-control pt-4" autocomplete="disabled" required><?= $data['get_research_data'][0]->features?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                          
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH PLATFORM <span class="text-danger fw-bold">*</span></small>
                                </div>
                                <div class="card-body px-4">
                                    <div class="col-12 col-md-12 mb-4">
                                        <select name="platform" id="platform" class="form-control">
                                            <option value="">Choose Platform</option>
                                            <?php
                                                if(!empty($data['get_platforms'])) {
                                                    foreach($data['get_platforms'] as $value) {
                                                        echo '
                                                        <option value="'.$value->id.'" '.(($data['get_research_data'][0]->platform_id == $value->id) ? 'selected' : '').'>'.ucwords($value->name).'</option>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH TECHNOLOGIES <span class="text-danger fw-bold">*</span></small>
                                </div>
                                <div class="card-body px-4  technologies">
                                    <div class="col-12 col-md-12 mt-4 mb-4">
                                        <div class="d-block d-md-flex gap-5">
                                            <div class="mb-3">
                                                <p>FRONT END</p>
                                                <ul class="list-inline gap-3">
                                                    <?php 
                                                        if(!empty($frontend)) {
                                                            foreach($frontend as $value) {
                                                                echo '
                                                                <li class="list-inline-">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'"
                                                                        '.((in_array($value->id, $tech_id) ? 'checked' : '')).'>
                                                                        <label class="form-check-label" for="technologies-'.$value->id.'">
                                                                            '.$value->name.'
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p>BACK END</p>
                                                <ul class="list-inline gap-3">
                                                    <?php 
                                                        if(!empty($backend)) {
                                                            foreach($backend as $value) {
                                                                echo '
                                                                <li class="list-inline-">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'" 
                                                                        '.((in_array($value->id, $tech_id) ? 'checked' : '')).'>
                                                                        <label class="form-check-label" for="technologies-'.$value->id.'">
                                                                            '.$value->name.'
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p>HOSTING / CLOUD</p>
                                                <ul class="list-inline gap-3">
                                                    <?php 
                                                        if(!empty($cloudStorage)) {
                                                            foreach($cloudStorage as $value) {
                                                                echo '
                                                                <li class="list-inline-">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'"
                                                                        '.((in_array($value->id, $tech_id) ? 'checked' : '')).'>
                                                                        <label class="form-check-label" for="technologies-'.$value->id.'">
                                                                            '.$value->name.'
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="mb-3">
                                                <p>CODE EDITOR / IDE</p>
                                                <ul class="list-inline gap-3">
                                                    <?php 
                                                        if(!empty($codeEditor)) {
                                                            foreach($codeEditor as $value) {
                                                                echo '
                                                                <li class="list-inline-">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'"
                                                                        '.((in_array($value->id, $tech_id) ? 'checked' : '')).'>
                                                                        <label class="form-check-label" for="technologies-'.$value->id.'">
                                                                            '.$value->name.'
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH REPOSITORY OR STORAGE</small>
                                </div>
                                <div class="card-body px-4">
                                    <div class="col-12 col-md-12 mb-4">
                                        <select name="repo" id="repo" class="form-control mb-4">
                                            <option value="">Choose Repository or Storage</option>
                                            <?php 
                                                if(!empty($data['get_repositories'])) {
                                                    foreach($data['get_repositories'] as $value) {
                                                        echo '<option value="'.$value->id.'" '.(($data['get_research_data'][0]->repositories_id == $value->id) ? 'selected' : '').'>'.ucwords($value->name).'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <input type="text" name="repo-link" id="repo-link" class="form-control" value="<?= $data['get_research_data'][0]->link ?>" placeholder="Paste link here">
                                    </div>
                                </div>
                            </div>
                            <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                            </div>
                        </form>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small class="tle">UPDATE RESEARCH BANNER <span class="text-danger fw-bold">*</span></small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/page/research/update/banner') ?>" method="post" enctype="multipart/form-data">
                                    <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                    <p class="text-muted">Maximum of 5MB</p>
                                    <div class="d-block d-md-flex gap-3 mt-3">
                                        <div class="user-content">
                                            <div class="avatar-image">
                                                <img src="<?= base_url('/assets/home/images/research/' .$data['get_research_data'][0]->image .'') ?>" alt="" srcset="">
                                            </div>
                                        </div>
                                        <div class="dropbox d-flex justify-content-center align-items-center">
                                            <input type="hidden" name="id" value="<?= $data['get_research_data'][0]->id ?>">
                                            <input type="file" name="banner-image" id="banner-image" class="">
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                        <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small class="tle">UPDATE RESEARCH IMAGES</small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/page/research/add/images') ?>" method="post" enctype="multipart/form-data">
                                    <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                    <p class="text-muted">Maximum of 5MB</p>
                                    <div class="d-flex gap-3 mt-3">
                                        <div class="dropbox d-flex justify-content-center align-items-center">
                                            <input type="hidden" name="id" value="<?= $data['get_research_data'][0]->id ?>">
                                            <input type="file" name="content-image[]" id="content-image" class="" multiple>
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                        <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                    </div>
                                </form>
                                <div class="my-5 pt-4">
                                    <table class="table w-100">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                    if(!empty($data['get_research_images'])) {
                                                        foreach($data['get_research_images'] as $value) {
                                                            echo '
                                                                <tr>
                                                                    <td>
                                                                        <img src="'.base_url('/assets/home/images/research/'.$value->filename.'').'" alt="">
                                                                    </td>
                                                                    <td>
                                                                        <form action="'.base_url('/admin/manage/page/research/delete/image').'" method="post">
                                                                            <div class="d-flex gap-2">
                                                                                <button type="submit" class="btn btn-success" name="id" value="'.$value->id.'"><i class="bx bx-show" ></i> View</button>
                                                                                <button type="submit" class="btn btn-danger" name="id" value="'.$value->id.'"><i class="bx bxs-trash bx-tada" ></i> Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            ';
                                                        }
                                                    }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small class="tle">UPDATE AUTHORS</small>
                            </div>
                            <div class="card-bodypx-4">
                                <form action="<?= base_url('/admin/manage/page/research/add/author') ?>" method="post" enctype="multipart/form-data">
                                    <p class="mt-2 text-muted m-0"><em>Note: Only accepts [ .jpeg .jpg .png ] image files.</em></p>
                                    <p class="text-muted">Maximum of 5MB</p>
                                    <div class="d-flex gap-3 mt-3 mb-4">
                                        <div class="dropbox d-flex justify-content-center align-items-center">
                                            <input type="hidden" name="id" value="<?= $data['get_research_data'][0]->id ?>">
                                            <input type="file" name="author-image" id="content-image">
                                        </div>
                                    </div>
                                    <div class="row">
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
                                                <textarea name="about" id="about" cols="30" rows="10" class="form-control pt-4" autocomplete="disabled" required></textarea>
                                                <label for="about">About <span class="text-danger fw-bold">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                        <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                                    </div>
                                </form>
                                <div class="my-5 pt-4">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($data['get_research_authors'])) {
                                                    foreach($data['get_research_authors'] as $value) {
                                                        echo '
                                                            <tr>
                                                                <td>
                                                                    <img src="'.base_url('/assets/home/images/authors/'.$value->image.'').'" alt="">
                                                                </td>
                                                                <td>'.$value->firstname.'</td>
                                                                <td>'.$value->lastname.'</td>
                                                                <td>
                                                                    <form action="'.base_url('/admin/manage/page/research/delete/author').'" method="post">
                                                                        <div class="d-flex gap-2">
                                                                            <button type="submit" class="btn btn-success" name="id" value="'.$value->id.'"><i class="bx bx-show" ></i> View</button>
                                                                            <button type="submit" class="btn btn-danger" name="id" value="'.$value->id.'"><i class="bx bxs-trash bx-tada" ></i> Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>