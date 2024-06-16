## Installation

El proveedor de servicios Laravel TCPDF se puede instalar a través de [composer](http://getcomposer.org) requiriendo el paquete `weirdo/tcpdf-laravel` en el `composer.json` de su proyecto. (La instalación puede tardar un poco, porque el paquete requiere TCPDF. Lamentablemente, su carpeta .git es muy pesada)

```json
{
  "require": {
    "weirdo/tcpdf-laravel": "dev-master"
  }
}
```

Si no usa el descubrimiento automático, deberá incluir el service provider / facade en `config/app.php`.


```php
'providers' => [
  //...
  Weirdo\TCPDF\ServiceProvider::class,
]

//...

'aliases' => [
  //...
  'PDF' => Weirdo\TCPDF\Facades\TCPDF::class
]
```

Para obtener una lista de todas las funciones disponibles, consulte la [Documentación de TCPDF] (https://tcpdf.org/docs/srcdoc/)