# Static Analysis

Qiq template files are easily subject to static analysis tools, such as PHPStan. Only a docblock is required to enable analysis. This docblock is what makes the _Template_ methods, helpers, and variables recognizable by the analyzer.

## Analyzing PHP Template Files

In each template file to be analyzed, add a docblock to specify a type for `$this`; it should the _Template_ class that will render the template file. Also, be sure to document each variable used in the template file. For example:

```html+php
<?php
/**
 * @var \Qiq\HtmlTemplate $this
 * @var string $foo
 */
?>
```

If your template files are PHP only, that's enough: you can run static analysis against them as they are.

## Analyzing Qiq Template Files

If your template files use Qiq code, you might write the docblock like this:

```qiq
{{ /** @var \Qiq\HtmlTemplate $this */ }}
{{ /** @var string $foo */ }}
```

However, you will need to compile the template files to PHP as a precursor to static analysis.

To do so, instantiate the _Template_ class that will render the template files, get its _Catalog_ property, and use the _Catalog_ to compile all the template files.

```php
$cachePath = '/path/to/compiled';

$tpl = \Qiq\HtmlTemplate::new(
    paths: ...,
    extension: ...,
	cachePath: $cachePath,
);

$tpl->getCatalog()->compileAll();
```

You can then run static analysis against the `$cachePath` directory of compiled template files (**not** the source template files, since they have non-analyzable Qiq code in them).

An example PHPStan configuration entry for static analysis of the compiled template files might include an entry like this:

```neon
parameters:
    paths:
        - path/to/compiled/
```

## Resolving Analysis Issues

Debugging and resolving issues revealed by static analysis is straightforward.

Because the compiled template files are saved in the `$cachePath` using the source template file path, it is easy to see which source template file contains the issue.

Further, because the compiled template code lines match the source template code lines, the reported line numbers match up as well.

From there, resolve the issue in the source template file as you would in any other PHP code.
