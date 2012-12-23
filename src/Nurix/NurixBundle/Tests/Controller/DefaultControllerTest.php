<?php

namespace Nurix\NurixBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');

        $this->assertTrue($crawler->filter('html:contains("Main")')->count() > 0);
    }
}
