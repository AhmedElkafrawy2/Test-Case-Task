<?php

interface HeroInterface
{

    public function getForce(): int;

    public function getImmunity(): int;

    public function getHealthPoints(): int;

    public function setHealthPoints(int $healthPoints);

}

class DamageHelper
{
    const DAMAGE_RAND_FACTOR = 0.2;

    public static function getDamage(HeroInterface $attacker, HeroInterface $defender)
    {
        if ($attacker->getForce() < $defender->getForce()) {
            return 0;
        }

        $damageBase = round(($attacker->getForce() - $defender->getForce()) / $defender->getImmunity()); // 1

        $damageFactor = $damageBase * DAMAGE_RAND_FACTOR; // 0.2
        $minDamage = $damageBase - $damageFactor; // 0.8
        $maxDamage = $damageBase + $damageFactor; // 1.2

        return mt_rand($minDamage, $maxDamage);
    }
}

class Fight
{
    public $damage;


    public function makeFight(HeroInterface $attacker, HeroInterface $defender)
    {

        $damage = DamageHelper::getDamage($attacker, $defender);

        $this->setDamage($damage);

        $defender->setHealthPoints($defender->getHealthPoints()-$this->getDamage());
    }

    public function setDamage(int $damage)
    {

        $this->damage = $damage;

    }

    public function getDamage():int
    {

        return $this->damage;

    }

}

class HeroClass implements HeroInterface{

    public $Force;
    public $Immunity;
    public $HealthPoints;

    public function getForce(): int
    {

        return $this->Force;

    }

    public function setForce(int $force){

        $this->Force = $force;

    }

    public function getImmunity(): int
    {
        return $this->Immunity;
    }

    public function setImmunity(int $immunity){

        $this->Immunity = $immunity;

    }
    public function getHealthPoints(): int
    {
        return $this->HealthPoints;
    }

    public function setHealthPoints(int $healthPoints)
    {
        $this->HealthPoints = $healthPoints;
    }
}

class FightTest extends TestCase {

    public function testMakeFight()
    {
        /*
         *  implement the test
         */

        // init the objects
        $attacker = new HeroClass();
        $defender = new HeroClass();

        $fight = new Fight();

        /*
         *  First Test Case
         *  the defender health value will not change in case the defender force in greater than the attacker force
         *
         */

        $attacker->setForce(2);

        $defender->setForce(4);
        $defender->setHealthPoints(5);

        $fight->makeFight($attacker, $defender);

        $this->assertEquals($defender->getHealthPoints(), 5);

        /*
         *  Second Test Case
         *  the attacker force in greater than the defender force
         *
         */

        $attacker->setForce(4);

        $defender->setForce(2);
        $defender->setImmunity(2);
        $defender->setHealthPoints(5);

        $fight->makeFight($attacker, $defender);

        $this->assertEquals($defender->getHealthPoints(), ( 5 - $fight->getDamage()));
    }
}