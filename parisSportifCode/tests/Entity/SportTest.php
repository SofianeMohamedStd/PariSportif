<?php

namespace App\Tests\Entity;

use App\Entity\Sport;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SportTest extends KernelTestCase
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
        $sport = new Sport();
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertClassHasAttribute("name", Sport::class);
        $this->assertClassHasAttribute("nbTeams", Sport::class);
        $this->assertClassHasAttribute("nbPlayers", Sport::class);
    }

    /**
     * @param $name
     * @dataProvider provideValidName
     */
    public function testValidName($name)
    {

        $sport = new Sport();
        $sport->setName($name);
        $errors = $this->validator->validate($sport, null, "naming");
        $this->assertEquals(0, count($errors));
    }

    public function provideValidName(): array
    {
        return [
            ['basket'],
            ['BASKET'],
            ['ski-de-fond'],
        ];
    }

    /**
     * @param $name
     * @dataProvider provideInvalidName
     */
    public function testInvalidName($name)
    {

        $sport = new Sport();
        $sport->setName($name);
        $errors = $this->validator->validate($sport, null, "naming");
        $this->assertEquals(0, count($errors));
    }

    public function provideInvalidName(): array
    {
        return [
            [''],
            ['BAS KET'],
            ['ski-de-fond qekrlgk'],
            ['basket2']
        ];
    }

    public function testValidNumberTeams()
    {
        $sport = new Sport();
        $sport->setNbTeams(2);
        $errors = $this->validator->validate($sport);
        $this->assertGreaterThanOrEqual(0, count($errors));

    }

    public function testInvalidNumberTeams()
    {
        $sport = new Sport();
        $sport->setNbTeams(-2);
        $errors = $this->validator->validate($sport);
        $this->assertGreaterThanOrEqual(1, count($errors));

    }

    public function testValidNbOfPlayers()
    {
        $sport = new Sport();
        $sport->setNbPlayers(11);
        $errors = $this->validator->validate($sport);
        $this->assertGreaterThanOrEqual(0, count($errors));
    }

    public function testInvlidNbOfPlayers()
    {
        $sport = new Sport();
        $sport->setNbPlayers(11);
        $errors = $this->validator->validate($sport);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }


}
