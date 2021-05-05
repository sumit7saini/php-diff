<?php

declare(strict_types=1);

namespace App\Libraries\Diff\Renderer\Html\LineRenderer;

use App\Libraries\Diff\Renderer\RendererConstant;
use App\Libraries\Diff\SequenceMatcher;
use App\Libraries\Diff\Utility\ReverseIterator;
use App\Libraries\Diff\Utility\MbString;

final class Char extends AbstractLineRenderer
{
    /**
     * {@inheritdoc}
     *
     * @return static
     */
    public function render(MbString $mbOld, MbString $mbNew): LineRendererInterface
    {
        $hunk = $this->getChangedExtentSegments($mbOld->toArray(), $mbNew->toArray());

        // reversely iterate hunk
        foreach (ReverseIterator::fromArray($hunk) as [$op, $i1, $i2, $j1, $j2]) {
            if ($op & (SequenceMatcher::OP_REP | SequenceMatcher::OP_DEL)) {
                $mbOld->str_enclose_i(RendererConstant::HTML_CLOSURES, $i1, $i2 - $i1);
            }

            if ($op & (SequenceMatcher::OP_REP | SequenceMatcher::OP_INS)) {
                $mbNew->str_enclose_i(RendererConstant::HTML_CLOSURES, $j1, $j2 - $j1);
            }
        }

        return $this;
    }
}
