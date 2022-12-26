<?php
namespace Qiq\Html\Helper;

use Qiq\Indent;

class InputFieldTest extends HtmlHelperTest
{
    protected function newHelper()
    {
        return new InputField(new Escape(), new Indent());
    }

    public function testInputField()
    {
        $actual = $this->helper([
            'type' => 'fake',
            'name' => 'fake-name',
            'value' => 'fake-value',
        ]);

        $expect = '<input type="fake" name="fake-name" value="fake-value" />';

        $this->assertSame($expect, $actual);
    }

    /**
     * @dataProvider provideTypes
     */
    public function testTypes(string $class, string $type)
    {
        $input = new $class(new Escape(), new Indent());
        $actual = $input([
            'name' => 'fake-name',
            'value' => 'fake-value',
        ]);
        $expect = '<input type="' . $type . '" name="fake-name" value="fake-value" />';
        $this->assertSame($expect, $actual);
    }

    public function provideTypes()
    {
        return [
            [CheckboxField::class, 'checkbox'],
            [ColorField::class, 'color'],
            [DateField::class, 'date'],
            [DatetimeField::class, 'datetime'],
            [DatetimeLocalField::class, 'datetime-local'],
            [EmailField::class, 'email'],
            [FileField::class, 'file'],
            [HiddenField::class, 'hidden'],
            [ImageButton::class, 'image'],
            [MonthField::class, 'month'],
            [NumberField::class, 'number'],
            [PasswordField::class, 'password'],
            [RadioField::class, 'radio'],
            [RangeField::class, 'range'],
            [ResetButton::class, 'reset'],
            [SearchField::class, 'search'],
            [SubmitButton::class, 'submit'],
            [TelField::class, 'tel'],
            [TextField::class, 'text'],
            [TimeField::class, 'time'],
            [UrlField::class, 'url'],
            [WeekField::class, 'week'],
        ];
    }
}
