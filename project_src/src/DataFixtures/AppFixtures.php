<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setAuthor('Test author');
        $blogPost->setTitle('Test blog post');
        $blogPost->setContent('Some test content for test blog post');
        $blogPost->setPublished(new \DateTime() );
        $blogPost->setSlug('test-blog-post');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
