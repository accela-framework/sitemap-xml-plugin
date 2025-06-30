<?php

namespace Accela\SitemapXMLPlugin;
use Accela\Accela;

function load(){
  Accela::addPlugin("sitemap", __DIR__ . "/");
}
