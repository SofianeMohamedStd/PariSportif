<?php

namespace App\Tests\Entity;

use App\Entity\Bet;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BetTest extends KernelTestCase
{
    private $validator;

    protected function setUp(): void
    {

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOf()
    {
        $bet = new Bet();
        $this->assertInstanceOf(Bet::class, $bet);
        $this->assertClassHasAttribute("nameBet", Bet::class);
        $this->assertClassHasAttribute("cote", Bet::class);
        $this->assertClassHasAttribute("dateBetLimit", Bet::class);
        $this->assertClassHasAttribute("resultBet", Bet::class);
    }

    /**
     * @dataProvider provierInvalidNameBet
     * @param $nameBet
     */
    public function testInvalidNameBet($nameBet)
    {
        $bet = new Bet();
        $bet->setNameBet($nameBet);
        $errors = $this->validator->validate($bet);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provierInvalidNameBet()
    {
        return [
          ['homme du match1']
        ];
    }

    /**
     * @dataProvider provierValidNameBet
     * @param $nameBet
     */
    public function testValidNameBet($nameBet)
    {
        $bet = new Bet();
        $bet->setNameBet($nameBet);
        $errors = $this->validator->validate($bet, null);
        $this->assertEquals(2, count($errors));
    }

    public function provierValidNameBet()
    {
        return [
            ['homme du match'],
            ['winner'],

        ];
    }

    /**
     * @dataProvider providerInvalidCote
     * @param $cote
     */
    public function testInvalidCote($cote)
    {
        $bet = new Bet();
        $bet ->setCote($cote);
        $errors = $this->validator->validate($bet);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function providerInvalidCote()
    {
        return [
            [1]
        ];
    }

    /**
     * @dataProvider providerValidCote
     * @param $cote
     */
    public function testValidCote($cote)
    {
        $bet = new Bet();
        $bet ->setCote($cote);
        $errors = $this->validator->validate($bet);
        $this->assertEquals(2, count($errors));
    }

    public function providerValidCote()
    {
        return [
            [2],
            [2.10]
        ];
    }
}
