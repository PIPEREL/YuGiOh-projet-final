<?php

namespace App\Service;

class ApiCardService{


    public function __construct()
    {
        
    }


    function getCards(string $name): array
  {
    $name =urlencode($name);
    $content = file_get_contents('https://db.ygoprodeck.com/api/v7/cardinfo.php?name='.$name.'&language=fr');
    return json_decode($content, true);
  }

}