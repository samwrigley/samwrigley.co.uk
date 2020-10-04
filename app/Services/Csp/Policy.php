<?php

namespace App\Services\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Policies\Policy as BasePolicy;

class Policy extends Basic
{
    public function configure(): void
    {
        parent::configure();

        $this->addImageDirectives();
        $this->addFontDirectives();
    }

    protected function addImageDirectives(): BasePolicy
    {
        return $this->addDirective(Directive::IMG, [
            '*.cloudinary.com',
            '*.placeholder.com', // Faker
        ]);
    }

    protected function addFontDirectives(): BasePolicy
    {
        return $this
            ->addDirective(Directive::FONT, 'fonts.gstatic.com')
            ->addDirective(Directive::SCRIPT, 'fonts.googleapis.com')
            ->addDirective(Directive::STYLE, 'fonts.googleapis.com');
    }
}
