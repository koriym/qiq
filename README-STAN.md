# Static Analysis POC

This branch is a proof-of-concept for enabling static analysis on Qiq template
files.

tl;dr:

- HelperLocator is now a ContainerInterface implementation
- You don't register helpers, you create traits for them, and `use` those traits
  inside a Template class of your own
- Assigned variables are `$foo` and not `$this->foo`
- Use docblocks in the template file to enable static analysis

## Differences from 1.x

### Helper Methods

The HelperLocator is now an implementation of ContainerInterface. This means you
can replace the HelperLocator with any ContainerInterface implementation. The
bundled HelperLocator auto-wiring and lightly configurable, but it is
intentionally low-powered and suitable mainly for simple objects with few
dependencies.

#### Creating and Using Helpers

You still have to create a helper:

```php
namespace Project\Template\Helper;

class Foo
{
    public function __invoke() : string
    {
        // ... return a string
    }
}
```

But instead of registering that helper object factory with the HelperLocator ...

```php
$helperLocator->set('foo', fn () => new \Project\Template\Helper\Foo());
```

... you create a trait that calls the helper:

```php
namespace Project\Template;

trait TemplateHelpers
{
    public function foo() : string
    {
        return $this
            ->getHelper(Helper\Foo::class)
            ->__invoke();
    }
}
```

The trait signature and the helper `__invoke()` method must be identical.

Finally, you have to `use` that trait in your own extended Template to make it
available in template files:

```php
namespace Project\Template;

class Template extends \Qiq\HtmlTemplate
{
    use TemplateHelpers;
}
```

Inside a template file, you then call `$this->foo()` as you did before.

#### Static Analysis

To enable static analysis of helpers, the template file must have a docblock
like so:

```html+php
<?php
/**
 * @var \Project|Template\Template $this
 */
?>

<?= $this->foo() ?>
```

You can now run static analysis on that template file, and the analyzer
should recognize that `$this->foo()` is a method on \Project\Template\Template
via the trait(s) used by the Template class.

### Template Variables

#### Setting and Using

Assigned variables are no longer addressed using `$this`. That is, when you
assign `$template->setData(['bar' => 'baz'])`, the template file *used* to
use ...

```html+php
<?= $this->bar ?>
```

... but now it uses:

```html+php
<?= $bar ?>
```

Assigned variables are still shared among templates by reference, so changes
to an assigned variable in one template will be recognized in all other
templates.

Local variables set at `render()`-time are *not* shared (this is the current
behavior as well, so no changes there).

This opens up a greater chance of assigned-vs-local conflicts, e.g. using
`foreach ($items as $item)` when `$item` has *also* been assigned. The foreach
() will overwrite the assigned `$item` value. (With the older way, `foreach
($this->items as $item)` has almost no chance of overwriting an assigned
value.)


#### Static Analysis

To make enable static analysis of template variables, document them in the
template file:

```html+php
<?php
/**
 * @var \Project|Template\Template $this
 * @var string $bar
 */
?>
<?= $bar ?>
```

### Template Classes

As you can see from the helpers section above, you need to `use` helpers via a
trait somehow. This means that your project-specific helpers will need a
project-specific template class. This has some drawbacks, namely that it's a
extra work with respect to the current way of doing things.

Academically speaking, this is a better approach, but it does impose a greater
burden on new users. One positive tradeoff is that it encourages users to create
function-specific template systems: one for HTML pages, one for emails, one for
other kinds of output generators, etc. These different template systems can
remain isolated from each other, not sharing state between them, using their
own template paths by default, etc.

Finally, in simple cases, you may not need either a trait or a helper object.
You can just put the helper method directly on the template class:

```php
namespace Project\Template;

namespace Project\Template;

class Template extends \Qiq\HtmlTemplate
{
    use TemplateHelpers;

    public function ezhelp() : string
    {
        // ... return a string
    }
}
```

### Compiled Templates

Static analysis of templates using Qiq `{{ ... }}` syntax must be done against
the **compiled** version of the template. That means you need to compile all
the templates *before* running static analysis on them, and point the analyzer
to the directory holding the compiled templates.
