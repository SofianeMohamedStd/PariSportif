<?php


namespace App\Tests\Entity;

use App\Entity\Competition;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class CompetitionTest extends KernelTestCase
{
    private ?object $validator;

    protected function setUp(): void
    {

        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    public function testInstanceOf()
    {
        $competition = new Competition();
        $this->assertInstanceOf(Competition::class, $competition);
        $this->assertClassHasAttribute("name", Competition::class);
        $this->assertClassHasAttribute("startAt", Competition::class);
        $this->assertClassHasAttribute("endAt", Competition::class);
    }


    /**
     * @param $firstname
     * @dataProvider provideInvalidNameValues
     */
    public function testInvalideNameProperty($name)
    {

        $competition = new Competition();
        $competition->setName($name);
        $errors = $this->validator->validate($competition);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provideInvalidNameValues()
    {
        return [
            [''],
            ['Jeux_'],
        ];
    }

    /**
     * @param $firstname
     * @dataProvider provideValidNameValues
     */
    public function testValidNameProperty($name)
    {

        $competition = new Competition();
        $competition->setName($name);
        $errors = $this->validator->validate($competition);
        $this->assertEquals(2, count($errors));
    }

    public function provideValidNameValues()
    {
        return [
            ['Premiere league'],
            ['Ligue 1'],
            ['Jeux Olympique de Toronto 2020'],
        ];
    }

}