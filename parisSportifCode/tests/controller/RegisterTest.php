<?php

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends WebTestCase
{

    public function testDisplayRegister()
    {
        $client = static ::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Register');
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[lastname]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[firstname]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[birthdate]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[email]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[plainPassword][first]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[plainPassword][second]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[street]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[city]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[codePostal]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="refisteruser[phone]"]'));
        $this->assertSelectorNotExists('ul li');
    }

    public function testBlankinputRegisterUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();

            $form['refisteruser[lastname]'] = '';
            $form['refisteruser[firstname]'] = 'sofiane';
            $form['refisteruser[birthdate]'] = '1994-01-04';
            $form['refisteruser[email]'] = 'sofiane@gmail.com';
            $form['refisteruser[plainPassword][first]'] = 'Sissouf123456';
            $form['refisteruser[plainPassword][second]'] = 'Sissouf123456';
            $form['refisteruser[street]'] = 'vauban';
            $form['refisteruser[city]'] = 'mulhouse';
            $form['refisteruser[codePostal]'] = '68100';
            $form['refisteruser[phone]'] = '0741547854';


        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testInvalidbirthdateRegisterUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();

            $form['refisteruser[lastname]'] = 'namoune';
            $form['refisteruser[firstname]'] = 'sofiane';
            $form['refisteruser[birthdate]'] = '2008-01-04';
            $form['refisteruser[email]'] = 'sofiane@gmail.com';
            $form['refisteruser[plainPassword][first]'] = 'Sissouf123456';
            $form['refisteruser[plainPassword][second]'] = 'Sissouf123456';
            $form['refisteruser[street]'] = 'vauban';
            $form['refisteruser[city]'] = 'mulhouse';
            $form['refisteruser[codePostal]'] = '68100';
            $form['refisteruser[phone]'] = '0741547854';


        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testAfterRegisterUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form = $buttonCrawlerNode->form();

        $form['refisteruser[lastname]'] = 'namoune';
        $form['refisteruser[firstname]'] = 'sofiane';
        $form['refisteruser[birthdate]'] = '1994-01-04';
        $form['refisteruser[email]'] = 'sofiane6@gmail.com';
        $form['refisteruser[plainPassword][first]'] = 'Sissouf123456';
        $form['refisteruser[plainPassword][second]'] = 'Sissouf123456';
        $form['refisteruser[street]'] = 'vauban';
        $form['refisteruser[city]'] = 'mulhouse';
        $form['refisteruser[codePostal]'] = '68100';
        $form['refisteruser[phone]'] = '0741547854';


        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
    }
}
