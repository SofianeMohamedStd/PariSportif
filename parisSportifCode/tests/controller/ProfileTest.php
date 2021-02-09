<?php

namespace App\Tests\controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProfileTest extends WebTestCase
{
    
    public function testResponseProfile()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/auth');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testLabelProfile()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth');
        $this->assertSelectorTextContains('title', 'Hello PageContollerController!');
        $this->assertEquals(4, $crawler->filter('nav div div a.nav-item')->count());
        $this->assertSelectorTextContains('nav div div a.nav-item', 'Home');
        $this->assertSelectorTextContains('', 'Pricing');
        $this->assertSelectorTextContains('', 'Disabled');
        $this->assertEquals(4, $crawler->filter('div h6.mb-0')->count());
        $this->assertEquals(1, $crawler->filter('img')->count());
        $this->assertSelectorTextContains('h6', 'Full Name');
        $this->assertSelectorTextContains('', 'Email');
        $this->assertSelectorTextContains('', 'Phone');
        $this->assertSelectorTextContains('', 'Address');
    }


    public function testValidInformation()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth');
        $this->assertEquals(4, $crawler->filter('div h5')->count());
    }


    public function testProfileEdit()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/auth/edit');
        $this->assertResponseStatusCodeSame(200);
    }

}
