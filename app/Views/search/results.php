<?php $this->extend('layout/app'); ?>

<?php $this->section('pageContent'); ?>
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Search Results</h1>
            <p class="text-muted">Found <?= count($posts); ?> result(s) for "<strong><?= esc($keyword); ?></strong>"</p>
        </div>
    </div>

    <?php if (empty($posts)): ?>
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">No results found</h4>
            <p>Try searching with different keywords.</p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-8 mb-4">
                    <div class="card h-100 overflow-hidden">
                        <?php if (!empty($post['featured_image'])): ?>
                            <div class="position-relative" style="overflow: hidden; height: 200px;">
                                <img src="<?= base_url($post['featured_image']) ?>" class="w-100 h-100" style="object-fit: cover;"
                                    alt="<?= esc($post['title']) ?>" loading="lazy">
                            </div>
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span>No image available</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= url_to('blog_view', $post['slug']) ?>">
                                    <?= esc($post['title']) ?>
                                </a>
                            </h5>
                            <p class="card-text"><?= esc($post['created_at']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>