<?php
require_once 'Message.php';
class GuestBook{

    private $fichier;

    public function __construct(string $fichier)
    {
        $directory = dirname($fichier);
        if(!is_dir($directory)){
            mkdir($directory,true);
        }
        if(file_exists($fichier)){
            touch($fichier);
        }
        $this->fichier = $fichier;
    }

    public function addMessage(Message $message):void
    {
        file_put_contents($this->fichier, $message->toJSON() .PHP_EOL , FILE_APPEND);
    }

    public function getMessages(): array{
        $content = trim(file_get_contents($this->fichier));
        $lines = explode(PHP_EOL,$content);
        $message=[];
        foreach($lines as $line){
            $data=json_decode($line,true);
            $message[]=new Message($data['username'], $data['message'],new DateTime("@".$data['date']));
        }
        return array_reverse($message) ;
    }
}