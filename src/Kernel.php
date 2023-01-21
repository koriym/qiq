<?php
declare(strict_types=1);

namespace Qiq;

use Qiq\Compiler\Compiler;
use Qiq\Compiler\QiqCompiler;
use Qiq\Helper\Html\HtmlHelpers;
use stdClass;

abstract class Kernel implements Rendering
{
    public static function new(
        string|array $paths = [],
        string $extension = '.php',
        Helpers $helpers = null,
        Compiler $compiler = null,
    ) : static
    {
        return new static(
            new Catalog(
                (array) $paths,
                $extension,
            ),
            $compiler ?? new QiqCompiler(),
            $helpers ?? new HtmlHelpers(),
        );
    }

    private string $content = '';

    private array $data = [];

    private ?string $layout = null;

    private array $sections = [];

    private array $sectionStack = [];

    private ?string $view = null;

    public function __construct(
        private Catalog $catalog,
        private Compiler $compiler,
        private Helpers $helpers
    ) {
    }

    public function __invoke() : string
    {
        $view = $this->getView();
        $this->content = ($view === null) ? '' : $this->render($view);
        $layout = $this->getLayout();

        if ($layout === null) {
            return $this->content;
        }

        return $this->render($layout);
    }

    public function __call(string $func, array $args): mixed
    {
        return $this->helpers->$func(...$args);
    }

    public function setIndent(string $base) : void
    {
        $this->helpers->setIndent($base);
    }

    public function setData(array|stdClass $data) : void
    {
        $this->data = (array) $data;
    }

    public function addData(array|stdClass $data) : void
    {
        $this->data = array_replace($this->data, (array) $data);
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function &refData() : array
    {
        return $this->data;
    }

    public function setLayout(?string $layout) : void
    {
        $this->layout = $layout;
    }

    public function getLayout() : ?string
    {
        return $this->layout;
    }

    public function setView(?string $view) : void
    {
        $this->view = $view;
    }

    public function getView() : ?string
    {
        return $this->view;
    }

    public function getCompiler() : Compiler
    {
        return $this->compiler;
    }

    public function getCompiled(string $name) : string
    {
        return $this->catalog->get(
            $this->compiler,
            $name
        );
    }

    public function getHelpers() : Helpers
    {
        return $this->helpers;
    }

    public function getCatalog() : Catalog
    {
        return $this->catalog;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function hasSection(string $name) : bool
    {
        return isset($this->sections[$name]);
    }

    public function getSection(string $name) : ?string
    {
        return $this->sections[$name] ?? null;
    }

    public function setSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function appendSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function prependSection(string $name) : void
    {
        $this->sectionStack[] = [__FUNCTION__, $name];
        ob_start();
    }

    public function endSection() : void
    {
        list($func, $name) = array_pop($this->sectionStack);
        $buffer = (string) ob_get_clean();

        if (! $this->hasSection($name)) {
            $this->sections[$name] = '';
        }

        switch ($func) {
            case 'appendSection':
                $this->sections[$name] .= $buffer;
                return;
            case 'prependSection':
                $this->sections[$name] = $buffer . $this->sections[$name];
                return;
            default:
                $this->sections[$name] = $buffer;
                return;
        }
    }

    abstract public function render(
        string $__NAME__,
        array $__LOCAL__ = []
    ) : string;
}
