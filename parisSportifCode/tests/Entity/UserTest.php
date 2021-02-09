<?php

namespace App\Tests\Entity;

use App\Entity\User;
use DateTime;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
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
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
        $this->assertClassHasAttribute("email", User::class);
        $this->assertClassHasAttribute("password", User::class);
        $this->assertClassHasAttribute("lastname", User::class);
        $this->assertClassHasAttribute("firstname", User::class);
        $this->assertClassHasAttribute("email", User::class);
        $this->assertClassHasAttribute("birthDate", User::class);
        $this->assertClassHasAttribute("createDate", User::class);
        $this->assertClassHasAttribute("userValidationDate", User::class);
        $this->assertClassHasAttribute("userSuspended", User::class);
        $this->assertClassHasAttribute("userSuspendedDate", User::class);
        $this->assertClassHasAttribute("userDeleted", User::class);
        $this->assertClassHasAttribute("userDeletedDate", User::class);
        $this->assertClassHasAttribute("phone", User::class);
        $this->assertClassHasAttribute("street", User::class);
        $this->assertClassHasAttribute("street_number", User::class);
        $this->assertClassHasAttribute("code_postal", User::class);
        $this->assertClassHasAttribute("city", User::class);
    }
    /**
     * @dataProvider ProviderInvalidEmail
     * @param $email
     */
    public function testInvalidEmail($email)
    {
        $user = new User();

        $user->setEmail($email);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidEmail(): array
    {
        return [
            [""],
            ["namoune@"],
            ["namoune@gmailcom"],
            ["namoune.mohamedSofiane"]
        ];
    }

    /**
     * @dataProvider ProviderValidEmail
     * @param $email
     */
    public function testValidEmail($email)
    {
        $user = new User();

        $user->setEmail($email);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function ProviderValidEmail(): array
    {
        return [
            ["namoune@gmail.com"],
            ["namoune-mohammed@gmail.com"],
        ];
    }

    /**
     * @param $firstname
     * @dataProvider provideInvalidFirstnameValues
     */
    public function testInvalideFirstnameProperty($firstname)
    {

        $user = new User();
        $user->setFirstname($firstname);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provideInvalidFirstnameValues()
    {
        return [
            ['sissouf1'],
            [''],
            ['namoune_'],
            ['mohammed sofiane']
        ];
    }

    /**
     * @param $firstname
     * @dataProvider provideValidFirstnameValues
     */
    public function testValidFirstnameProperty($firstname)
    {

        $user = new User();
        $user->setFirstname($firstname);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function provideValidFirstnameValues()
    {
        return [
            ['sofiane'],
            ['MOHAMMED'],
            ['mohamed-sofiane'],
        ];
    }

    /**
     * @param $birthDate
     * @dataProvider provideInvalidBirthDateValues
     */
    public function testInvalidBirthDate($birthDate)
    {
        $user = new User();
        $user->setBirthDate($birthDate);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provideInvalidBirthDateValues()
    {
        return [
            [DateTime::createFromFormat('Y-m-d', '2008-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2010-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2004-01-04')],
        ];
    }

    /**
     * @param $birthDate
     * @dataProvider provideValidBirthDateValues
     */
    public function testValidBirthDate($birthDate)
    {
        $user = new User();
        $user->setBirthDate($birthDate);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function provideValidBirthDateValues()
    {
        return [
            [DateTime::createFromFormat('Y-m-d', '1994-01-04')],
            [DateTime::createFromFormat('Y-m-d', '1996-01-04')],
            [DateTime::createFromFormat('Y-m-d', '2000-01-04')],
        ];
    }

    /**
     * @param $password
     * @dataProvider provideInvalidPasswordValues
     */
    public function testInvalidPassword($password)
    {
        $user = new User();
        $user->setPlainPassword($password);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function provideInvalidPasswordValues()
    {
        return [
            ['sissouf'],
            ['sissouf1'],
            ['']
        ];
    }

    /**
     * @param $password
     * @dataProvider provideValidPasswordValues
     */
    public function testValidPassword($password)
    {
        $user = new User();
        $user->setPlainPassword($password);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function provideValidPasswordValues()
    {
        return [
            ['Sissouf1'],
            ['Sisssasa7'],
            ['mohAmmedsofiane3']
        ];
    }

    public function testValidate()
    {
        $user = new User();
        self::assertSame(false, $user->getUserValidation());
        $user->setUserValidation();
        self::assertSame(true, $user->getUserValidation());
    }

    public function testSuspended()
    {
        $user = new User();
        self::assertSame(false, $user->getUserSuspended());
        $user->setUserSuspended();
        self::assertSame(true, $user->getUserSuspended());
    }

    public function testDeleted()
    {
        $user = new User();
        self::assertSame(false, $user->getUserDeleted());
        $user->setUserDeleted() ;
        self::assertSame(true, $user->getUserDeleted());
    }


    public function testActivatedAccountUser()
    {
        $user = new User();
        self::assertNull($user->getUserValidationDate());
        $user->isUserValidated();
        self::assertInstanceOf(DateTimeInterface::class, $user->getUserValidationDate());
    }

    public function testSuspendedAccountUser()
    {
        $user = new User();
        self::assertNull($user->getUserSuspendedDate());
        $user->isUserSuspended();
        self::assertInstanceOf(DateTimeInterface::class, $user->getUserSuspendedDate());
    }

    public function testDeletedAccountUser()
    {
        $user = new User();
        self::assertNull($user->getUserDeletedDate());
        $user->isUserDeleted();
        self::assertInstanceOf(DateTimeInterface::class, $user->getUserDeletedDate());
    }

    /**
     * @dataProvider ProviderInvalidPhone
     * @param $phone
     */
    public function testInvalidPhone($phone)
    {
        $user = new User();

        $user->setPhone($phone);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidPhone(): array
    {
        return [
            [""],
            ["02245"],
            ["545484"],
            ["00015151651651651651"]
        ];
    }

    /**
     * @dataProvider ProviderValidPhone
     * @param $phone
     */
    public function testValidPhone($phone)
    {
        $user = new User();

        $user->setPhone($phone);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function ProviderValidPhone(): array
    {
        return [
            ["0752796749"],
            ["+33752796749"],
        ];
    }
    /**
     * @dataProvider ProviderInvalidStreet
     * @param $street
     */
    public function testInvalidStreet($street)
    {
        $user = new User();

        $user->setStreet($street);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidStreet(): array
    {
        return [
            ["vdsdsfv?"],
            ["02245"],
        ];
    }

    /**
     * @dataProvider ProviderValidStreet
     * @param $street
     */
    public function testValidStreet($street)
    {
        $user = new User();

        $user->setStreet($street);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function ProviderValidStreet(): array
    {
        return [
            ["Rue vauban"],
        ];
    }

    /**
     * @dataProvider ProviderInvalidStreetNumber
     * @param $streetNumber
     */
    public function testInvalidStreetNumber($streetNumber)
    {
        $user = new User();
        $user->setStreetNumber($streetNumber);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidStreetNumber()
    {
        return [
          ["85?"],
          ["85."],
          [".85"],
        ];
    }

    /**
     * @dataProvider ProviderValidStreetNumber
     * @param $streetNumber
     */
    public function testValidStreetNumber($streetNumber)
    {
        $user = new User();
        $user->setStreetNumber($streetNumber);
        $errors = $this->validator->validate($user);
        $this->assertEquals(9, count($errors));
    }

    public function ProviderValidStreetNumber()
    {
        return [
            [""],
            ["A"],
            ["B"],
            ["BB"]
        ];
    }

    /**
     * @dataProvider ProviderInvalidCodePostal
     * @param $codePostal
     */
    public function testInvalidCodePostal($codePostal)
    {
        $user = new User();
        $user->setCodePostal($codePostal);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidCodePostal()
    {
        return [
            [""],
            ["12"],
            ["A125"]
        ];
    }

    /**
     * @dataProvider ProviderValidCodePostal
     * @param $codePostal
     */
    public function testValidCodePostal($codePostal)
    {
        $user = new User();
        $user->setCodePostal($codePostal);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function ProviderValidCodePostal()
    {
        return [
            ["75000"],
            ["68000"],
            ["68100"]

        ];
    }

    /**
     * @dataProvider ProviderInvalidCity
     * @param $city
     */
    public function testInvalidCity($city)
    {
        $user = new User();
        $user->setCity($city);
        $errors = $this->validator->validate($user);
        $this->assertGreaterThanOrEqual(1, count($errors));
    }

    public function ProviderInvalidCity()
    {
        return [
            [""],
            ["pa_ris"],
            ["Mulhouse68"]
        ];
    }

    /**
     * @dataProvider providerValidCity
     * @param $city
     */
    public function testValidCity($city)
    {
        $user = new User();
        $user->setCity($city);
        $errors = $this->validator->validate($user);
        $this->assertEquals(8, count($errors));
    }

    public function providerValidCity()
    {
        return [
            ["Mulhouse"],
            ["marseille"],
        ];
    }
}
