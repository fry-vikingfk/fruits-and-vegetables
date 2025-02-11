<?php

namespace App\Command;

use App\Enum\WeightUnitTypeEnum;
use App\Traits\EdibleTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:persist-json-file',
    description: 'perists the response.json file into the database',
)]
class PersistJsonFileCommand extends Command
{
    use EdibleTrait;

    const FILE_NAME = 'request.json';

    private string $projectDir;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ParameterBagInterface $params,
    )
    {
        $this->projectDir = $params->get('kernel.project_dir');
        parent::__construct();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $this->projectDir .'/' .self::FILE_NAME;

        if (!file_exists($filePath)) {
            $output->writeln('<error>JSON file not found at ' . $filePath . '</error>');
            return Command::FAILURE;
        }

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        try {
            foreach ($data as $item) {
                $edible = $this->createEdibleObject($item['type']);
                $edible->setName($item['name']);
                $edible->setUnit(WeightUnitTypeEnum::from($item['unit']));
                $edible->setQuantity($item['quantity']);
                $edible->setQuantityInGrams();
    
                $this->entityManager->persist($edible);
            }

            $this->entityManager->flush();
        
        } catch (\Throwable $th) {
            $io->error('An error occurred while persisting data. ' . $th->getMessage());
            return Command::FAILURE;    
        }

        $io->success('Data persisted successfully');

        return Command::SUCCESS;
    }
}
