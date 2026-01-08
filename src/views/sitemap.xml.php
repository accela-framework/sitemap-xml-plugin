<?php

/**
 * @var Accela\Accela $accela
 */
$accela;

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML(Accela\capture(function()use($accela){
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php
    $pages = $accela->pageManager->all();
    usort($pages, function($x, $y) {
      return strcmp($x->path, $y->path);
    });
    $base = $accela->url;
    if(!$base){
      $base = ($_SERVER[ "HTTPS"] ?? "" === "on" ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?? "example.com";
    }
  ?>
  <?php foreach($pages as $page): ?>
  <?php if($page->path === "/404") continue; ?>
  <?php
    $vars = ["loc" => $base . ($page->staticPath ?: $page->path)];

    if($page->metaDom->getElementById("accela-sitemap-lastmod")?->textContent){
      $vars["lastmod"] = $page->metaDom->getElementById("accela-sitemap-lastmod")->textContent;
    }else{
      $suffix = preg_match("|/$|", $page->path) ? "index.html" : ".html";
      $vars["lastmod"] = date('Y-m-d', filemtime($accela->getFilePath("/pages" . $page->path . $suffix)));
    }

    if($page->metaDom->getElementById("accela-sitemap-changefreq")?->textContent){
      $vars["changefreq"] = $page->metaDom->getElementById("accela-sitemap-changefreq")->textContent;
    }

    if($page->metaDom->getElementById("accela-sitemap-priority")?->textContent){
      $vars["priority"] = $page->metaDom->getElementById("accela-sitemap-priority")->textContent;
    }
  ?>
  <url>
    <?php
      foreach($vars as $k => $v){
        echo "<{$k}>$v</{$k}>";
      }
    ?>
  </url>
  <?php endforeach; ?>
</urlset>

<?php
}));

echo $dom->saveXML();
