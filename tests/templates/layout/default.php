<?php /** @var Qiq\FakeTemplate $this */ ?>
<?php /** @var string $title */ ?>
<?= "{$title} -- before -- "
   . $this->getContent()
   . " -- after";
