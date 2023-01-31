<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class RadioField extends InputField
{
    protected string $type = 'radio';

    /**
     * @param stringy-array $attr
     */
    public function __invoke(array $attr) : string
    {
        if (! isset($attr['_options'])) {
            return parent::__invoke($attr);
        }

        $base = [
            'type' => 'radio',
            'name' => null,
            'value' => null,
            '_options' => [],
        ];

        /** @var stringy-array */
        $attr = array_merge($base, $attr);

        settype($attr['name'], 'string');
        assert(is_string($attr['name']));

        $options = (array) $attr['_options'];
        unset($attr['_options']);

        $html = '';

        if (array_key_exists('_default', $attr)) {
            $default = $attr['_default'];
            unset($attr['_default']);
            $html .= $this->default($attr['name'], $default);
        }

        $checked = $attr['value'];

        foreach ($options as $value => $label) {
            $html .= $this->radio(
                $attr,
                (string) $value,
                (string) $label,
                $checked
            );
        }

        return ltrim($html);
    }

    protected function default(string $name, mixed $default) : string
    {
        /** @var stringy-array */
        $attr = [
            'type' => 'hidden',
            'name' => $name,
            'value' => $default,
        ];

        return $this->indent->get() . $this->voidTag('input', $attr) . PHP_EOL;
    }

    /**
     * @param stringy-array $attr
     */
    protected function radio(
        array $attr,
        string $value,
        string $label,
        mixed $checked
    ) : string
    {
        $attr['type'] = 'radio';
        $attr['value'] = $value;
        $attr['checked'] = ($value == $checked);
        $attr = $this->escape->a($attr);
        $label = $this->escape->h($label);
        return $this->indent->get() . "<label><input {$attr} />{$label}</label>" . PHP_EOL;
    }
}
