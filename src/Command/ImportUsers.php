<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Service\CreateUserService;

class ImportUsers extends Command
{
    private $us;

    public function __construct(CreateUserService $us)
    {
        parent::__construct();
        $this->us = $us;
    }

    protected function configure()
    {
        $this
          ->setName('app:import-users')
          ->setDescription('Import users from file')
          ->setHelp('This command allows you to import users from a spreadsheet')
          ->addArgument('file', InputArgument::REQUIRED, 'File location');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $output->writeln([
        'User Import',
        '============'
      ]);
      $inputFile = $input->getArgument('file');
      $reader = IOFactory::createReaderForFile($inputFile);
      $reader->setReadDataOnly(TRUE);
      $spreadsheet = $reader->load($inputFile);
      $data = $spreadsheet->getActiveSheet()
                                ->toArray();
      $firstRow = true;
      foreach($data as $row) {
        if($firstRow) { //first row contains the column headers
          $keys = $row;
          $firstRow = false;
        } else {
          $params = array();
          $i = 0;
          foreach($row as $value) {
            $params[$keys[$i]] = $value;
            $i++;
          }
          $params["password"] = "password";
          $params["role"] = "ROLE_EMPLOYER";
          $params["bio"] = " ";
          $user = $this->us->createUser($params);
          $output->writeln([$user]);
        }
      }
    }
}

?>
