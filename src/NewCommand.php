<?php namespace Acme;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\ClientInterface;
use ZipArchive;


class NewCommand extends Command{
    
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        parent::__construct();
    }


    public function configure()
     {
         $this->setName('new')
            ->setDescription('Create a new Laravel Application')
            ->addArgument('name', InputArgument::REQUIRED); // InputArgument::REQUIRED or OPTIONAL
            
     }


     public function execute(InputInterface $input,OutputInterface $output)
     {  
        
        $output->writeln('<comment>Crafting Application .... <comment>');
        //assert that the folder doesn't already exist
        $directory = getcwd().'/'. $input->getArgument('name');
        $this->assertApplicationDoesNotExist($directory,$output);

        //download nightly version of laravel
        $zipfile = $this->makeFileName();
        $this->download($zipfile)
                ->extract($zipfile,$directory)
                    ->cleanUp($zipfile);
        //extract zip file
         $output->writeln('<comment>Application Ready !!! <comment>');
        //alert the user that they are ready to go
        return 2;
     }


     private function assertApplicationDoesNotExist($diectory,OutputInterface $output)
     {
         if(is_dir($diectory)){
             $output->writeln('<error>Application Already Exists</error>');
             exit(1);
         }         
     }

     private function download($zipfile)
     {
         $response = $this->client->get('https://github.com/laravel/laravel/archive/refs/tags/v8.5.22.zip')->getBody();
         
         file_put_contents($zipfile,$response);

         return $this;
     }

     private function makeFileName()
     {
        return getcwd().'/laravel_'.md5(time().uniqid()). '.zip';
     }

     private function extract($zipfile,$directory)
     {
        $archive =  new ZipArchive;
        $archive->open($zipfile);
        $archive->extractTo($directory);
        $archive->close();

        return $this;
     }


     private function cleanUp($zipfile)
     {
        chmod($zipfile, 07777);
        @unlink($zipfile);

        return $this;
     }
}