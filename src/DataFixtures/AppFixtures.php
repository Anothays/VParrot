<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\ContactMessage;
use App\Entity\Garage;
use App\Entity\Photo;
use App\Entity\Service;
use App\Entity\Schedule;
use App\Entity\Testimonial;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->faker = Factory::create('fr_FR');
        $this->parameterBag = $parameterBag;
    }

    public function rmdirRecursive($dossier): bool {
        if (!is_dir($dossier)) {
            return false;
        }
        $contenu = scandir($dossier);
        foreach ($contenu as $fichier) {
            if ($fichier != '.' && $fichier != '..') {
                $chemin = $dossier . '/' . $fichier;
                if (is_dir($chemin)) {
                    $this->rmdirRecursive($chemin);
                } else {
                    unlink($chemin);
                }
            }
        }
        return rmdir($dossier);
    }

    public function load(ObjectManager $manager): void
    {

        // Suppression du dossier média s'il existe
        $this->rmdirRecursive($this->parameterBag->get("public_media_photos"));

        /**
         * Création d'un Schedule
         */
        $societyInfos = new Schedule();
        $societyInfos
            ->setId(1)
            ->setOpenedDays([
                "1" => "Lun : 08h00 - 12h00, 13h00 - 17h00",
                "2" => "Mar : 08h00 - 12h00, 13h00 - 17h00",
                "3" => "Mer : 10h00 - 13h00, 14h00 - 18h00",
                "4" => "Jeu : 08h00 - 12h00, 13h00 - 17h00",
                "5" => "Ven : 08h00 - 12h00, 13h00 - 17h00",
                "6" => "Sam : 10h00 - 12h00, 13h00 - 16h00",
                "7" => "Dim : fermé"
            ])
        ;
        $manager->persist($societyInfos);

        /**
         * Creation d'un garage
         */
        $garage = new Garage();
        $garage
            ->setAddress('7 avenue du vase de Soissons, 31000 Toulouse')
            ->setEmail('vincentParrot@VP.com')
            ->setPhoneNumber('0123456789')
            ->setSchedule($societyInfos)
            ->setName('Siege Social')
        ;
        $manager->persist($garage);

        /**
         * Création de l'admin
         */
        $admin = new User();
        $admin
            ->setEmail("vincentParrot@VP.com")
            ->setRoles(["ROLE_SUPER_ADMIN"])
            ->setPassword("$2y$13\$CreVardVkrC8Xxr3fed.KeRLLYxZ3Eid0FX3q.4g6ymryTiuyiLiu") // %7913%!Ya!$cnS7s2
            ->setName('Vincent')
            ->setLastName('Parrot')
            ->setGarage($garage)
        ;
        $manager->persist($admin);

        /**
         * Creation des services
         */
        $service1 = new Service();
        $service1
            ->setName('Entretien et vidange')
            ->setDescription($this->faker->text(300))
            ->setImageName('entretien_et_vidange.webp')
            ->setImageFile(new File($this->parameterBag->get('assets_images').'/services/'.'garage1.webp'))
            ->setCreatedBy($admin)
            ->setPublished(true)
            ->addGarage($garage)
            ->setPrice(100)
        ;

        $service2 = new Service();
        $service2
            ->setName('Révision')
            ->setDescription($this->faker->text(300))
            ->setImageName('Révision.webp')
            ->setImageFile(new File($this->parameterBag->get('assets_images').'/services/'.'garage2.webp'))
            ->setCreatedBy($admin)
            ->setPublished(true)
            ->addGarage($garage)
            ->setPrice(350)
        ;

        $service3 = new Service();
        $service3
            ->setName('Courroie de distribution')
            ->setDescription($this->faker->text(300))
            ->setImageName('Courroie_de_distribution.webp')
            ->setImageFile(new File($this->parameterBag->get('assets_images').'/services/'.'garage3.webp'))
            ->setCreatedBy($admin)
            ->setPublished(true)
            ->addGarage($garage)
            ->setPrice(575)
        ;

        $service4 = new Service();
        $service4
            ->setName('Pneumatiques')
            ->setDescription($this->faker->text(300))
            ->setImageName('Pneumatiques.webp')
            ->setImageFile(new File($this->parameterBag->get('assets_images').'/services/'.'garage4.webp'))
            ->setCreatedBy($admin)
            ->setPublished(true)
            ->addGarage($garage)
            ->setPrice(70)
        ;

        $service5 = new Service();
        $service5
            ->setName('Freinage - disque et/ou plaquettes')
            ->setDescription($this->faker->text(300))
            ->setImageName('freinage.webp')
            ->setImageFile(new File($this->parameterBag->get('assets_images').'/services/'.'garage5.webp'))
            ->setCreatedBy($admin)
            ->setPublished(true)
            ->addGarage($garage)
            ->setPrice(50)
        ;

        // Création du dossier media/photos/service pour stocker les images de chaque service
        mkdir($this->parameterBag->get("public_media_photos") . '/services' , 0777,true);

        // Copie des images des services du dossier assets vers média
        copy($this->parameterBag->get("assets_images") . '/services/' . $service1->getImageFile()->getFilename(), $this->parameterBag->get("public_media_photos") . '/services/' . $service1->getImageName());
        copy($this->parameterBag->get("assets_images") . '/services/' . $service2->getImageFile()->getFilename(), $this->parameterBag->get("public_media_photos") . '/services/' . $service2->getImageName());
        copy($this->parameterBag->get("assets_images") . '/services/' . $service3->getImageFile()->getFilename(), $this->parameterBag->get("public_media_photos") . '/services/' . $service3->getImageName());
        copy($this->parameterBag->get("assets_images") . '/services/' . $service4->getImageFile()->getFilename(), $this->parameterBag->get("public_media_photos") . '/services/' . $service4->getImageName());
        copy($this->parameterBag->get("assets_images") . '/services/' . $service5->getImageFile()->getFilename(), $this->parameterBag->get("public_media_photos") . '/services/' . $service5->getImageName());

        // copie des logo vers le dossier média
        copy($this->parameterBag->get("assets_images") . '/' . 'logo3.webp', $this->parameterBag->get("public_media") . '/logo3.webp');
        copy($this->parameterBag->get("assets_images") . '/' . 'logo4.webp', $this->parameterBag->get("public_media") . '/logo4.webp');


        $manager->persist($service1);
        $manager->persist($service2);
        $manager->persist($service3);
        $manager->persist($service4);
        $manager->persist($service5);

        /**
         * Création des voitures
         */
        $brands = [
            "Citroën" => ["Picasso", "C3", "C4"],
            "Peugeot" => ["208", "308", "3008"],
            "Renault" => ["Clio", "Megane", "Captur"],
            "Dacia" => ["Sandero Stepway", "Duster", "Logan"],
            "Volkswagen" => ["Golf", "Polo", "Passat"]
        ];

        foreach ($brands as $brand => $carsModels) {
            foreach ($carsModels as $carModel) {
                $immatriculation = $this->faker->randomLetter().$this->faker->randomLetter().'-'.$this->faker->randomNumber(3,true).'-'.$this->faker->randomLetter().$this->faker->randomLetter();
                $car = new Car();
                $car
                    ->setModel($carModel)
                    ->setConstructor($brand)
                    ->setLicensePlate($immatriculation)
                    ->setMileage(mt_rand(0, 200000))
                    ->setPrice(mt_rand(8000, 50000))
                    ->setRegistrationYear($this->faker->year())
                    ->setPublished(true)
                    ->setEngine($this->faker->randomKey([
                        'Essence' => 'Essence',
                        'Diesel' => 'Diesel',
                        'Électrique' => 'Électrique',
                        'Hybrid' => 'Hybrid'
                    ]))
                    ->setCreatedBy($admin)
                    ->setGarage($garage)
                ;

                // Copie des photos de voiture vers media/photos/{immatriculation}
                $photos = array_diff(scandir($this->parameterBag->get('assets_images') . "/$brand/$carModel"), ['.DS_Store']);
                foreach ($photos as $photo) {
                    if (!is_dir($photo)) {
                        $image = new Photo();
                        $image->setFilename($photo);
                        $manager->persist($image);
                        $image->setCar($car);
                        if (!is_dir($this->parameterBag->get("public_media_photos") . '/' . $car->getLicensePlate())) {
                            mkdir($this->parameterBag->get("public_media_photos") . '/' . $car->getLicensePlate(), 0777,true);
                        }
                        copy(
                            $this->parameterBag->get('assets_images') . "/". $brand . "/" . $carModel . "/" . $image->getFilename(),
                            $this->parameterBag->get("public_media_photos") . '/' . $car->getLicensePlate() . '/' . $image->getFilename()
                        );
                        $file = new File($this->parameterBag->get('public_media_photos') . '/' . $car->getLicensePlate() . '/' . $image->getFilename());
                        $image
                            ->setFile($file)
                            ->setImageSize($file->getSize())
                            ->setMimeType($file->getMimeType())
                            ->setAlt($car->getConstructor() . ' ' . $car->getModel())
                        ;
                    }
                }
                $manager->persist($car);
            }
        }

        /**
         * Création des employés
         */
        for ($i=1; $i < 5; $i++) {
            $user = new User();
            $user
                ->setPassword("$2y$13\$vTUgEfGhWNnwfSbpGLks1u95lSRJR3SI9xLwP0sAbjVoKezcc7fUm") // %7913%!ZorroEstArrive
                ->setEmail($this->faker->email())
                ->setRoles(["ROLE_USER"])
                ->setName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setGarage($garage);
            $manager->persist($user);
        }

        /**
         * Création des témoignages
         */
        for($i = 0; $i < 30; $i++) {
            $testimonial = new Testimonial();
            $testimonial
                ->setAuthor($this->faker->name())
                ->setComment($this->faker->text(255))
                ->setNote($this->faker->numberBetween(1,5))
                ->setIsApproved(random_int(0,1))
            ;
            if ($testimonial->getIsApproved()) {
                $testimonial->setApprovedBy($admin);
            }
            if (random_int(0,1)) { // le hasard détermine si le témoignage en cours est crée par un membre du garage ou non
                $testimonial->setCreatedBy($admin);
            }
            $manager->persist($testimonial);
        }

        /**
         * Creation des messages de contact
         */
        for ($i = 0; $i < 5; $i++) {
            $message = new ContactMessage();
            $message
                ->setName($this->faker->name())
                ->setLastName($this->faker->lastName())
                ->setEmail($this->faker->email())
                ->setPhone($this->faker->e164PhoneNumber())
                ->setMessage($this->faker->text(255))
                ->setSubject($this->faker->text(30))
                ->setTermsAccepted(true)
            ;
            $manager->persist($message);
        }
        $manager->flush();
    }


}

