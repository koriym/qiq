{{
/**
 * @var \Qiq\Html\HtmlTemplate $this
 * @var string $foo
 */
}}
{{ foreach (['bar', 'baz', 'dib'] as $foo): }}
    {{= render('_partial', [
        'foo' => $foo,
    ]) }}
{{ endforeach }}

{{= $foo }}
