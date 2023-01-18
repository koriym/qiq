{{
/**
 * @var \Qiq\TemplateFile&\Qiq\Helper\Html\HtmlHelpers $this
 */
}}
{{= hasSection('main') ? 'true' : 'false' }}

{{ setSection('main') }}
{{= 'foo' }}
{{ endSection() }}

{{ hasSection('main') ? 'true' : 'false' }}

{{ appendSection('main') }}
{{= 'bar' }}
{{ endSection() }}

{{ prependSection('main') }}
{{= 'baz' }}
{{ endSection() }}

{{ getSection('main') }}
