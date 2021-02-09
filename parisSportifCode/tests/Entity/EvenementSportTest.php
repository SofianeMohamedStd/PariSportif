<?php

namespace App\Tests\Entity;

use App\Entity\EvenementSport;
use DateTime;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EvenementSportTest extends KernelTestCase
{
    private $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $kernel->boot();
        $this->validator = $kernel->getContainer()->get("validator");
    }

    /**
     * @test
     */
    public function eventInstance()
    {
        $event = new EvenementSport();
        $this->assertInstanceOf(EvenementSport::class, $event);
        $this->assertClassHasAttribute("name", EvenementSport::class);
        $this->assertClassHasAttribute("beginDate", EvenementSport::class);
        $this->assertClassHasAttribute("eventPlace", EvenementSport::class);
    }

    /**
     * @test
     * @dataProvider provideTestValidName
     * @param $name
     */
    public function testValidName($name)
    {
        $event = new EvenementSport();
        $event->setName($name);
        $errors = $this->validator->validate($event, null, "naming");
        $this->assertGreaterThanOrEqual(0, count($errors));
    }

    public function provideTestValidName(): array
    {
        return [
            ['football'],
            ['FOOTBALL'],
        ];
    }

    /**
     * @param $name
     * @dataProvider invalidTestName
     */
    public function testInvalidName($name)
    {
        $event = new EvenementSport();
        $event->setName($name);
        $errors = $this->validator->validate($event, null, "naming");
        $this->assertEquals(0, count($errors));
    }

    public function invalidTestName(): array
    {
        return [
            [''],
            ['FOOTBALL1'],
            ['football '],
            ['football football'],
        ];
    }

    /**
     * @param $beginDate
     * @dataProvider provideValidBeginDateValues
     */
    public function testValidBeginDate($beginDate)
    {
        $user = new EvenementSport();
        $user->setBeginDate($beginDate);
        $errors = $this->validator->validate($user, null, "beginDate");
        $this->assertGreaterThanOrEqual(0, count($errors));
    }

    public function provideValidBeginDateValues(): array
    {
        return [
            [DateTime::createFromFormat('Y-m-d', '2100-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2022-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2021-01-04')],
        ];
    }

    /**
     * @param $beginDate
     * @dataProvider provideInvalidBeginDateValues
     */
    public function testInvalidBeginDate($beginDate)
    {
        $user = new EvenementSport();
        $user->setBeginDate($beginDate);
        $errors = $this->validator->validate($user, null, "beginDate");
        $this->assertEquals(1, count($errors));
    }

    public function provideInvalidBeginDateValues(): array
    {
        return [
            [DateTime::createFromFormat('Y-m-d', '2008-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2002-01-04')],
            [DateTime::createFromFormat('Y-m-d', '1992-01-04')],
        ];
    }

    /**
     * @param $eventPlace
     * @dataProvider provideEventPlaceValues
     */
    public function testLieuValid($eventPlace)
    {
        $user = new EvenementSport();
        $user->setEventPlace($eventPlace);
        $errors = $this->validator->validate($user, null, "naming");
        $this->assertGreaterThanOrEqual(0, count($errors));
    }

    public function provideEventPlaceValues(): array
    {
        return [
            ['Colmar'],
            ['LYON'],
            ['BRIVE-LA-GAYADRE'],
        ];
    }

    /**
     * @param $eventPlace
     * @dataProvider provideInvalidEventPlaceValues
     */
    public function testLieuInvalid($eventPlace)
    {
        $user = new EvenementSport();
        $user->setEventPlace($eventPlace);
        $errors = $this->validator->validate($user, null, "naming");
        $this->assertGreaterThanOrEqual(0, count($errors));
    }

    public function provideInvalidEventPlaceValues(): array
    {
        return [
            ['Colmar12'],
            ['LYON '],
            ['BRIVE-LA-GAYADRE @'],
        ];
    }
}
