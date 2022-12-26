# Custom Helpers

Developing a custom helper is straightforward: write a class for it, register
it with the _HelperLocator_, then use it in a template.

## The Helper Class

To write a helper, extend the _Helper_ class, and implement the `__invoke
()` method with whatever parameters you like. Have it return a string that has
been appropriately escaped.

Here is a helper to ROT-13 a string:

```php
namespace My\Helper;

use Qiq\HtmlHelper;

class Rot13 extends HtmlHelper
{
    public function __invoke(string $str) : string
    {
        return $this->escape->h(str_rot13($str));
    }
}
```

## The Helper Locator

Now that you have the helper class, you will need to register a callable factory
for it in the _HelperLocator_. (Registering a callable factory allows
the _HelperLocator_ to lazy-load the helper only when it is called.)  The
registration key will be the Qiq helper name, or the PHP `$this` helper method,
you use for that helper in a template.

```php
$tpl = Template::new(...);

$helperLocator = $tpl->getHelperLocator();

$helperLocator->set(
    'rotOneThree',
    function () use ($helperLocator) {
        return new \My\Helper\Rot13($helperLocator->escape());
    }
);
```

Note that you need to construct _Helper_ classes with the _Escape_ instance
already in the _HelperLocator_.

## Use The Helper

Now you can use the helper in template, either as Qiq code ...

```
<p>{{= rotOneThree ('Uryyb Jbeyq!') }}</p>
```

... or as PHP:

```html+php
<p><?= $this->rotOneThree('Uryyb Jbeyq!') ?></p>
```

Either way, the output will be the same:

```html
<p>Hello World!</p>
```
