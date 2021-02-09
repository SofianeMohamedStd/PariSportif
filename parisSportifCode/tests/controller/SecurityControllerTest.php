<?php

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testDisplayLogin()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Se connecter');
        $this->assertCount(1, $crawler->filter('form input[name="email"]'));
        $this->assertCount(1, $crawler->filter('form input[name="password"]'));
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadInfo()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'sofiane@gmail.com',
            'password' => 'wrongPassword'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullyLogin()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'sofiane6@gmail.com',
            'password' => 'Sissouf123456'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/auth');
    }
}
