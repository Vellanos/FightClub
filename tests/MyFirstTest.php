<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class MyFirstTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testGoodLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $form = $crawler->selectButton('Connexion')->form([
            'email' => 'davidbak38@gmail.com',
            'password' => '12345678',
        ]);
        
        $this->client->submit($form);

        $this->assertResponseRedirects('/'); 
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testWrongLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
    
        $form = $crawler->selectButton('Connexion')->form([
            'email' => 'davidbak38@gmail.com',
            'password' => '123456789',
        ]);
        
        $this->client->submit($form);
    
        $this->assertResponseRedirects('/login');
    
        $crawler = $this->client->followRedirect();

        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }
    
}
