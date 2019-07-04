<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Service\UserService;

class ImportEmployers extends Command
{
    private $us;

    public function __construct(UserService $us)
    {
        parent::__construct();
        $this->us = $us;
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
          $output->writeln(dump($params));
          $output->writeln('===============');
          $employer = $this->us->createEmployer($params);
        }
    }
}

?>
