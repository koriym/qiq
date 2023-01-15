# Custom Helpers

Developing a custom helper is straightforward. In essence, a helper is just a method on a _Template_ class. This approach enables static analysis with a minimum of fuss.

## Basic Implementation

However, it does mean that you must begin by extending a _Template_ class with a class of your own. That's the only way you can add new methods to a _Template_. For example:

```php
namespace Project\Presentation\ProjectTemplate;

use Qiq\HtmlTemplate;

class ProjectTemplate extends HtmlTemplate
{
}
```

Next, add a new public method on your extended _Template_ class:

```php
namespace Project\Presentation\ProjectTemplate;

use Qiq\HtmlTemplate;

class ProjectTemplate extends HtmlTemplate
{
    public function rot13(string $str) : string
    {
        return str_rot13($str);
    }
}
```

You can now use that method in any template file presented via your extended _Template_ class, whether with PHP ...

```html+php
<p><?= $this->rot13('Uryyb Jbeyq!') ?></p>
```

... or with Qiq syntax:

```qiq
<p>{{= rot13('Uryyb Jbeyq!') }}</p>
```

Either way, the output will be the same:

```html
<p>Hello World!</p>
```

## Reusing Helpers

You may wish to use the same helper method (or methods) in several different extended _Template_ classes. In that case, you can write the helper method as a Trait, then `use` it in your extended _Template_ class.

```php
namespace Project\Presentation\Helper;

trait ProjectHelpers
{
    public function rot13(string $str) : string
    {
        return str_rot13($str);
    }
}
```

```php
namespace Project\Presentation\ProjectTemplate;

use Qiq\HtmlTemplate;
use Project\Presentation\Helper\ProjectHelpers;

class ProjectTemplate extends HtmlTemplate
{
    use ProjectHelpers;
}
```

## Complex Implementations

Complex helpers, or helpers needing dependencies, should be written as classes of their own. You can then retrieve the helper object from the `$container` via the `getObject()` method, and use it in your helper method.

For example, the above `rot13` helper method might be written as a class like this ...

```php
namespace Project\Presentation\Helper;

class Rot13
{
    public function __invoke(string $str) : string
    {
        return str_rot13($str);
    }
}
```

... then addressed inside the extended _Template_ like this:

```php
namespace Project\Presentation\ProjectTemplate;

use Qiq\Template;
use Project\Presentation\Helper;

class ProjectTemplate extends Template
{
    public function rot13(string $str) : string
    {
        return $this
            ->getObject(Helper\Rot13::class)
            ->__invoke($str);
    }
}
```

Finally, this approach can be combined with a trait for reuse across multiple extended _Template_ classes:

```php
namespace Project\Presentation\Helper;

trait ProjectHelpers
{
    public function rot13(string $str) : string
    {
        return $this
            ->getObject(Rot13::class)
            ->__invoke($str);
    }
}
```

```php
namespace Project\Presentation\ProjectTemplate;

use Qiq\HtmlTemplate;
use Project\Presentation\Helper\ProjectHelpers;

class ProjectTemplate extends HtmlTemplate
{
    use ProjectHelpers;
}
```
