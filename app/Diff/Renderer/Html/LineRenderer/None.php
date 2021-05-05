<?php

declare(strict_types=1);

namespace App\Libraries\Diff\Renderer\Html\LineRenderer;

use App\Libraries\Diff\Utility\MbString;

final class None extends AbstractLineRenderer
{
    /**
     * {@inheritdoc}
     *
     * @return static
     */
    public function render(MbString $mbOld, MbString $mbNew): LineRendererInterface
    {
        return $this;
    }
}
