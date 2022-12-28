{{
/**
 * @var \Qiq\Html\HtmlTemplate $this
 * @var string $foo
 */
}}
{{= render('index') }}
{{= textField(['name' => 'foo', 'value' => 'bar']) }}
{{= strtoupper($foo) }}
