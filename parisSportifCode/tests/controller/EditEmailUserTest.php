<?php


namespace App\Tests\controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class EditEmailUserTest extends WebTestCase
{
    public function testProfileEditEmail()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/auth/edit/email');
        $this->assertResponseStatusCodeSame(200);
    }


    public function testLabelProfileEditEmail()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/email');
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_email[email]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_email[plainPassword]"]'));
    }


    public function testProfileEditEmailBlankInput()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/email');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_email[email]'] = 'sofiane6@gmail.com';
        $form['edit_user_email[plainPassword]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testProfileEditEmailFail()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/email');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_email[email]'] = 'sofiane6@gmail';
        $form['edit_user_email[plainPassword]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testProfileEditEmailFailPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/email');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_email[email]'] = 'sofiane16@gmail';
        $form['edit_user_email[plainPassword]'] = 'Sofiane1234567';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testProfileEditEmailValid()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/email');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_email[email]'] = 'sofiane16@gmail.com';
        $form['edit_user_email[plainPassword]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertSelectorExists('.alert-success');
    }

}