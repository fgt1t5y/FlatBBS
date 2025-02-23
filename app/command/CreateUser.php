<?php

namespace app\command;

use support\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUser extends Command
{
    protected static $defaultName = 'user:create';

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Username');
        $this->addArgument('email', InputArgument::REQUIRED, 'User Email');
        $this->addArgument('password', InputArgument::REQUIRED, 'User Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Db::beginTransaction();

        try {
            Db::connection('default')->table('users')->insert([
                'display_name' => $input->getArgument('username'),
                'username' => $input->getArgument('username'),
                'password' => password_hash($input->getArgument('password'), PASSWORD_DEFAULT),
                'email' => $input->getArgument('email'),
                'avatar_uri' => '0',
                'allow_login' => 1
            ]);

            Db::commit();
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            Db::rollBack();
        }

        return self::SUCCESS;
    }
}
