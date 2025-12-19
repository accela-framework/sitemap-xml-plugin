# Accela sitemap.xml Plugin

sitemap.xmlを自動で出力するAccelaプラグイン。

## インストール

```bash
$ composer require accela-framework/sitemap-xml-plugin
```

### init-accela.php
```php
$accela = new Accela([
    // ...
    "plugins" => [
        "sitemap-xml" => true
    ]
]);
```
