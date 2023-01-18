{{
/**
 * @var \Qiq\TemplateFile&\Qiq\Helper\Html\HtmlHelpers $this
 * @var string $foo
 */
}}
{{ foreach (['bar', 'baz', 'dib'] as $foo): }}
    {{= render('_partial', [
        'foo' => $foo,
    ]) }}
{{ endforeach }}

{{= $foo }}
