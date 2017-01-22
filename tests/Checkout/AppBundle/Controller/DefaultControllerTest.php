<?php

declare(strict_types=1);

namespace Tests\Checkout\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/checkout/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
