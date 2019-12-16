<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use Faker;
use PDO;
use App\Tools\DbConnect;

class GenerateUser extends Command
{
    protected static $defaultName = 'generateUser';

    protected function configure()
    {
        $this
        ->setDescription('Generate user')
        ->setHelp('This command allows you to generate fake users')
//        ->addArgument('name', InputArgument::REQUIRED, 'Your name')
        ->addOption('repeat', 'r', InputOption::VALUE_REQUIRED, 'How many users you want', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $progressBar = new ProgressBar($output, $input->getOption('repeat'));
       $progressBar->setFormat('very_verbose_nomax');
       $progressBar->start();

       $faker = Faker\Factory::create('fr_FR');

       $db = (new DbConnect)->setDbHost();

       for ($i = 0; $i < $input->getOption('repeat'); $i++) {
           $query = $db->prepare('INSERT INTO users (created_at, updated_at, first_name, last_name, email, password) VALUES (?,?,?,?,?,?)');
           $query->execute([
              $faker->date($format = 'Y-m-d', $max = 'now') . $faker->time($format = ' H:i:s', $max = 'now'),
              $faker->date($format = 'Y-m-d', $max = 'now') . $faker->time($format = ' H:i:s', $max = 'now'),
              $faker->firstName,
              $faker->name,
              $faker->email,
              $faker->password,
           ]);
          $progressBar->advance();
        }
       $progressBar->finish();
       $output->writeln(
          "\ndone 😁"
       );
        return 1;
    }
}
