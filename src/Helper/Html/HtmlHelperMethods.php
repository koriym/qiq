<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

trait HtmlHelperMethods
{
    public function a(array|string $raw) : string
    {
        return $this
            ->getObject(Html\Escape::class)
            ->a($raw);
    }

    public function anchor(string $href, string $text, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Anchor::class)
            ->__invoke($href, $text, $attr);
    }

    public function base(string $href) : string
    {
        return $this
            ->getObject(Html\Base::class)
            ->__invoke($href);
    }

    public function button(array $attr) : string
    {
        return $this
            ->getObject(Html\Button::class)
            ->__invoke($attr);
    }

    public function c(string $raw) : string
    {
        return $this
            ->getObject(Html\Escape::class)
            ->c($raw);
    }

    public function checkboxField(array $attr) : string
    {
        return $this
            ->getObject(Html\CheckboxField::class)
            ->__invoke($attr);
    }

    public function colorField(array $attr) : string
    {
        return $this
            ->getObject(Html\ColorField::class)
            ->__invoke($attr);
    }

    public function dateField(array $attr) : string
    {
        return $this
            ->getObject(Html\DateField::class)
            ->__invoke($attr);
    }

    public function datetimeField(array $attr) : string
    {
        return $this
            ->getObject(Html\DatetimeField::class)
            ->__invoke($attr);
    }

    public function datetimeLocalField(array $attr) : string
    {
        return $this
            ->getObject(Html\DatetimeLocalField::class)
            ->__invoke($attr);
    }

    public function dl(array $terms, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Dl::class)
            ->__invoke($terms, $attr);
    }

    public function emailField(array $attr) : string
    {
        return $this
            ->getObject(Html\EmailField::class)
            ->__invoke($attr);
    }

    public function escape() : Html\Escape
    {
        return $this
            ->getObject(Html\Escape::class);
    }

    public function fileField(array $attr) : string
    {
        return $this
            ->getObject(Html\FileField::class)
            ->__invoke($attr);
    }

    public function form(array $attr) : string
    {
        return $this
            ->getObject(Html\Form::class)
            ->__invoke($attr);
    }

    public function h(string $raw) : string
    {
        return $this
            ->getObject(Html\Escape::class)
            ->h($raw);
    }

    public function hiddenField(array $attr) : string
    {
        return $this
            ->getObject(Html\HiddenField::class)
            ->__invoke($attr);
    }

    public function image(string $src, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Image::class)
            ->__invoke($src, $attr);
    }

    public function imageButton(array $attr) : string
    {
        return $this
            ->getObject(Html\ImageButton::class)
            ->__invoke($attr);
    }

    public function inputField(array $attr) : string
    {
        return $this
            ->getObject(Html\InputField::class)
            ->__invoke($attr);
    }

    public function items(array $items) : string
    {
        return $this
            ->getObject(Html\Items::class)
            ->__invoke($items);
    }

    public function j(string $raw) : string
    {
        return $this
            ->getObject(Html\Escape::class)
            ->j($raw);
    }

    public function label(string $text, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Label::class)
            ->__invoke($text, $attr);
    }

    public function link(string $rel, string $href, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Link::class)
            ->__invoke($rel, $href, $attr);
    }

    public function linkStylesheet(string $href, array $attr = []) : string
    {
        return $this
            ->getObject(Html\LinkStylesheet::class)
            ->__invoke($href, $attr);
    }

    public function meta(array $attr) : string
    {
        return $this
            ->getObject(Html\Meta::class)
            ->__invoke($attr);
    }

    public function metaHttp(string $equiv, string $content) : string
    {
        return $this
            ->getObject(Html\MetaHttp::class)
            ->__invoke($equiv, $content);
    }

    public function metaName(string $name, string $content) : string
    {
        return $this
            ->getObject(Html\MetaName::class)
            ->__invoke($name, $content);
    }

    public function monthField(array $attr) : string
    {
        return $this
            ->getObject(Html\MonthField::class)
            ->__invoke($attr);
    }

    public function numberField(array $attr) : string
    {
        return $this
            ->getObject(Html\NumberField::class)
            ->__invoke($attr);
    }

    public function ol(array $items, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Ol::class)
            ->__invoke($items, $attr);
    }

    public function passwordField(array $attr) : string
    {
        return $this
            ->getObject(Html\PasswordField::class)
            ->__invoke($attr);
    }

    public function radioField(array $attr) : string
    {
        return $this
            ->getObject(Html\RadioField::class)
            ->__invoke($attr);
    }

    public function rangeField(array $attr) : string
    {
        return $this
            ->getObject(Html\RangeField::class)
            ->__invoke($attr);
    }

    public function resetButton(array $attr) : string
    {
        return $this
            ->getObject(Html\ResetButton::class)
            ->__invoke($attr);
    }

    public function script(string $src, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Script::class)
            ->__invoke($src, $attr);
    }

    public function searchField(array $attr) : string
    {
        return $this
            ->getObject(Html\SearchField::class)
            ->__invoke($attr);
    }

    public function select(array $attr) : string
    {
        return $this
            ->getObject(Html\Select::class)
            ->__invoke($attr);
    }

    public function submitButton(array $attr) : string
    {
        return $this
            ->getObject(Html\SubmitButton::class)
            ->__invoke($attr);
    }

    public function telField(array $attr) : string
    {
        return $this
            ->getObject(Html\TelField::class)
            ->__invoke($attr);
    }

    public function textarea(array $attr) : string
    {
        return $this
            ->getObject(Html\Textarea::class)
            ->__invoke($attr);
    }

    public function textField(array $attr) : string
    {
        return $this
            ->getObject(Html\TextField::class)
            ->__invoke($attr);
    }

    public function timeField(array $attr) : string
    {
        return $this
            ->getObject(Html\TimeField::class)
            ->__invoke($attr);
    }

    public function u(string $raw) : string
    {
        return $this
            ->getObject(Html\Escape::class)
            ->u($raw);
    }

    public function ul(array $items, array $attr = []) : string
    {
        return $this
            ->getObject(Html\Ul::class)
            ->__invoke($items, $attr);
    }

    public function urlField(array $attr) : string
    {
        return $this
            ->getObject(Html\UrlField::class)
            ->__invoke($attr);
    }

    public function weekField(array $attr) : string
    {
        return $this
            ->getObject(Html\WeekField::class)
            ->__invoke($attr);
    }
}
