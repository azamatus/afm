<?php

namespace Nurix\CatalogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');
        //TODO: написать нормальные тесты
        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() >= 0);
    }
}
