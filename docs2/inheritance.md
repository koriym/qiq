# Inheritance

Template "inheritance" is a variation of normal layouts that emphasizes the use of sections.

With a typical layout, the view is rendered first, then the layout echoes the rendered view using the `getContent()` method:

```html+php
<html>
<head>
    <title>My Site</title>
</head>
<body>

{{= getContent() }}

</body>
</html>
```

```html+php
<p>Hello {{h $name}}!</p>
```

With inheritance, the layout explicitly marks a section for the rendered view ...

```html+php
<html>
<head>
    <title>My Site</title>
</head>
<body>

{{= getSection('body') }}

</body>
</html>
```

... and the view explicitly sets the section to be used by the layout:

```html+php
{{ setSection('body') }}
    <p>Hello {{h $name }}</p>
{{ endSection() }}
```

There is nothing otherwise special about template inheritance.

As with every view and layout, any number of unique sections may be defined and populated.
