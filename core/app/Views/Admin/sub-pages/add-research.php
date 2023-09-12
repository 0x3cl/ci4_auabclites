<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <div class="container">
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

                    ?>
                    <div class="mt-4">
                        <form action="<?= base_url('/admin/manage/page/research/add') ?>" enctype="multipart/form-data" method="post" id="form-details">
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH INFORMATION</small>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="news-form">
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="text" name="title" id="title" class="form-control" value="" autocomplete="disabled" required>
                                                <label for="title">Title</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <textarea name="abstract" id="abstract" cols="30" rows="10" class="form-control" autocomplete="disabled" required></textarea>
                                                <label for="abstract">Abstract</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-4">
                                            <div class="form-group">
                                                <textarea name="features" id="features" cols="30" rows="10" class="form-control" autocomplete="disabled" required></textarea>
                                                <label for="features">Features</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH BANNER</small>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 col-md-12 mb-4">
                                        <div class="d-flex gap-3 mt-3">
                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                <input type="file" name="banner-image" id="banner-image" class="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH IMAGES</small>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 col-md-12 mb-4">
                                        <div class="d-flex gap-3 mt-3">
                                            <div class="dropbox d-flex justify-content-center align-items-center">
                                                <input type="file" name="content-image[]" id="content-image" class="" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header border-0 py-4">
                                    <small class="tle">RESEARCH PLATFORM</small>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 col-md-12 mb-4">
                                        <select name="platform" id="platform" class="form-control">
                                            <option value="">Choose Platform</option>
                                            <?php
                                                if(!empty($data['get_platforms'])) {
                                                    foreach($data['get_platforms'] as $value) {
                                                        echo '
                                                            <option value="'.$value->id.'">'.ucwords($value->name).'</option>
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
                                    <small class="tle">RESEARCH TECHNOLOGIES</small>
                                </div>
                                <div class="card-body technologies">
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
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'">
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
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'">
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
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'">
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
                                                                        <input class="form-check-input" type="checkbox" name="technology[]" value="'.$value->id.'" id="technologies-'.$value->id.'">
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
                                <div class="card-body">
                                    <div class="col-12 col-md-12 mb-4">
                                        <select name="repo" id="repo" class="form-control mb-4">
                                            <option value="">Choose Repository or Storage</option>
                                            <?php 
                                                if(!empty($data['get_repositories'])) {
                                                    foreach($data['get_repositories'] as $value) {
                                                        echo '<option value="'.$value->id.'">'.strtoupper($value->name).'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <input type="text" name="repo-link" id="repo-link" class="form-control" placeholder="Paste link here" autocomplete="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="action d-flex justify-content-end mt-5 mb-5 w-100">
                                <button class="btn btn-primary py-3 px-4">Proceed <i class='bx bx-right-arrow-alt bx-tada' ></i></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>