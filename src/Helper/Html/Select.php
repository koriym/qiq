<?php
declare(strict_types=1);

namespace Qiq\Helper\Html;

use Qiq\Indent;

class Select extends TagHelper
{
    /**
     * @param array<string, string|string[]> $attr
     */
    public function __invoke(array $attr) : string
    {
        $base = [
            'name' => null,
        ];

        $attr = array_merge($base, $attr);

        $placeholder = $attr['placeholder'] ?? null;
        unset($attr['placeholder']);

        $options = $attr['_options'] ?? [];
        unset($attr['_options']);

        $default = $attr['_default'] ?? '';
        unset($attr['_default']);

        $selected = $attr['value'] ?? $default;
        unset($attr['value']);

        if ($attr['multiple'] ?? false) {
            $attr['name'] .= '[]';
        }

        $html = $this->openTag('select', $attr) . PHP_EOL;
        $this->indent->level(+1);

        if ($placeholder !== null) {
            $html .= $this->indent->get() . $this->fullTag(
                'option',
                [
                    'value' => $default,
                    'disabled' => true,
                    'selected' => ($selected == $default)
                ],
                $placeholder
            ) . PHP_EOL;
        }

        $html .= $this->options($options, $selected);

        $this->indent->level(-1);

        return $html . $this->indent->get() . '</select>';
    }

    protected function options(array $options, mixed $selected) : string
    {
        $html = '';

        foreach ($options as $key => $val) {
            $html .= $this->option($key, $val, $selected);
        }

        return $html;
    }

    protected function option(int|string $key, mixed $val, mixed $selected) : string
    {
        if (is_array($val)) {
            return $this->optgroup($key, $val, $selected);
        }

        $attr = [];

        $attr['value'] = $key;

        $attr['selected'] = is_array($selected)
            ? in_array($attr['value'], $selected)
            : $attr['value'] == $selected;

        $attr = $this->escape->a($attr);
        $label = $this->escape->h($val); // @phpstan-ignore-line

        return $this->indent->get() . "<option {$attr}>{$label}</option>" . PHP_EOL;
    }

    public function optgroup(int|string $label, array $options, mixed $selected) : string
    {
        $attr = $this->escape->a(['label' => $label]);

        $this->indent->level(+1);
        $group = $this->options($options, $selected);
        $this->indent->level(-1);

        return $this->indent->get() . "<optgroup $attr>" . PHP_EOL
            . $group
            . $this->indent->get() . "</optgroup>" . PHP_EOL;
    }
}
