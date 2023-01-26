<?php
declare(strict_types=1);

namespace Qiq;

use stdClass;

interface Rendering
{
    public function setIndent(string $base) : void;

    /**
     * @param array<string, mixed>|stdClass $data)
     */
    public function setData(array|stdClass $data) : void;

    /**
     * @param array<string, mixed>|stdClass $data)
     */
    public function addData(array|stdClass $data) : void;

    /**
     * @return array<string, mixed>
     */
    public function getData() : array;

    /**
     * @return array<string, mixed>
     */
    public function &refData() : array;

    public function setLayout(?string $layout) : void;

    public function getLayout() : ?string;

    public function setView(?string $view) : void;

    public function getView() : ?string;

    public function getContent() : string;

    public function hasSection(string $name) : bool;

    public function getSection(string $name) : ?string;

    public function setSection(string $name) : void;

    public function appendSection(string $name) : void;

    public function prependSection(string $name) : void;

    public function endSection() : void;

    /**
     * @param array<string, mixed> $__LOCAL__
     */
    public function render(
        string $__NAME__,
        array $__LOCAL__ = []
    ) : string;
}
