<?php
declare(strict_types=1);

namespace Qiq;

use Throwable;

class Template extends Kernel
{
    public function render(string $__NAME__, array $__LOCAL__ = []) : string
    {
        try {
            $__OBLEVEL__ = ob_get_level();
            ob_start();
            $__SHARED__ =& $this->refData();
            extract($__LOCAL__, EXTR_SKIP);
            extract($__SHARED__, EXTR_SKIP|EXTR_REFS);
            require $this->getCompiled($__NAME__);
            return (string) ob_get_clean();
        } finally {
            while (ob_get_level() > $__OBLEVEL__) {
                ob_end_clean();
            }
        }
    }
}
