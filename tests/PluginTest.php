<?php

namespace Ams\Composer\GitHooks\Test;

use Ams\Composer\GitHooks\Plugin;
use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\TestCase;

class PluginTest extends TestCase
{
    /**
     * @var Composer
     */
    private $composer;

    private $io;

    public function setUp()
    {
        $this->composer = new Composer();
        $this->composer->setConfig(new Config());
        $this->composer->setInstallationManager(new InstallationManager());
        $this->io = $this->getMock('Composer\IO\IOInterface');
    }

    public function testActivateSuccess()
    {
        $plugin = new Plugin();
        $plugin->activate($this->composer, $this->io);
        $installer = $this->composer->getInstallationManager()->getInstaller('git-hook');

        // Check right installer instance is given
        $this->assertInstanceOf('Ams\Composer\GitHooks\Installer\GitHooksInstaller', $installer);
    }
}
