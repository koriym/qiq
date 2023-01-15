### Partials

Sometimes you will want to split a single template into multiple pieces. You can
render these "partial" template pieces using the `render()` method in your main
template code.

When rendering, you can pass an array of variables to be extracted into the
local scope of the partial template. (The main `$this` _Template_ variable will
always be available regardless.)

For example, a `_list` partial template might look like this:

```html+php
<ul>
    {{ foreach ($_items as $_item): }}
    <li>{{h $_item}}</li>
    {{ endforeach }}
</ul>
```

Then in a main `browse` template, you can render the partial `list`:

```html+php
<p>My List</p>
{{= render ('_list', [
    '_items' => 'foo', 'bar', 'baz']
]) }}
```

The rendered HTML will look something like this:

```html+php
<p>My List</p>
<ul>
    <li>foo</li>
    <li>bar</li>
    <li>baz</li>
</ul>
```

* * *

TBD:

- render() vars are local, not global
- beware name conflicts
