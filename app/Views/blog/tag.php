<?= $this->extend('layout/app') ?>
<?= $this->section('structuredData') ?>
<script type="application/ld+json">

    <!-- Structured Data -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Posts tagged with <?= esc($tag->name) ?>",
        "description": "<?= esc($metaDescription) ?>",
        "url": "<?= current_url() ?>"
    }
    </script>
<?= $this->endSection() ?>
<?= $this->section('pageContent') ?>
<!-- Tag Header -->
<div class="py-4">
    <div class="container-lg">
        <h1 class="h2">Tag: <?= esc($tag->name) ?></h1>
        <p class="mb-2">Explore all posts tagged with <strong><?= esc($tag->name) ?></strong></p>
        <div class="badge bg-secondary text-white">📁 <?= count($posts) ?> post<?= count($posts) !== 1 ? 's' : '' ?>
        </div>
    </div>
</div>

<!-- Main Content -->
<main class=" py-5">

    <?php if (!empty($posts)): ?>
        <div class="row g-4 mb-5">
            <?php foreach ($posts as $post): ?>
                <div class="col-lg-4 col-md-6">
                    <?php $thumbUrl = !empty($post['featured_image']) ? base_url($post['featured_image']) : null; ?>
                    <div class="card h-100">
                        <?php if ($thumbUrl): ?>
                            <img src="<?= esc($thumbUrl, 'attr') ?>" class="card-img-top" alt="<?= esc($post['title']) ?>">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                style="height:200px;">
                                <span class="h5 text-center"><?= esc(strtoupper(substr($post['title'], 0, 3))) ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h3 class="h5 card-title mb-2">
                                <a href="<?= url_to('blog_view', $post['slug']) ?>" class="text-decoration-none text-dark">
                                    <?= esc(substr($post['title'], 0, 60) . (strlen($post['title']) > 60 ? '...' : '')) ?>
                                </a>
                            </h3>
                            <div class="text-muted small mb-2">📅 <?= date('M d, Y', strtotime($post['created_at'])) ?> • ✏️
                                <?= esc($post['username']) ?>
                            </div>
                            <p class="card-text mb-3"><?= esc($post['meta_description']) ?></p>
                            <a href="<?= url_to('blog_view', $post['slug']) ?>"
                                class="mt-auto btn btn-sm btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pager): ?>
            <nav aria-label="Page navigation">
                <?= $pager->links('default', 'bootstrap_pagination') ?>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty-state">
            <h2>No posts found</h2>
            <p>There are no posts with the tag "<?= esc($tag->name) ?>" yet.</p>
            <a href="<?= url_to('landing_page') ?>#blog" class="btn btn-primary">View All Posts</a>
        </div>
    <?php endif; ?>



</main>

<?= $this->endSection() ?>