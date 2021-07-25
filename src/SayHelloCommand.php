<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class SayHelloCommand extends Command{
    
    
    public function configure( )
     {
         $this->setName('sayHello')
            ->setDescription('Offfer a Greeting for name')
            ->addArgument('name', InputArgument::OPTIONAL,'Your Name') // InputArgument::REQUIRED or OPTIONAL
            ->addOption('greeting',null,InputOption::VALUE_OPTIONAL, 'Override the defalt greetings', 'Hello');
     }


     public function execute(InputInterface $input,OutputInterface $output)
     {  
         
         // $message = 'Helo World - '.$input->getArgument('name');
        $message = sprintf('%s, %s',$input->getOption('greeting'),$input->getArgument('name'));
        $output->writeln('<comment>'.$message .'</comment>'); //<info> , 
        return 2;
     }
}