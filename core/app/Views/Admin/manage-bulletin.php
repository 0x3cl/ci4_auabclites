<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class=" mx-3 pb-5">
            <hr class="mt-2">   
            <div class="container">
                <section class="mt-5">
                    <?php
                         $flashdata = session()->getFlashData('flashdata');
                         readFlashData($flashdata);
                    ?>
                    <div class="card mt-5">
                        <div class="card-header border-0 py-4">
                            <small class="tle">MANAGE BULLETIN</small>
                        </div>
                        <div class="card-body">
                            <div class="actions d-flex mb-4 justify-content-end">
                                <a href="<?= base_url('/admin/manage/page/bulletin/add') ?>" class="btn btn-primary"><i class='bx bxs-news' ></i> Add Bulletin</a>
                            </div>
                            <table id="table" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Banner</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($data)) {
                                            foreach($data['get_bulletin'] as $value) {
                                                $title = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '', trim($value->title))));
                                                $link_path = ($value->category == 1) ? 'announcement' : (($value->category == 2) ? 'news' : '');
                                                $image_path = ($value->category == 1) ? 'announcements' : (($value->category == 2) ? 'news' : '');
                                                echo ' 
                                                <tr>
                                                    <td>'.$value->id.'</td>
                                                    <td>'.format_bulletin_category($value->category).'</td>
                                                    <td>
                                                        <img src="'.base_url('/assets/home/images/bulletin/'.$image_path.'/'.$value->image.'').'">
                                                    </td>
                                                    <td>'.$value->title.'</td>
                                                    <td>
                                                        <a href="'. base_url('/bulletin/'.$link_path.'/'.$value->id.'/'.$title).'" class="btn my-2 btn-primary" target="_blank"><i class="bx bx-show" ></i> View</a>
                                                        <a href="'. base_url('/admin/manage/page/bulletin/update/'.$value->id.'').'" class="btn my-2 btn-success"><i class="bx bxs-edit" ></i> Update</a>
                                                        <a href="'. base_url('/admin/manage/page/bulletin/delete/'.$value->id.'').'" class="btn my-2 btn-danger"><i class="bx bxs-trash bx-tada" ></i> Delete</a>
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
                </section>
            </div>
        </div>
    </div>
</div>