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
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for rbac.',
                    'source' => __DIR__ . '/../publish/rbac.php',
                    'destination' => BASE_PATH . '/config/autoload/rbac.php',
                ],
            ],
        ];
    }
}
