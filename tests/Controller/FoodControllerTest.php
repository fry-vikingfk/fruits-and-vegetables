<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FoodControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/food');

        

        self::assertResponseIsSuccessful();

        self::assertResponseFormatSame('json');
    }
}
