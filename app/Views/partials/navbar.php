<nav class="navbar navbar-expand-lg bg-primary border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= base_url() ?>">TheGoodOne</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url("#blog") ?>">Blog</a>
                </li>
                <li class="nav-item">
                    <form class="d-flex gap-2" role="search" action="<?= url_to(
                        "search_results",
                    ) ?>" method="get">
                        <input name="query" class="form-control form-control" type="search"
                            placeholder="Search posts..." aria-label="Search" />
                        <button class="btn btn-primary btn-sm" type="submit">Search</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>