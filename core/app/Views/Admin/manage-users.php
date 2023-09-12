<div class="dashboard-wrapper my-md-0">
    <?= view('admin/templates/sidebar') ?>
    <div class="content">
        <?= view('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container overflow-hidden">
                <hr class="mt-2">   
                <section class="mt-5">
                    <div class="card">
                        <div class="card-header border-0 py-4">
                            <small>MANAGE OTHER USERS</small>
                        </div>
                        <div class="card-body">
                            <div class="container mt-3">
                                <div class="actions mb-4 d-flex justify-content-end">
                                    <a href="users/add" class="btn btn-primary"><i class='bx bx-user-plus'></i>Add User</a>
                                </div>
                                <?php 
                                    $flashdata = session()->getFlashData('flashdata');
                                    readFlashData($flashdata);
                                ?>
                                <table class="table display responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if(!empty($data['get_other_users'])) {
                                                foreach($data['get_other_users'] as $value) {
                                                    echo '
                                                    <tr>
                                                        <td>#'.$value->id.'</td>
                                                        <td>
                                                            <img class="avatar-image" src="'.base_url('/assets/admin/uploads/avatar/'.$value->image.'').'">
                                                        </td>
                                                        <td>'.$value->username.'</td>
                                                        <td>'.$value->first_name.'</td>
                                                        <td>'.$value->last_name.'</td>
                                                        <td>'.$value->position_name.'</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="'.base_url('/admin/manage/users/update/'.$value->id.'').'" class="btn btn-success"><i class="bx bxs-edit" ></i> Update</a>
                                                                <a href="'.base_url('/admin/manage/users/delete/'.$value->id.'').'" class="btn btn-danger"><i class="bx bxs-trash bx-tada"></i>Delete</a>
                                                            </div>
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
                </section>
            </div>
        </div>
    </div>
</div>