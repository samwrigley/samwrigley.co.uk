<?php

namespace App\Services\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy as BasePolicy;

class Policy extends BasePolicy
{
    public function configure()
    {
        $this->addGeneralDirectives();
        $this->addDirectivesForFonts();
        $this->addDirectivesForGoogleAnalytics();
        $this->addDirectivesForGoogleTagManager();
    }

    protected function addGeneralDirectives(): BasePolicy
    {
        return $this
            ->addDirective(Directive::DEFAULT, 'self')
            ->addDirective(Directive::SCRIPT, 'self')
            ->addDirective(Directive::STYLE, 'self')
            ->addDirective(Directive::IMG, 'self')
            ->addNonceForDirective(Directive::SCRIPT);
    }

    protected function addDirectivesForFonts(): BasePolicy
    {
        return $this
            ->addDirective(Directive::FONT, 'fonts.gstatic.com')
            ->addDirective(Directive::SCRIPT, 'fonts.googleapis.com')
            ->addDirective(Directive::STYLE, 'fonts.googleapis.com')
            ->addDirective(Directive::FONT, 'rsms.me')
            ->addDirective(Directive::STYLE, 'rsms.me');
    }

    protected function addDirectivesForGoogleAnalytics(): BasePolicy
    {
        return $this
            ->addDirective(Directive::SCRIPT, '*.google-analytics.com')
            ->addDirective(Directive::IMG, '*.google-analytics.com');
    }

    protected function addDirectivesForGoogleTagManager(): BasePolicy
    {
        return $this->addDirective(Directive::SCRIPT, '*.googletagmanager.com');
    }
}
