<?php

declare(strict_types=1);

namespace Wuxian\WebUtils;

use Wuxian\WebUtils\Commands\GenRbacCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
                GenRbacCommand::class,
            ],
        ];
    }
}
