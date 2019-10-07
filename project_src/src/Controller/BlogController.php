<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'first-post',
            'title' => 'First post'
        ],
        [
            'id' => 1,
            'slug' => 'second-post',
            'title' => 'Second post'
        ],
        [
            'id' => 3,
            'slug' => 'third-post',
            'title' => 'Third post'
        ],
    ];

    /**
     * @Route("/", name="blog_list")
     */
    public function index()
    {
        return $this->json([
            'data' => array_map(function ($item) {
                return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
            }, self::POSTS),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug)
    {
        return $this->json(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}