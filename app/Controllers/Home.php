<?php

namespace App\Controllers;

use App\Models\PostModel;

class Home extends BaseController
{
    protected $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index(): string
    {
        // Get published posts ordered by creation date
        $posts = $this->postModel->where('status', 'published')->orderBy('created_at', 'DESC')->limit(9)->findAll();

        // Add username to each post
        foreach ($posts as &$post) {
            $post['username'] = $this->postModel->getPostAuthorUsername($post['id']);
        }

        $data = [
            'title' => 'TheGoodOne - Quality Content & Resources',
            'metaDescription' => 'Discover high-quality articles, tips, and resources for personal and professional growth. Read our latest blog posts on various topics.',
            'posts' => $posts,
        ];

        return view('home', $data);
    }
}
