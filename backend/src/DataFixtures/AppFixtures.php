<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Species;
use Faker\Factory;

class AppFixtures extends Fixture
{
    const MAX_ANIMAL=50;
    const MAX_RACE=10;
    public function load(ObjectManager $manager): void
    {
        $faker_fr = Factory::create('fr_FR');

        //Sinon api : https://techdocs.gbif.org/en/openapi/
        $url = 'https://raw.githubusercontent.com/boennemann/animals/master/words.json';
        $jsonContent = file_get_contents($url);
        $species = json_decode($jsonContent, true);
        $totalAnimal = count($species);

        $y=0;
        foreach($species as $name){
            $specie = new Species($name);
            $this->setReference('species'.$y, $specie);

            //Generate race pour chaque espèce
            $nb_race = mt_rand(0, self::MAX_RACE);
            for($nb=0; $nb<$nb_race; $nb++){
                $race = new Race($faker_fr->word());
                $this->setReference('race'.$nb, $race);
                $specie->addRace($race);
                $manager->persist($race);
            }

            $manager->persist($specie);
            $y++;
        }

        for($i=0; $i<self::MAX_ANIMAL; $i++){
            $animal = new Animal(
                $faker_fr->name(),
                mt_rand(0, 1),
                \DateTime::createFromFormat('Y-m-d', $faker_fr->date())
            );

            $animal->setSpecie($this->getReference('species'.mt_rand(0, $totalAnimal),Species::class));
            $races = $animal->getSpecie()->getRaces()->getValues();
            if(count($races)>0){
                $animal->setRace($races[0]);
            }
            
            $manager->persist($animal);
        }
        













        $manager->flush();
    }
}
