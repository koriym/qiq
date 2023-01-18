# Static Analysis POC

This branch is a proof-of-concept for enabling static analysis on Qiq template files.

tl;dr:

- HelperLocator goes away in favor of a Helpers object.
- To create a helper, add a method on an extended Helpers object, and inject the extended Helpers object into the Template.
- Assigned variables are `$foo` and not `$this->foo`
- Use an intersection typehint in the template file to enable static analysis

## Differences from 1.x

### Helpers

The HelperLocator is gone; in its place is a Helpers object, which uses a ContainerInterface internally

The bundled ContainerInterface implementation is auto-wiring and lightly configurable, but it is intentionally low-powered and suitable mainly for simple objects with few dependencies.

#### Extend and Inject a Custom Helpers Object

To add a helper of your own, first extend the Helpers class ...

```php
class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;
}
```

... then use your extended Helpers when creating a Template:

```php
$tpl = Template::new(
    paths: ...,
    extension: ...,
    helpers: new MyHelpers()
);
```

#### Creating a Helper Method

Now you can add the helper method as a public function on your extended Helpers object:

```php
class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;

    public function rot13(string $$raw) : string
    {
        return str_rot13($raw);
    }
}
```

#### Creating a Helper Object

For complex helper logic, you might want to create a helper object. You can access that object via the Helpers::get() method, which retrieves the helper object from the ContainerInterface.

```php
class Rot13Helper
{
    public function __invoke(string $raw) : string
    {
        return str_rot13($raw);
    }
}

class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;

    public function rot13(string $$raw) : string
    {
        return $this->get(Rot13Helper::class)->__invoke($raw);
    }
}
```

#### Sharing Helpers

To share a set of helpers, create a trait for them, then use that trait in a helper object:

```php
trait MyHelperMethods
{
    public function rot13(string $$raw) : string
    {
        return $this->get(Rot13Helper::class)->__invoke($raw);
    }
}

class MyHelpers extends Helpers
{
    use \Qiq\Helper\Html\HtmlHelperMethods;
    use MyHelperMethods;
}
```

#### Using a Helper

Inside a template file, you then call `<?= $this->rot13('foo') ?>` (or `{{= rot13 ('foo') }}`) just as you are used to.


### Template Variables

Assigned variables are no longer addressed using `$this`. That is, when you assign `$template->setData(['bar' => 'baz'])`, the template file *used* to use ...

```html+php
<?= $this->bar ?>
```

... but now it uses:

```html+php
<?= $bar ?>
```

Assigned variables are still shared among templates by reference, so changes to an assigned variable in one template will be recognized in all other templates.

Local variables set at `render()`-time are *not* shared (this is the current behavior as well, so no changes there).

This opens up a greater chance of assigned-vs-local conflicts, e.g. using `foreach ($items as $item)` when `$item` has *also* been assigned. The foreach() will overwrite the assigned `$item` value. (With the older way, `foreach ($this->items as $item)` has almost no chance of overwriting an assigned value.)


### Static Analysis

To enable static analysis inside template files, the template file must have a `@var ... $this` hint typed to the intersection of the _Qiq\Rendering_ interface **and** the _Helpers_ object being used:

```html+php
<?php
/**
 * @var Qiq\Rendering&Qiq\Helper\Html\HtmlHelpers $this
 */
?>

<?= $this->rot13() ?>
```

You can now run static analysis on that template file, and the analyzer should recognize that `$this->rot13()` is a method on the HtmlHelpers class.

To make enable static analysis of template variables, document them in the template file:

```html+php
<?php
/**
 * @var Qiq\Rendering&MyHelpers $this
 * @var string $bar
 */
?>

<?= $this->rot13($bar) ?>
```

This works for files using Qiq `{{ ... }}` syntax as well:

```qiq
{{ /** @var Qiq\Rendering&MyHelpers $this */ }}
{{ /** @var string $bar */ }}

{{= rot13 ($bar) }}
```

However, static analysis of templates using Qiq syntax must be done against the **compiled** version of the template. That means you need to compile all the templates *before* running static analysis on them, and point the analyzer to the directory holding the compiled templates.

A `@var ... $this` typehint of that complexity might be off-putting. If so, consider extending the _Template_ class as well, overriding the constructor, and adding a `@mixin` tag pointing to the extended _Helpers_ object.

```php
/**
 * @mixin MyHelpers
 */
class MyTemplate extends \Qiq\Template
{
    public function __construct(
        Catalog $catalog,
        Compiler $compiler,
        MyHelpers $helpers
    ) {
        parent::__construct($catalog, $compiler, $helpers);
    }
}
```

Now the template file typehint can be reduced to:

```qiq
{{ /** @var MyTemplate $this */ }}
```

You may find constructor overrides to be more amenable to autowiring dependency injection as well, in that you can typehint to a specific Catalog or Compiler, and call the parent constructor thereafter.
