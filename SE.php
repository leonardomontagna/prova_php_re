<?php
require_once 'C:\Users\39388\vendor\autoload.php';//scaricare composer.exe poi da prompt 
//php composer.phar require cboden/ratchet && php composer.phar install
//poi configurare il file compose.json cercare su internet, potrebbero servire abilitare socket da php.ini

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;



class MyWebSocket implements MessageComponentInterface {
  protected $clients;
  public function __construct() {
  	 echo "Costruttore!\n";

      $this->clients = new \SplObjectStorage;
  }
  public function onOpen(ConnectionInterface $conn) {

      $this->clients->attach($conn);
      echo "New connection!\n";
  }
  public function onMessage(ConnectionInterface $from, $msg) {
    $a="Hello";
     $b="Hello ";
     if($msg=="message"){
        
              foreach ($this->clients as $client) {
               $client->send($b.$msg);
               }
            }
     else
     	foreach ($this->clients as $client) {
               $client->send($a.$msg);
               }

                
        }
     
  
  public function onClose(ConnectionInterface $conn) {
      $this->clients->detach($conn);
  }
  public function onError(ConnectionInterface $conn, \Exception $e) {
      // ... //
  }
}
$server = IoServer::factory(
      new HttpServer(
          new WsServer(
              new MyWebSocket()
          )
      ),
      5050 // porta
  );
  echo "Run!\n";
  $server->run();


   

?>