<aside>
    <!-- Recent Posts -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Recent Posts</h5>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <?php foreach ($recentPosts as $recentPost): ?>
                    <li class="list-group-item px-4 py-3">
                        <a href="<?= url_to('blog_view', $recentPost['slug']) ?>"
                            class="text-decoration-none text-dark fw-500">
                            <?= esc($recentPost['title']) ?>
                        </a>
                        <div class="text-muted small mt-1">
                            <?= date('M d, Y', strtotime($recentPost['created_at'])) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>


</aside>