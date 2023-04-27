<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CategorieControllerTest extends WebTestCase
{
    public function testPageCategorie()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajoutCategorie  ');
        $this->assertSelectorTextContains('h1', 'Ajouter une Categorie');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
