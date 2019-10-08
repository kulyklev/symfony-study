<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_admin');

        $blogPost = new BlogPost();
        $blogPost->setAuthor($user);
        $blogPost->setTitle('Test blog post');
        $blogPost->setContent('Some test content for test blog post');
        $blogPost->setPublished(new \DateTime() );
        $blogPost->setSlug('test-blog-post');

        $manager->persist($blogPost);
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('New test user');
        $user->setEmail('admin@blog.com');
        $user->setName('admin admin');
        $user->setPassword('123123123');

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
