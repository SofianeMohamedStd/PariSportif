<?php

namespace App\Tests\Entity;

use App\Entity\Wallet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WalletTest extends KernelTestCase
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
        $wallet = new Wallet();
        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertClassHasAttribute("credit", Wallet::class);
    }


    /**
     * @dataProvider providerAddMoney
     * @param $money
     */
    public function testAddMoney($money)
    {
        $wallet = new Wallet();
        self::assertSame(0, $wallet->getCredit());
        $wallet->addToCredit($money);
        $errors = $this->validator->validate($wallet);
        $this->assertEquals(0, count($errors));
        self::assertSame((int)($money), $wallet->getCredit());
    }
    public function providerAddMoney()
    {
        return [
            [500],
            [200.99],
            [10]
        ];
    }

    /**
     * @dataProvider providerInvalidAddMoney
     * @param $money
     */
    public function testInvalidAddMoney($money)
    {
        $wallet = new Wallet();
        self::assertSame(0, $wallet->getCredit());
        $wallet->addToCredit($money);
        $errors = $this->validator->validate($wallet);
        $this->assertGreaterThanOrEqual(0, count($errors));
    }
    public function providerInvalidAddMoney()
    {
        return [
            [0],
            [501],
            [-200]
        ];
    }

    /**
     * @dataProvider providerDrawMoney
     * @param $drawMoney
     */
    public function testWithDrawMoney($drawMoney)
    {
        $wallet = new Wallet();
        $wallet->addToCredit(100);
        self::assertEquals(true, $wallet->removeFromCredit($drawMoney));
    }

    public function providerDrawMoney()
    {
        return [
          [50]
        ];
    }

    /**
     * @dataProvider providerInvalidDrawMoney
     * @param $drawMoney
     */
    public function testInvalidWithDrawMoney($drawMoney)
    {
        $wallet = new Wallet();
        $wallet->addToCredit(100);
        self::assertEquals(false, $wallet->removeFromCredit($drawMoney));
    }

    public function providerInvalidDrawMoney()
    {
        return [
            [200]
        ];
    }
}
