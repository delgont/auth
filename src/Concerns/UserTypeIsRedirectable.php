<?php

namespace Delgont\Auth\Concerns;

trait UserTypeIsRedirectable
{
    public function route()
    {
        return (property_exists($this, 'redirect')) ? $this->redirect : null;
    }
}