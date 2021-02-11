<?php


namespace App\Tests\controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordTest extends webTestCase
{
    public function testRestPasswordPage()
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password');
        $this->assertResponseStatusCodeSame(200);

    }

    public function testSendMailForRestPassword()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/reset-password');

        $form = $crawler->filter('form')->form();

        $form['reset_password_request_form[email]'] = 'sofiane1@gmail.com';

        $client->submit($form);
        $this->assertEmailCount(1);

        $this->assertResponseRedirects('/reset-password/check-email');

    }

}