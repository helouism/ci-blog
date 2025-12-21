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
        // Get featured posts
        $posts = $this->postModel->orderBy('created_at', 'DESC')->limit(9)->findAll();

        // Add username to each post
        foreach ($posts as &$post) {
            $post['username'] = $this->postModel->getPostAuthorUsername($post['id']);
        }

        $data = [
            'title' => 'TheGoodOne - Quality Content & Resources',
            'description' => 'Discover high-quality articles, tips, and resources for personal and professional growth. Read our latest blog posts on various topics.',
            'posts' => $posts,
        ];

        return view('home', $data);
    }

    public function about(): string
    {
        $data = [
            'title' => 'About TheGoodOne',
            'description' => 'Learn about TheGoodOne and our mission to provide quality content and resources.',
        ];

        return view('pages/about', $data);
    }
}
