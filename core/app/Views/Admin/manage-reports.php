<div class="dashboard-wrapper my-md-0">
    <?= $this->include('admin/templates/sidebar') ?>
    <div class="content">
        <?= $this->include('admin/templates/navbar') ?>
        <div class="inner-content mx-3 pb-5">
            <div class="container">
                <section class="mt-5">
                    <div class="mt-5">
                        <?php 
                            $flashdata = session()->getFlashData('flashdata');
                            readFlashData($flashdata);
                        ?>
                        <div class="card mb-5">
                            <div class="card-header border-0 py-4">
                                <small>MANAGE REPORTS</small>
                            </div>
                            <div class="card-body px-4">
                                <form action="<?= base_url('/admin/manage/reports') ?>" method="post">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6>Site User's Report</h6>
                                            <p>
                                            This user's report provides a concise summary, 
                                            allowing users to easily view both the total number of users 
                                            and a comprehensive list of all individual users.</p>
                                            <div class="actions d-block d-md-inline-flex gap-3 mt-2">
                                                <input type="hidden" name="type" value="user-report">
                                                <a href="<?= base_url('/admin/manage/reports?type=user-report&file=csv&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> CSV</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=user-report&file=excel&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> EXCEL</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=user-report&file=text&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> TEXT</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6>Site Visitor's Report</h6>
                                            <p>
                                            This visitor's report offers a comprehensive overview, enabling users to access detailed
                                            information about all visitors, including their IP addresses and the dates of their 
                                            visits.
                                            </p>
                                            <div class="actions d-block d-md-inline-flex gap-3 mt-2">
                                                <input type="hidden" name="type" value="user-report">
                                                <a href="<?= base_url('/admin/manage/reports?type=visitor-report&file=csv&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> CSV</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=visitor-report&file=excel&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> EXCEL</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=visitor-report&file=text&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> TEXT</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6>Site Referrer's Report</h6>
                                            <p>
                                            This visitor's report offers a comprehensive overview, enabling users to access detailed
                                            information about all visitors, including their IP addresses and the dates of their 
                                            visits.
                                            </p>
                                            <div class="actions d-block d-md-inline-flex gap-3 mt-2">
                                                <input type="hidden" name="type" value="user-report">
                                                <a href="<?= base_url('/admin/manage/reports?type=referrer-report&file=csv&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> CSV</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=referrer-report&file=excel&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> EXCEL</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=referrer-report&file=text&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> TEXT</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6>Site Activty Logs Report</h6>
                                            <p>
                                            This activity logs report captures and displays a detailed record of all activities and events, providing valuable insights into the logged actions and events.
                                            </p>
                                            <div class="actions d-block d-md-inline-flex gap-3 mt-2">
                                                <input type="hidden" name="type" value="user-report">
                                                <a href="<?= base_url('/admin/manage/reports?type=log-report&file=csv&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> CSV</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=log-report&file=excel&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> EXCEL</a>
                                                <a href="<?= base_url('/admin/manage/reports?type=log-report&file=text&download=1') ?>" class="btn btn-outline-primary mb-3 justify-content-center"><i class='bx bx-download'></i> TEXT</a>
                                            </div>
                                        </div>
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