<?php


namespace App\Tests\controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class EditPasswordUserTest extends WebTestCase
{
    public function testProfileEditPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/auth/edit/password');
        $this->assertResponseStatusCodeSame(200);
    }


    public function testLabelProfileEditPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/password');
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_password[oldPassword]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_password[plainPassword][first]"]'));
        $this->assertCount(1, $crawler->filter('form input[name="edit_user_password[plainPassword][second]"]'));
    }


    public function testProfileEditPasswordBlankInput()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/password');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_password[oldPassword]'] = '';
        $form['edit_user_password[plainPassword][first]'] = '';
        $form['edit_user_password[plainPassword][second]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testNotSamePassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/password');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['edit_user_password[oldPassword]'] = 'Sissouf123456';
        $form['edit_user_password[plainPassword][first]'] = 'Sofiane123456';
        $form['edit_user_password[plainPassword][second]'] = 'Mohammed123456';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testWrongPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/password');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();

        $form['edit_user_password[oldPassword]'] = 'wrongPassword';
        $form['edit_user_password[plainPassword][first]'] = 'Sofiane123456';
        $form['edit_user_password[plainPassword][second]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }


    public function testEditPassword()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/auth/edit/password');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();

        $form['edit_user_password[oldPassword]'] = 'Sissouf123456';
        $form['edit_user_password[plainPassword][first]'] = 'Sofiane123456';
        $form['edit_user_password[plainPassword][second]'] = 'Sofiane123456';

        $client->submit($form);
        $this->assertSelectorExists('.alert-success');
    }


}