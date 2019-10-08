<?php


namespace App\Controller;

use App\Entity\BlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5}, requirements={"page": "\d+"})
     */
    public function index($page = 1)
    {
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();

        return $this->json([
            'page' => $page,
            'data' => array_map(function (BlogPost $item) {
                return $this->generateUrl('blog_by_id', ['id' => $item->getId()]);
            }, $items),
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("post", class="App\Entity\BlogPost")
     */
    public function post($post)
    {
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     */
    public function postBySlug(BlogPost $post)
    {
        return $this->json($post);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     * */
    public function add(Request $request)
    {
        /**@var Serializer $serializer*/
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
     * */
    public function delete(BlogPost $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}