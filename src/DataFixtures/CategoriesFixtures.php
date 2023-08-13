<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoriesFixtures extends Fixture
{
    private $counter = 1;
    public function load(ObjectManager $manager): void
    {
        //$parent = $this->createCategory(name: 'Informatique', manager: $manager);
        $parent = $this->createCategory('Informatique', null, $manager);

        $this->createCategory('ordinateurs', $parent, $manager);
        $this->createCategory('Ecrans', $parent, $manager);
        $this->createCategory('Souris', $parent, $manager);

        // $parent = $this->createCategory(name: 'Mode', manager: $manager);
        $parent = $this->createCategory('Mode', null, $manager);


        $this->createCategory('Hommes', $parent, $manager);
        $this->createCategory('Femmes', $parent, $manager);
        $this->createCategory('Enfants', $parent, $manager);




        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
