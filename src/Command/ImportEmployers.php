<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Service\CreateEmployerService;

class ImportEmployers extends Command
{
    private $es;

    public function __construct(CreateEmployerService $es)
    {
        parent::__construct();
        $this->es = $es;
    }

    protected function configure()
    {
        $this
          ->setName('app:import-employers')
          ->setDescription('Import employers from file')
          ->setHelp('This command allows you to import employers from a spreadsheet')
          ->addArgument('file', InputArgument::REQUIRED, 'File location');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $output->writeln([
        'Employer Import',
        '==============='
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
          $params["bio"] = " ";
          $user = $this->es->createEmployer($params);
          $output->writeln([$user]);
        }
      }
    }
}

?>
