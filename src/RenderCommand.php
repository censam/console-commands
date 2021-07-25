<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class RenderCommand extends Command{
    
    
    public function configure( )
     {
         $this->setName('render')
            ->setDescription('Render some tabular data.');
     }


     public function execute(InputInterface $input,OutputInterface $output)
     {  
         $table = new Table($output);
         $table->setHeaders(['Name','Age'])
                ->setRows([
                    ['John Doe' , 30],
                    ['Jone lean' , 30],
                    ['Michael Philips' , 30]
                ])->render();


         return 1;
     }
}