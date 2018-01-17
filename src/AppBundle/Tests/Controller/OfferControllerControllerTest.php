<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OfferControllerControllerTest extends WebTestCase
{
    public function testGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/get');
    }

    public function testId()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/id');
    }

    public function testPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/post');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

}
