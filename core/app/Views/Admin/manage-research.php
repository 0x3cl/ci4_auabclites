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
                    <div class="card mt-5">
                        <div class="card-header border-0 py-4">
                            <small class="tle">MANAGE RESEARCH</small>
                        </div>
                        <div class="card-body">
                            <div class="actions d-flex mb-4 justify-content-end">
                                <a href="research/add" class="btn btn-primary"><i class='bx bx-briefcase'></i> Add Research</a>
                            </div>
                            <table id="table" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Banner</th>
                                        <th>Title</th>
                                        <th>Date Posted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if(!empty($data)) {
                                            foreach($data['get_research_data'] as $value) {
                                                $title = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]+/', '', trim($value->title))));
                                                echo ' 
                                                <tr>
                                                    <td>'.$value->id.'</td>
                                                    <td>
                                                        <img src="'.base_url('/assets/home/images/research/'.$value->image.'').'">
                                                    </td>
                                                    <td>'.$value->title.'</td>
                                                    <td>'.format_timestamp_to_date($value->date_updated).'</td>
                                                    <td>
                                                        <a href="'.base_url('/research/view/'.$value->id.'/'.$title.'/') .'" class="btn my-2 d-flex justify-content-center btn-primary" target="_blank"><i class="bx bx-show" ></i> View</a>
                                                        <a href="'.base_url('/admin/manage/page/research/update/'.$value->id.'') .'" class="btn my-2 d-flex justify-content-center btn-success"><i class="bx bxs-edit" ></i> Update</a>
                                                        <a href="'.base_url('/admin/manage/page/research/delete/'.$value->id.'') .'" class="btn my-2 d-flex justify-content-center btn-danger"><i class="bx bxs-trash bx-tada" ></i> Delete</a>
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