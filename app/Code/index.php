<?php

namespace App\Code;

interface HeroInterface
{

    public function getForce();

    public function getImmunity();

    public function getHealthPoints();

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

        $damageBase = round(($attacker->getForce() - $defender->getForce()) / $defender->getImmunity());

        $damageFactor = $damageBase * Self::DAMAGE_RAND_FACTOR;
        $minDamage = $damageBase - $damageFactor;
        $maxDamage = $damageBase + $damageFactor;

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

    public function setDamage($damage)
    {

        $this->damage = $damage;

    }

    public function getDamage()
    {

        return $this->damage;

    }

}

class HeroClass implements HeroInterface{

    public $Force;
    public $Immunity;
    public $HealthPoints;

    public function getForce()
    {

        return $this->Force;

    }

    public function setForce($force){

        $this->Force = $force;

    }

    public function getImmunity()
    {
        return $this->Immunity;
    }

    public function setImmunity($immunity){

        $this->Immunity = $immunity;

    }
    public function getHealthPoints()
    {
        return $this->HealthPoints;
    }

    public function setHealthPoints($healthPoints)
    {
        $this->HealthPoints = $healthPoints;
    }
}

