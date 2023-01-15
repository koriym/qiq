# Overview

Helpers are additional template methods that generate output for you.
The _HtmlTemplate_ class provides HTML helpers via the _HtmlHelpers_ trait,
such as the `anchor` helper.

PHP syntax:

```html+php
<?= $this->anchor('http://qiqphp.com', 'Qiq for PHP') ?>
```

Qiq syntax:

```qiq
{{= anchor ('http://qiqphp.com', 'Qiq for PHP') }}
```

Both generate this HTML:

```html
<a href="http://qiqphp.com">Qiq for PHP</a>
```

The _HtmlTemplate_ comes with a comprehensive set of helpers for
[HTML](./html.md), including [forms](./forms.md). You can also create your own
[custom helpers](./custom.md).

Further, you can call any public or protected _Template_ method from the
template code. (This is because the template code is executed "inside" the
_Template_ object.) Among other things, you can set the layout, or render other
 templates, from inside any template:

```qiq
{{ setLayout ('seasonal-layout') }}

{{= render ('some/other/template') }}
```
