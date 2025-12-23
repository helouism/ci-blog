<?= $this->extend("layout/app") ?>
<?= $this->section("structuredData") ?>
<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "TheGoodOne",
            "url": "<?= current_url() ?>",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "<?= url_to("search_results", "query") ?>",
               "query-input": "required minlegth=1 name=query"
            }
        }
    </script>
<?= $this->endSection() ?>


<?= $this->section("pageContent") ?>

<!-- Hero Section -->
<section class="py-5 mb-4">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Welcome to TheGoodOne</h1>
                <p class="fs-5 mb-4" style="max-width: 600px;">Discover high-quality articles, tips, and resources for
                    your personal and professional growth.
                    Explore our comprehensive blog today.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#blog" class="btn btn-light btn-lg fw-600">Read Our Blog</a>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts Section -->
<section class="py-4">
    <div class="container-lg">
        <div class="mb-4">
            <h2 class="h2 fw-bold mb-2" id="blog">Latest Articles</h2>
            <p class="text-muted">Discover our most recent insights and in-depth guides</p>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="row g-4 mb-5">
                <?php foreach ($posts as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <?php $thumbUrl = !empty($post["featured_image"])
                            ? base_url($post["featured_image"])
                            : null; ?>
                        <div class="card h-100">
                            <?php if ($thumbUrl): ?>
                                <img src="<?= esc($thumbUrl, 'attr') ?>" class="card-img-top" alt="<?= esc($post["title"]) ?>">
                            <?php else: ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                    style="height:200px;">
                                    <span class="h5 text-center"><?= esc(strtoupper(substr($post["title"], 0, 3))) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5 card-title mb-2">
                                    <a href="<?= url_to("blog_view", $post["slug"]) ?>" class="text-decoration-none text-dark">
                                        <?= esc(substr($post["title"], 0, 60) . (strlen($post["title"]) > 60 ? "..." : "")) ?>
                                    </a>
                                </h3>
                                <div class="text-muted small mb-2">
                                    📅 <?= date("M d, Y", strtotime($post["created_at"])) ?> • ✏️
                                    <?= esc($post["username"]) ?>
                                </div>
                                <p class="card-text mb-3">
                                    <?= esc($post["meta_description"]) ?>
                                </p>
                                <a href="<?= url_to("blog_view", $post["slug"]) ?>"
                                    class="mt-auto btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                <strong>No posts yet.</strong> Check back soon for our latest articles!
            </div>
        <?php endif; ?>


    </div>
</section>


<?= $this->endSection() ?>
<?= $this->section("pageScripts") ?>
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
<?= $this->endSection() ?>