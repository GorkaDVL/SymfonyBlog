<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\Article;
use APP\Entity\Category;
use APP\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

       $faker = \Faker\Factory::create('fr_FR'); 

       // Créer 3 catégories Fakées

       for($i = 1; $i <= 3; $i++){
           $category = new Category();
           $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category);

            //Créer entre 4 et 6 articles
            for($a = 1; $a <= mt_rand(4,6); $a++){
                $article = new Article();

                //Créer 5 paragraphes
                $content = '<p>' . join($faker->paragraphs(5), '</p><p>' . '</p>');
                
                $article->setTitle($faker->sentence())
                         ->setContent($content)
                         ->setImage($faker->imageUrl())
                         ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                         ->setCategory($category);
     
                         
                 $manager->persist($article);

                

                 //Créer des commentaire dans article
                 for($k =1; $k <= mt_rand(4, 10); $k++){
                    $comment = new Comment();

                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>' . '</p>');

                    $days = (new \DateTime())->diff($article->getCreatedAt()) ->days;

                    $comment->setAuthor($faker->name())
                            ->setContent($faker->paragraph())
                            ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                            ->setArticle($article);

                            $manager->persist($comment);        
                            

                 }
    
       }


       }
        $manager->flush();
    }
}
