<?php

namespace App\Tests\Entity;

use App\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EquipeTest extends KernelTestCase
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
    public function equipeInstanceOf()
    {
        $equipe = new Equipe();
        $this->assertInstanceOf(Equipe::class, $equipe);
        $this->assertClassHasAttribute("name", Equipe::class);
    }

    /**
     * @param $name
     * @dataProvider provideNameValidEquipeValues
     */
    public function testNameValidEquipe($name)
    {
        $equipe = new Equipe();
        $equipe->setName($name);
        $errors = $this->validator->validate($equipe, null, "naming");
        $this->assertEquals(0, count($errors));
    }

    public function provideNameValidEquipeValues(): array
    {
        return [
            ['om'],
            ['PSG'],
        ];
    }

    /**
     * @param $name
     * @dataProvider provideNameInvalidEquipeValues
     */
    public function testNameInvalidEquipe($name)
    {
        $equipe = new Equipe();
        $equipe->setName($name);
        $errors = $this->validator->validate($equipe, null, "naming");
        $this->assertEquals(0, count($errors));
    }

    public function provideNameInvalidEquipeValues(): array
    {
        return [
            ['om12'],
            ['PSG '],
            [''],
        ];
    }
}
