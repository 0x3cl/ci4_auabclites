<div class="container">
    <div class="login-wrapper my-5 my-md-0">
        <div class="login-content">
            <div class="login-label mb-5">
                <h1>Admin Portal</h1>
                <p>Please sign in to continue...</p>
            </div>
            
            <?php 
                $flashdata = session()->getFlashData('flashdata');
                readFlashData($flashdata);
            ?>
            
            <form action="<?= base_url('/admin/login') ?>" method="post">
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control mb-3" autocomplete="disabled" required>
                    <label for="username">Username or Email</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control mb-3" autocomplete="disabled" required>
                    <label for="password">Password</label>
                </div>
                <div class="options d-flex justify-content-end">
                    <a href="<?= base_url('/admin/recover') ?>" class="text-link">Recover Account?</a>
                </div>
                <div class="action-button mt-4 d-flex justify-content-end gap-2">
                    <div class="w-100">
                        <button type="submit" id="btn-login" class="btn btn-primary btn-standard btn-icon right w-100">Login <i class='bx bx-right-arrow-alt bx-fade-right'></i></button>
                        <div class="divider">
                            <span class="overlay">Or</span>
                        </div>
                        <a href="<?= base_url('/') ?>" id="btn-home"  class="btn btn-outline-primary btn-standard w-100 "> Return Home</a>
                    </div>
                </div>
            </form>
            <div class="login-footer w-100">
                <ul class="list-unstyled d-flex justify-content-center align-items-center gap-3 mb-0">
                    <li class="list-unstyled">
                        <a href="#" class="text-link">Terms of use</a>
                    </li>
                    <div class="divider"></div>
                    <li class="list-unstyled">
                        <a href="#" class="text-link">Privacy policy</a>
                    </li>
                </ul>
                <div class="author">
                    <p>Made with &hearts; by Carl Llemos</p>
                </div>
            </div>
        </div>
    </div>
</div>