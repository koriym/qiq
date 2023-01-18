{{ /** @var \Qiq\TemplateFile&\Qiq\Helper\Html\HtmlHelpers $this */ }}
{{ /** @var string $foo */ }}
{{= render('index') }}
{{= textField(['name' => 'foo', 'value' => 'bar']) }}
{{= strtoupper($foo) }}
