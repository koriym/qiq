<?php /** @var \Qiq\TemplateFile&\Qiq\Helper\Html\HtmlHelpers $this ?>
<?php /** @var string $foo */ ?>
echo $this->render('index');
echo $this->textField(['name' => 'foo', 'value' => 'bar']);
echo strtoupper($foo);
