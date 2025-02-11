<?php

namespace App\Tests\Controller;

use App\Entity\Fruit;
use App\Enum\WeightUnitTypeEnum;
use App\Factory\FruitFactory;
use App\Service\EdibleService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Factory\VegetableFactory;

final class EdibleControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private $client;

    protected function setUp(): void
    {
        parent::setUp(); 
        $this->client = static::createClient();
        
    }

    public function testListReturnsAllEdibles(): void
    {
        FruitFactory::createMany(3);
        VegetableFactory::createMany(2);

        $this->client->request('GET', '/edible'); 

        $response = $this->client->getResponse();
        $this->assertResponseIsSuccessful();
        
        $data = json_decode($response->getContent(), true);
        $this->assertCount(5, $data['edibles']);
    }

    public function testSearchAnEdible(): void
    {
        $fruit = FruitFactory::createOne([
            'name' => 'Banana',
            'unit' => WeightUnitTypeEnum::KILOGRAMS,
            'quantity' => 2
        ]);

        $this->client->request('GET', '/edible/' . $fruit->getId());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals('Banana', $data['edible']['name']);
        $this->assertEquals('kg', $data['edible']['unit']);
        $this->assertEquals(2, $data['edible']['quantity']);
    }
}
