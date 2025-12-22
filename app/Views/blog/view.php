<?= $this->extend('layout/app') ?>
<?= $this->section('structuredData') ?>
<script type="application/ld+json">
    <!-- Structured Data (Schema.org) -->

    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "<?= esc($post['title']) ?>",
        "description": "<?= esc($post['meta_description']) ?>",
     "image": "<?= esc($post['featured_image']) ?>",

        "datePublished": "<?= $post['created_at'] ?>",
        "dateModified": "<?= $post['updated_at'] ?>",
        "author": {
            "@type": "Person",
            "name": "<?= esc($post['username']) ?>"
        }
    }
    </script>

<?= $this->endSection() ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote-bs5.min.css"
    integrity="sha512-rDHV59PgRefDUbMm2lSjvf0ZhXZy3wgROFyao0JxZPGho3oOuWejq/ELx0FOZJpgaE5QovVtRN65Y3rrb7JhdQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= $this->endSection() ?>

<?= $this->section('pageContent') ?>
<!-- Blog Header -->
<header class="py-5">
    <div class="container-lg">
        <h1 class="display-5 fw-bold"><?= esc($post['title']) ?></h1>
        <div class="d-flex flex-wrap gap-3 small text-muted mt-2 mb-3">
            <div class="d-flex align-items-center gap-1">
                <span><?= number_format((int) ($post['views'] ?? 0)) ?> views</span>
            </div>
            <div class="d-flex align-items-center gap-1">
                <span>📅</span>
                <span><?= date('F d, Y', strtotime($post['created_at'])) ?></span>
            </div>
            <div class="d-flex align-items-center gap-1">
                <span>✏️</span>
                <span>By <?= esc($post['username']) ?></span>
            </div>
            <?php if ($post['updated_at'] !== $post['created_at']): ?>
                <div class="d-flex align-items-center gap-1">
                    <span>🔄</span>
                    <span>Updated <?= date('F d, Y', strtotime($post['updated_at'])) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="py-5">
    <div class="container-lg">
        <div class="row g-4">
            <!-- Article -->
            <article class="col-lg-8">

                <?php if (!empty($post['featured_image'])): ?>
                    <div class="mb-4">
                        <a href="<?= base_url($post['featured_image']) ?>" target="_blank" rel="noopener">
                            <img src="<?= base_url($post['featured_image']) ?>" alt="<?= esc($post['title']) ?>"
                                class="img-fluid rounded" loading="lazy">
                        </a>
                    </div>
                <?php endif; ?>


                <!-- Content -->
                <div class="mb-5 fs-5 lh-lg">
                    <?= $post['content'] ?>
                </div>



                <!-- Tags -->
                <?php if (isset($post['tags']) && $post['tags']): ?>
                    <div class="mb-5">
                        <h3 class="mb-3">Tags</h3>
                        <div class="d-flex flex-wrap gap-2">
                            <?php
                            $tagItems = is_object($post['tags']) ? iterator_to_array($post['tags']->items()) : (is_array($post['tags']) ? $post['tags'] : []);
                            foreach ($tagItems as $tag):
                                $tagSlug = $tag->slug ?? (isset($tag['slug']) ? $tag['slug'] : str_replace(' ', '-', strtolower($tag->name ?? $tag['name'] ?? $tag)));
                                ?>
                                <a href="<?= url_to('blog_tag', $tagSlug) ?>"
                                    class="badge bg-light text-dark border text-decoration-none">
                                    <?= esc($tag->name ?? $tag['name'] ?? $tag) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>



                <!-- Author Info -->
                <div class="card border-0 bg-light p-4 mb-5">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px; font-weight: bold;">
                                <?= strtoupper(substr($post['username'], 0, 1)) ?>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="mb-1"><?= esc($post['username']) ?></h5>
                            <p class="text-muted mb-0"><?= esc($authorBio) ?></p>

                        </div>
                    </div>
                </div>


            </article>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top:100px;">
                    <?= view('partials/sidebar') ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<?= $this->endSection() ?>