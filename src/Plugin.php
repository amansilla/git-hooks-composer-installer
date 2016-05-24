<?php

namespace Ams\Composer\GitHooks;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Ams\Composer\GitHooks\Installer\GitHooksInstaller;

class Plugin implements PluginInterface
{
    const PACKAGE_TYPE = 'git-hook';

    public function activate(Composer $composer, IOInterface $io)
    {
        $installer = new GitHooksInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
