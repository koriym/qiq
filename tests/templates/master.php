<?php /** @var Qiq\FakeTemplate $this */ ?>
<?php
foreach (['bar', 'baz', 'dib'] as $foo) {
    echo $this->render('_partial', [
        'foo' => $foo,
    ]);
}

echo $foo . PHP_EOL;
