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
use Doctrine\ORM\EntityManagerInterface;

final class EdibleControllerTest extends WebTestCase
{
    use ResetDatabase, Factories;

    private $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp(); 
        $this->client = static::createClient();
        $this->entityManager = self::$kernel->getContainer()
             ->get('doctrine')
             ->getManager();
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
        $fruit = new Fruit();
        $fruit->setName('Banana');
        $fruit->setUnit(WeightUnitTypeEnum::KILOGRAMS);
        $fruit->setQuantity(2);
        $fruit->setQuantityInGrams();

        $this->entityManager->persist($fruit);
        $this->entityManager->flush();

        $this->client->request('GET', '/edible/' . $fruit->getId());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals('Banana', $data['edible']['name']);
        $this->assertEquals('kg', $data['edible']['unit']);
        $this->assertEquals(2000, $data['edible']['quantity']);
    }

    public function testAddEdible(): void
    {
        $fruit = [
            'name' => 'Banana',
            'unit' => 'kg',
            'quantity' => 2,
            'type' => 'fruit'
        ];

        $this->client->request(
            'POST',
            '/edible', 
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            json_encode($fruit)
        );

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals('Banana', $data['edible']['name']);
        $this->assertEquals('kg', $data['edible']['unit']);
        $this->assertEquals(2000, $data['edible']['quantity']);
    }

    public function testDeleteEdible(): void
    {
        $fruit = FruitFactory::createOne([
            'name' => 'Banana',
            'unit' => WeightUnitTypeEnum::KILOGRAMS,
            'quantity' => 2
        ]);

        $fruitId = $fruit->getId();

        $this->client->request('DELETE', '/edible/' . $fruitId);

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertEquals("edible with id $fruitId deleted", $data['message']);
    }
}
