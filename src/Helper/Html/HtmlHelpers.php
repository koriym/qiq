<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

trait HtmlHelpers
{
    public function a(array|string $raw) : string
    {
        return $this
            ->getHelper(Escape::class)
            ->a($raw);
    }

    public function anchor(string $href, string $text, array $attr = []) : string
    {
        return $this
            ->getHelper(Anchor::class)
            ->__invoke($href, $text, $attr);
    }

    public function base(string $href) : string
    {
        return $this
            ->getHelper(Base::class)
            ->__invoke($href);
    }

    public function button(array $attr) : string
    {
        return $this
            ->getHelper(Button::class)
            ->__invoke($attr);
    }

    public function c(string $raw) : string
    {
        return $this
            ->getHelper(Escape::class)
            ->c($raw);
    }

    public function checkboxField(array $attr) : string
    {
        return $this
            ->getHelper(CheckboxField::class)
            ->__invoke($attr);
    }

    public function colorField(array $attr) : string
    {
        return $this
            ->getHelper(ColorField::class)
            ->__invoke($attr);
    }

    public function dateField(array $attr) : string
    {
        return $this
            ->getHelper(DateField::class)
            ->__invoke($attr);
    }

    public function datetimeField(array $attr) : string
    {
        return $this
            ->getHelper(DatetimeField::class)
            ->__invoke($attr);
    }

    public function datetimeLocalField(array $attr) : string
    {
        return $this
            ->getHelper(DatetimeLocalField::class)
            ->__invoke($attr);
    }

    public function dl(array $terms, array $attr = []) : string
    {
        return $this
            ->getHelper(Dl::class)
            ->__invoke($terms, $attr);
    }

    public function emailField(array $attr) : string
    {
        return $this
            ->getHelper(EmailField::class)
            ->__invoke($attr);
    }

    public function escape() : Escape
    {
        return $this->getHelper(Escape::class);
    }

    public function fileField(array $attr) : string
    {
        return $this
            ->getHelper(FileField::class)
            ->__invoke($attr);
    }

    public function form(array $attr) : string
    {
        return $this
            ->getHelper(Form::class)
            ->__invoke($attr);
    }

    public function h(string $raw) : string
    {
        return $this
            ->getHelper(Escape::class)
            ->h($raw);
    }

    public function hiddenField(array $attr) : string
    {
        return $this
            ->getHelper(HiddenField::class)
            ->__invoke($attr);
    }

    public function image(string $src, array $attr = []) : string
    {
        return $this
            ->getHelper(Image::class)
            ->__invoke($src, $attr);
    }

    public function imageButton(array $attr) : string
    {
        return $this
            ->getHelper(ImageButton::class)
            ->__invoke($attr);
    }

    public function inputField(array $attr) : string
    {
        return $this
            ->getHelper(InputField::class)
            ->__invoke($attr);
    }

    public function items(array $items) : string
    {
        return $this
            ->getHelper(Items::class)
            ->__invoke($items);
    }

    public function j(string $raw) : string
    {
        return $this
            ->getHelper(Escape::class)
            ->j($raw);
    }

    public function label(string $text, array $attr = []) : string
    {
        return $this
            ->getHelper(Label::class)
            ->__invoke($text, $attr);
    }

    public function link(string $rel, string $href, array $attr = []) : string
    {
        return $this
            ->getHelper(Link::class)
            ->__invoke($rel, $href, $attr);
    }

    public function linkStylesheet(string $href, array $attr = []) : string
    {
        return $this
            ->getHelper(LinkStylesheet::class)
            ->__invoke($href, $attr);
    }

    public function meta(array $attr) : string
    {
        return $this
            ->getHelper(Meta::class)
            ->__invoke($attr);
    }

    public function metaHttp(string $equiv, string $content) : string
    {
        return $this
            ->getHelper(MetaHttp::class)
            ->__invoke($equiv, $content);
    }

    public function metaName(string $name, string $content) : string
    {
        return $this
            ->getHelper(MetaName::class)
            ->__invoke($name, $content);
    }

    public function monthField(array $attr) : string
    {
        return $this
            ->getHelper(MonthField::class)
            ->__invoke($attr);
    }

    public function numberField(array $attr) : string
    {
        return $this
            ->getHelper(NumberField::class)
            ->__invoke($attr);
    }

    public function ol(array $items, array $attr = []) : string
    {
        return $this
            ->getHelper(Ol::class)
            ->__invoke($items, $attr);
    }

    public function passwordField(array $attr) : string
    {
        return $this
            ->getHelper(PasswordField::class)
            ->__invoke($attr);
    }

    public function radioField(array $attr) : string
    {
        return $this
            ->getHelper(RadioField::class)
            ->__invoke($attr);
    }

    public function rangeField(array $attr) : string
    {
        return $this
            ->getHelper(RangeField::class)
            ->__invoke($attr);
    }

    public function resetButton(array $attr) : string
    {
        return $this
            ->getHelper(ResetButton::class)
            ->__invoke($attr);
    }

    public function script(string $src, array $attr = []) : string
    {
        return $this
            ->getHelper(Script::class)
            ->__invoke($src, $attr);
    }

    public function searchField(array $attr) : string
    {
        return $this
            ->getHelper(SearchField::class)
            ->__invoke($attr);
    }

    public function select(array $attr) : string
    {
        return $this
            ->getHelper(Select::class)
            ->__invoke($attr);
    }

    public function submitButton(array $attr) : string
    {
        return $this
            ->getHelper(SubmitButton::class)
            ->__invoke($attr);
    }

    public function telField(array $attr) : string
    {
        return $this
            ->getHelper(TelField::class)
            ->__invoke($attr);
    }

    public function textarea(array $attr) : string
    {
        return $this
            ->getHelper(Textarea::class)
            ->__invoke($attr);
    }

    public function textField(array $attr) : string
    {
        return $this
            ->getHelper(TextField::class)
            ->__invoke($attr);
    }

    public function timeField(array $attr) : string
    {
        return $this
            ->getHelper(TimeField::class)
            ->__invoke($attr);
    }

    public function u(string $raw) : string
    {
        return $this
            ->getHelper(Escape::class)
            ->u($raw);
    }

    public function ul(array $items, array $attr = []) : string
    {
        return $this
            ->getHelper(Ul::class)
            ->__invoke($items, $attr);
    }

    public function urlField(array $attr) : string
    {
        return $this
            ->getHelper(UrlField::class)
            ->__invoke($attr);
    }

    public function weekField(array $attr) : string
    {
        return $this
            ->getHelper(WeekField::class)
            ->__invoke($attr);
    }
}
