<?php

use Accela\Accela;

return function(Accela $accela, $_){
  $accela->addRoute("GET", "/sitemap.xml", function()use($accela){
    if(php_sapi_name() !== "cli"){
      if(defined("SERVER_LOAD_INTERVAL")){
        header("Cache-Control: max-age=" . constant("SERVER_LOAD_INTERVAL"));
      }

      header("Content-Type: application/xml");
    }

    require __DIR__ . "/views/sitemap.xml.php";
  }, true);
};
