<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use App\Service\CreateUserService;

class CreateUserCommand extends Command
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
          ->setName('app:create-user')
          ->setDescription('Creates a new user.')
          ->setHelp('This command allows you to create a user...')
          ->addArgument('username', InputArgument::REQUIRED, 'Username')
          ->addArgument('email', InputArgument::REQUIRED, 'Email address')
          ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $output->writeln([
        'User Creator',
        '============'
      ]);
      $params = array(
        "role" => "ROLE_EMPLOYER",
        "username" => $input->getArgument('username'),
        "email" => $input->getArgument('email'),
        "password" => $input->getArgument('password'),
        "name" => "test",
        "address" => "Putstraat 85 8",
        "postal_code" => "6043ED",
        "city" => "Sittard",
        "bio" => " ",
      );

      $user = $this->us->createUser($params);

      $output->writeln([$user]);
    }
}

?>
