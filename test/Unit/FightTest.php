<?php


class FightTest extends \PHPUnit\Framework\TestCase {

    public function testMakeFight()
    {
        /*
         *  implement the test
         */

        // init the objects
        $attacker = new \App\Code\HeroClass();
        $defender = new \App\Code\HeroClass();

        $fight = new \App\Code\Fight();

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