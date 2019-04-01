<?php

namespace SellerCenter\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Renderer
{
    /**
     * @var Environment
     */
    protected $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader());
    }

    /**
     * @param array $data
     *
     * @return string
     */
    abstract protected function render(array $data): string;
}