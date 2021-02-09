<?php


namespace App\Tests\controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WalletControllerTest extends WebTestCase
{
    public function testPageWallet()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);
        $client->request('GET', '/wallet');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testPageWalletAddMoney()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/wallet/add');
        $this->assertResponseStatusCodeSame(200);

    }

    public function testPageWalletWithDrawMoney()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/wallet/withdraw');
        $this->assertResponseStatusCodeSame(200);

    }

    public function testLabelPageAddMoney()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/withdraw');
        $this->assertCount(1, $crawler->filter('form input[name="add_money_wallet[credit]"]'));

    }
    public function testAddMoneyInformationBlankInput()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/add');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['add_money_wallet[credit]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testAddMoneyInformationValid()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/add');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['add_money_wallet[credit]'] = 100;

        $client->submit($form);
        $this->assertSelectorExists('.alert-success');
    }

    public function testLabelPageWithDrawMoney()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/withdraw');
        $this->assertCount(1, $crawler->filter('form input[name="add_money_wallet[credit]"]'));

    }
    public function testWithDrawMoneyInformationBlankInput()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/withdraw');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['add_money_wallet[credit]'] = '';

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testWithDrawMoneyGreathanCredit()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/withdraw');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['add_money_wallet[credit]'] = 2000;

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorExists('ul li');
    }

    public function testWithDrawMoneyInformationValid()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('sofiane6@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/wallet/withdraw');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['add_money_wallet[credit]'] = 100;

        $client->submit($form);
        $this->assertSelectorExists('.alert-success');
    }

}