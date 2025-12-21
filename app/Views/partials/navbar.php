<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container-lg">
        <a class="navbar-brand fw-bold" href="<?= url_to('landing_page') ?>">TheGoodOne</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= url_to('landing_page') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= url_to('landing_page') ?>#blog">Blog</a>
                </li>

                <?php if (auth()->loggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url_to('admin_dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url_to('logout') ?>">Logout</a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>