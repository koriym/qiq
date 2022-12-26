<?php
declare(strict_types=1);

namespace Qiq\Html;

trait HtmlHelpers
{
    public function a(array|string $raw) : string
    {
        return $this
            ->getHelper(Helper\Escape::class)
            ->a($raw);
    }

    public function anchor(string $href, string $text, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Anchor::class)
            ->__invoke($href, $text, $attr);
    }

    public function base(string $href) : string
    {
        return $this
            ->getHelper(Helper\Base::class)
            ->__invoke($href);
    }

    public function button(array $attr) : string
    {
        return $this
            ->getHelper(Helper\Button::class)
            ->__invoke($attr);
    }

    public function c(string $raw) : string
    {
        return $this
            ->getHelper(Helper\Escape::class)
            ->c($raw);
    }

    public function checkboxField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\CheckboxField::class)
            ->__invoke($attr);
    }

    public function colorField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\ColorField::class)
            ->__invoke($attr);
    }

    public function dateField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\DateField::class)
            ->__invoke($attr);
    }

    public function datetimeField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\DatetimeField::class)
            ->__invoke($attr);
    }

    public function datetimeLocalField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\DatetimeLocalField::class)
            ->__invoke($attr);
    }

    public function dl(array $terms, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Dl::class)
            ->__invoke($terms, $attr);
    }

    public function emailField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\EmailField::class)
            ->__invoke($attr);
    }

    public function escape() : Helper\Escape
    {
        return $this->getHelper(Helper\Escape::class);
    }

    public function fileField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\FileField::class)
            ->__invoke($attr);
    }

    public function form(array $attr) : string
    {
        return $this
            ->getHelper(Helper\Form::class)
            ->__invoke($attr);
    }

    public function h(string $raw) : string
    {
        return $this
            ->getHelper(Helper\Escape::class)
            ->h($raw);
    }

    public function hiddenField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\HiddenField::class)
            ->__invoke($attr);
    }

    public function image(string $src, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Image::class)
            ->__invoke($src, $attr);
    }

    public function imageButton(array $attr) : string
    {
        return $this
            ->getHelper(Helper\ImageButton::class)
            ->__invoke($attr);
    }

    public function inputField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\InputField::class)
            ->__invoke($attr);
    }

    public function items(array $items) : string
    {
        return $this
            ->getHelper(Helper\Items::class)
            ->__invoke($items);
    }

    public function j(string $raw) : string
    {
        return $this
            ->getHelper(Helper\Escape::class)
            ->j($raw);
    }

    public function label(string $text, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Label::class)
            ->__invoke($text, $attr);
    }

    public function link(string $rel, string $href, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Link::class)
            ->__invoke($rel, $href, $attr);
    }

    public function linkStylesheet(string $href, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\LinkStylesheet::class)
            ->__invoke($href, $attr);
    }

    public function meta(array $attr) : string
    {
        return $this
            ->getHelper(Helper\Meta::class)
            ->__invoke($attr);
    }

    public function metaHttp(string $equiv, string $content) : string
    {
        return $this
            ->getHelper(Helper\MetaHttp::class)
            ->__invoke($equiv, $content);
    }

    public function metaName(string $name, string $content) : string
    {
        return $this
            ->getHelper(Helper\MetaName::class)
            ->__invoke($name, $content);
    }

    public function monthField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\MonthField::class)
            ->__invoke($attr);
    }

    public function numberField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\NumberField::class)
            ->__invoke($attr);
    }

    public function ol(array $items, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Ol::class)
            ->__invoke($items, $attr);
    }

    public function passwordField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\PasswordField::class)
            ->__invoke($attr);
    }

    public function radioField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\RadioField::class)
            ->__invoke($attr);
    }

    public function rangeField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\RangeField::class)
            ->__invoke($attr);
    }

    public function resetButton(array $attr) : string
    {
        return $this
            ->getHelper(Helper\ResetButton::class)
            ->__invoke($attr);
    }

    public function script(string $src, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Script::class)
            ->__invoke($src, $attr);
    }

    public function searchField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\SearchField::class)
            ->__invoke($attr);
    }

    public function select(array $attr) : string
    {
        return $this
            ->getHelper(Helper\Select::class)
            ->__invoke($attr);
    }

    public function submitButton(array $attr) : string
    {
        return $this
            ->getHelper(Helper\SubmitButton::class)
            ->__invoke($attr);
    }

    public function telField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\TelField::class)
            ->__invoke($attr);
    }

    public function textarea(array $attr) : string
    {
        return $this
            ->getHelper(Helper\Textarea::class)
            ->__invoke($attr);
    }

    public function textField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\TextField::class)
            ->__invoke($attr);
    }

    public function timeField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\TimeField::class)
            ->__invoke($attr);
    }

    public function u(string $raw) : string
    {
        return $this
            ->getHelper(Helper\Escape::class)
            ->u($raw);
    }

    public function ul(array $items, array $attr = []) : string
    {
        return $this
            ->getHelper(Helper\Ul::class)
            ->__invoke($items, $attr);
    }

    public function urlField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\UrlField::class)
            ->__invoke($attr);
    }

    public function weekField(array $attr) : string
    {
        return $this
            ->getHelper(Helper\WeekField::class)
            ->__invoke($attr);
    }
}
