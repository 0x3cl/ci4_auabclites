<div class="dashboard-wrapper my-md-0">
    <?= view('admin/templates/sidebar') ?>
    <div class="content">
        <?= view('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <hr class="mt-2 mb-5">   
                <small class="tle">Manage Widgets</small>
                <form action="<?= base_url('/admin/widgets/toggle') ?>" method="post">
                    <?php 
                        $flashdata = session()->getFlashData('flashdata');
                        readFlashData($flashdata);

                        $widgets_id = [];

                        if(!empty($data['get_user_widgets'])) {
                            foreach ($data['get_user_widgets'] as $value) {
                                $widgets_id[] = $value->widget_id;
                            }
                        }
                    ?>
                    <div class="row mt-5 widgets">
                        <?php
                            if(!empty($data['get_widgets'])) {
                                foreach ($data['get_widgets'] as $value) {
                                    echo '
                                    <div class="col-12 col-md-6 col-xl-4 mb-4">
                                        <div class="card">
                                            <div class="card-header border-0 p-4">
                                                <h6 class="card-title m-0">'.$value->name.'</h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-justify">
                                                '.$value->description.'
                                                </p>
                                            </div>
                                            <div class="card-footer border-0 pb-4 ms-auto">
                                                <button class="btn btn-primary" name="id" value="'.$value->id.'" >
                                                    '.((in_array($value->id, $widgets_id)) ? '<i class="bx bx-shield-x"></i> DISABLE' : '<i class="bx bx-check-square"></i> ENABLE').'
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
