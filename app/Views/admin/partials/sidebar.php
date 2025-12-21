<aside class="bg-light border-end sticky-top" style="width: 250px; min-height: 100vh;">
    <div class="p-3">
        <h5 class="text-dark fw-bold mb-4">
            <i class="bi bi-list"></i> Menu
        </h5>
        <nav class="nav flex-column">
            <a href="<?= url_to("admin_posts_index") ?>"
                class="nav-link text-dark d-flex align-items-center py-2 px-3 rounded transition-all"
                style="text-decoration: none;">
                <i class="bi bi-substack me-2"></i>
                <span>Posts</span>
            </a>

            <a href="<?= url_to("admin_pages_index") ?>"
                class="nav-link text-dark d-flex align-items-center py-2 px-3 rounded transition-all"
                style="text-decoration: none;">
                <i class="bi bi-file-post me-2"></i>
                <span>Pages</span>
            </a>


        </nav>
    </div>
</aside>