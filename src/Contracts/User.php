<?php

namespace Launcher\Mercurius\Contracts;

interface User
{
    public function getName();

    public function getSlug();

    public function getAvatar();
}
