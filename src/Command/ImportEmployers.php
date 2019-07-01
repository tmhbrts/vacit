<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Service\EmployerService;

class ImportEmployers extends Command
{
    private $es;

    public function __construct(EmployerService $es)
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

        $spreadsheet = $reader->load($inputFile)
                              ->getActiveSheet();

        $highestRow = $spreadsheet->getHighestRow();
        $highestCol = $spreadsheet->getHighestColumn();
        $highestColIndex = Coordinate::columnIndexFromString($highestCol);

        //the first row of the spreadsheet contains the indexes
        $index = array();
        for($i = 1; $i <= $highestColIndex; $i++) {
          $index[$i] = $spreadsheet->getCellByColumnAndRow($i, 1)
                                   ->getValue();
          $output->writeln(dump($index[$i]));
        }
        for($i = 2; $i <= $highestRow; $i++) {
          $params = array();
          for($ii = 1; $ii <= $highestColIndex; $ii++) {
            $value = $spreadsheet->getCellByColumnAndRow($ii, $i)
                                 ->getValue();
            $params[$index[$ii]] = $value;
          }
          $params["password"] = "password";
          $params["bio"] = " ";
          $employer = $this->es->createEmployer($params);
          $output->writeln(dump($params));
        }
    }
}

?>
