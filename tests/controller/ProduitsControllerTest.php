<?php

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProduitsControllerTest extends WebTestCase
{

    public function testPageProduits()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/produits');
        $this->assertSelectorTextContains('h1', 'Liste des produits');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testPageProduitsAjout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajout');
        $this->assertSelectorTextContains('h1', 'Ajouter un Produits');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
    }
}
