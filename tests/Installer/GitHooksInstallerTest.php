<?php

namespace Ams\Composer\GitHooks\Test\Installer;

use Ams\Composer\GitHooks\Installer\GitHooksInstaller;
use Composer\Composer;
use Composer\Config;
use Composer\TestCase;

class GitHooksInstallerTest extends TestCase
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
        $this->io = $this->getMockBuilder('Composer\IO\IOInterface')->getMock();
    }

    public function testSupportSuccess()
    {
        $installer = new GitHooksInstaller($this->io, $this->composer);

        $this->assertTrue($installer->supports('git-hook'));
    }
}
