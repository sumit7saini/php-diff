<?php

declare(strict_types=1);

namespace App\Libraries\Diff\Renderer;

use App\Libraries\Diff\Differ;
use App\Libraries\Diff\Exception\UnsupportedFunctionException;

/**
 * Renderer Interface.
 */
interface RendererInterface
{
    /**
     * Get the renderer result when the old and the new are the same.
     */
    public function getResultForIdenticals(): string;

    /**
     * Render the differ and return the result.
     *
     * @param Differ $differ the Differ object to be rendered
     */
    public function render(Differ $differ): string;

    /**
     * Render the differ array and return the result.
     *
     * @param array[][] $differArray the Differ array to be rendered
     *
     * @throws UnsupportedFunctionException if the renderer does not support this method
     */
    public function renderArray(array $differArray): string;
}
