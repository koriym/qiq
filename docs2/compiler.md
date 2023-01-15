# Compiler

Although Qiq templates use native PHP, the `{{ ... }}` syntax sugar does require
a compiling process. That process is very simple, even naive, but it does
exist:

- If a compiled template file already exists in the cache directory, and is
  newer than the source template file, the _QiqCompiler_ returns the
  already-existing compiled template file. Otherwise ...

- The _QiqCompiler_ reads the source template file, splits out the `{{ ... }}`
  tags using a regular expression, and retains them as _QiqToken_ objects.

- The _QiqCompiler_ then invokes each _QiqToken_ to get back the PHP code
  replacement for the `{{ ... }}` tag, and reassembles all the parts in order.

- The compiled template file is saved to the compiler cache directory. The same
  source template file will not be compiled again -- at least, not until it
  gets re-saved, thereby updating its timestamp, making it newer than the
  compiled version.

## Cache Path

The _QiqCompiler_ cache path by default is your
[`sys_get_temp_dir()`](https://php.net/sys_get_temp_dir) directory appended
with `/qiq`, but you can specify any path with HtmlTemplate::new():

```php
$tpl = HtmlTemplate::new(
    cachePath: '/path/to/qiqcache/'
);
```

The _QiqCompiler_ saves the compiled templates in the cache using the full path
of the source template file. For example, the cache path is `/private/tmp` and
the source template file is at `/www/site/resources/templates/foo.php`. That
means the compiled template file will be cached at:

    /private/tmp/www/site/resources/templates/foo.php

If you see compiling errors, having the full source template path as part of
the cache path will help you find the original template.

## Cache Clearing

To clear the cache, reach into the _Template_ to get the _Catalog_,
and call its `clear()` method.

```php
$tpl->getCatalog()->clear();
```
