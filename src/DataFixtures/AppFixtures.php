<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use App\Entity\Schedule;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;
    private ParameterBag $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->faker = Factory::create('fr_FR');
        $this->parameterBag = $parameterBag;
    }

    public function load(ObjectManager $manager): void
    {
        $brand = [
            "Toyota" => ["Corolla", "Camry", "Rav4"],
            "Honda" => ["Civic", "Accord", "CR-V"],
            "Ford" => ["Mustang", "F-150", "Focus"],
            "Chevrolet" => ["Camaro", "Silverado", "Malibu"],
            "Peugeot" => ["208", "308", "3008"],
            "Renault" => ["Clio", "Megane", "Captur"],
            "Dacia" => ["Sandero", "Duster", "Logan"],
            "Volkswagen" => ["Golf", "Polo", "Passat"]
        ];
        $imagePaths = [
            'car10.jpg',
            'car9.jpg',
            'car8.jpg',
            'car7.jpg',
            'car6.jpg',
            'car5.jpg',
            'car4.jpg',
            'car3.jpg',
            'car2.jpg',
            'car1.jpg',
            'car0.jpg',
        ];
        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

        /**
         * Création de l'admin
         */
        $admin = new User();
        $admin
            ->setEmail("vincentParrot@VP.com")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword("$2y$13$9Jn3SGtXrdc/OzdMPVg8MeY/tg3QDaCYevSJuhDp.d/G5x8WQhm22")
            ->setName('Vincent')
            ->setLastName('Parrot')
        ;
        $manager->persist($admin);

        /**
         * Création des voitures
         */
        for ($i=1; $i <= 10; $i++) {
            $randBrand = array_rand($brand);
            $randCarKey = array_rand($brand[$randBrand]);
            $randCar = $brand[$randBrand][$randCarKey];
            $cars = new Cars();
            $cars
                ->setModel($randCar)
                ->setBrand($randBrand)
                ->setMileage(mt_rand(0, 200000))
                ->setPrice(mt_rand(8000, 50000))
                ->setRegistrationYear($this->faker->year())
                ->setImageName($imagePaths[array_rand($imagePaths)])
            ;
            $manager->persist($cars);

            /**
             * Création des employés
             */
            $user = new User();
            $user
                ->setPassword("$2y$13$9Jn3SGtXrdc/OzdMPVg8MeY/tg3QDaCYevSJuhDp.d/G5x8WQhm22")
                ->setEmail($this->faker->email())
                ->setRoles(["ROLE_USER"])
                ->setName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
            ;
            $manager->persist($user);
        }

        /**
         * Création des horaires
         */
        for ($i = 0; $i < 7; $i++) {
            $horaires = new Schedule();
            $horaires
                ->setDay($days[$i])
                ->setOpenMorningTime('8h00-12h00')
                ->setOpenAfternoonTime('14h00-17h00');
            $manager->persist($horaires);
        }



        $manager->flush();
    }
}

