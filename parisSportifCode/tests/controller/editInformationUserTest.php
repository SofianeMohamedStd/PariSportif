<?php

namespace App\Tests\controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class editInformationUserTest extends WebTestCase
{
    public function testProfileEditInformation()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/auth/edit/information');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testLabelProfileEditInformation()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/information');
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_rest_information[street]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_rest_information[city]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_rest_information[codePostal]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_rest_information[phone]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_rest_information[plainPassword]"]'));
    }


    public function testProfileEditInformationBlankInput()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/information');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_rest_information[street]'] = '';
        $form['edit_user_rest_information[city]'] = '';
        $form['edit_user_rest_information[codePostal]'] = '';
        $form['edit_user_rest_information[phone]'] = '0741547854';
        $form['edit_user_rest_information[plainPassword]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testProfileEditInformationFail()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/information');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_rest_information[street]'] = 'vauban';
        $form['edit_user_rest_information[city]'] = '45';
        $form['edit_user_rest_information[codePostal]'] = '68100';
        $form['edit_user_rest_information[phone]'] = '07';
        $form['edit_user_rest_information[plainPassword]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testProfileEditInformationInvalidPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/information');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_rest_information[street]'] = 'Rue vauban';
        $form['edit_user_rest_information[city]'] = 'Mulhouse';
        $form['edit_user_rest_information[codePostal]'] = '68100';
        $form['edit_user_rest_information[phone]'] = '0741547854';
        $form['edit_user_rest_information[plainPassword]'] = 'Sissouf123456';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testProfileEditValidInformation()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane16@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/information');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_rest_information[street]'] = 'Rue vauban';
        $form['edit_user_rest_information[city]'] = 'Mulhouse';
        $form['edit_user_rest_information[codePostal]'] = '68100';
        $form['edit_user_rest_information[phone]'] = '0741547854';
        $form['edit_user_rest_information[plainPassword]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertSelectorExists('.alert-success');
    }
}
