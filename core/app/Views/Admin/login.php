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
                    <a href="javascript:void(0)" data-bs-target="#recover-modal" data-bs-toggle="modal" class="text-link">Recover Account?</a>
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

<div class="modal fade" id="recover-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Forgot Password?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Calm down, take a deep breath, and remember it!</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Got It</button>
            </div>
        </div>
    </div>
</div>