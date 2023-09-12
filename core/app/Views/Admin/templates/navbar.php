<nav class="navbar navbar-expand-lg pt-4 pb-3 py-md-4">
    <div class="container gap-4 gap-md-5 px-4">
        <a href="#" class="navbar-brand">Dashboard</a>
        <div class="hamburger-wrapper">
            <div class="hamburger"></div>
        </div>
        <ul class="list-unstyled d-flex align-items-center gap-5 mb-0 m-auto m-md-0 m-md-x-5">
            <li class="nav-item mx-2">
                <div class="notif">
                    <i class='bx bx-bell' ></i>
                    <span class="notif-count">10</span>
                </div>
            </li>
            <li class="nav-item mx-2">
                <div class="notif">
                    <i class='bx bx-envelope'></i>
                    <span class="notif-count">10</span>
                </div>
            </li>
            <li class="nav-item mx-2">
                <div class="dropdown">
                    <div class="navbar-profile" data-bs-toggle="dropdown">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <img src="<?= base_url('/assets/admin/uploads/avatar/' . session()->get('session_token')["image"] . '') ?>">
                            </div>
                            <div class="profile-info d-block">
                                <div class="text-single"><?= ucwords(session()->get('session_token')["first_name"] . ' ' . session()->get('session_token')["last_name"]) ?></div>
                                <div class="text-single"><?= session()->get('session_token')["username"] . '#' . session()->get('session_token')['id'] ?></div>
                            </div>
                            <span class="dropdown-toggle"></span>
                        </div>
                    </div>
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuButton1" data-bs-popper="none">
                        <li><a class="dropdown-item" href="<?= base_url('/admin/manage/me') ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/admin/signout') ?>">Sign Out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>