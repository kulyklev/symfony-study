<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    private function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_admin');

        for ($i = 0; $i < 10; $i++){
            $blogPost = new BlogPost();
            $blogPost->setAuthor($user);
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setContent($this->faker->realText());
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference('blog_post_' . $i, $blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('New test user');
        $user->setEmail('admin@blog.com');
        $user->setName('admin admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123123123'));

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }

    private function loadComments(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++){
            for ($j = 0; $j < rand(0, 10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);
                $comment->setAuthor($this->getReference('user_admin'));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
