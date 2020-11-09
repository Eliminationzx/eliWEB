<?php

namespace App\Providers;
use SoapClient;
use SoapParam;
use SoapFault;

class SoapClientExtendedProvider
{
    private $messages = array(); 
    private $client;
    
    public function __construct($expansion, $realmid) { 
        try { 
            $this->connect($expansion, $realmid); 
        } 
        catch (SoapFault $e) { 
            $this->addMessage($e->getMessage());
            error_clear_last();            
        } 
    } 
    
    public function connect($expansion, $realmid) {              
        $expansion = strtoupper($expansion); 
        
        $data = array( 
            'location'=> 'http://'. env('SOAP_IP_'.$expansion, '') .':'. env('SOAP_PORT_'.$expansion.'_'.$realmid, '') .'/', 
            'uri' => env('SOAP_URI_'.$expansion, ''), 
            'style' => SOAP_RPC, 
            'login' => env('SOAP_USER', ''), 
            'password' => env('SOAP_PASS', ''), 
            'keep_alive' => false 
         );        
        
        if ($data)
            $this->client = new SoapClient(NULL, $data);       
    }

    public function cmd($command) { 
        try {
            $this->client->executeCommand(new SoapParam($command, 'command')); 
        } catch (SoapFault $e) {
            $this->addMessage($e->getMessage());          
            error_clear_last();
        }
    } 

    public function addMessage($message) { 
        $this->messages[] = $message; 
    } 

    public function getMessages() { 
        return $this->messages; 
    }     
}
