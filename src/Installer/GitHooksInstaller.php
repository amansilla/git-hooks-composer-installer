<?php

namespace Ams\Composer\GitHooks\Installer;

use Ams\Composer\GitHooks\GitHooks;
use Ams\Composer\GitHooks\Plugin;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Package\PackageInterface;
use Composer\Util\Silencer;

class GitHooksInstaller extends LibraryInstaller
{
    /**
     * @inheritdoc
     */
    public function supports($packageType)
    {
        return $packageType == Plugin::PACKAGE_TYPE;
    }

    /**
     * Installs specific package.
     *
     * @param InstalledRepositoryInterface $repo    repository in which to check
     * @param PackageInterface             $package package instance
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $originPath = realpath($this->getInstallPath($package) . '/hooks');
        $this->io->write($originPath);

        $targetPath = realpath($this->vendorDir . '/../.git/hooks');
        $this->io->write($targetPath);

        // throws exception if one of both paths doesn't exists
        $this->filesystem->ensureDirectoryExists($originPath);
        $this->filesystem->ensureDirectoryExists($targetPath);

        $this->copyGitHooks($originPath, $targetPath);
    }

    /**
     * Updates specific package.
     *
     * @param InstalledRepositoryInterface $repo    repository in which to check
     * @param PackageInterface             $initial already installed package version
     * @param PackageInterface             $target  updated version
     *
     * @throws InvalidArgumentException if $initial package is not installed
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $originPath = realpath($this->getInstallPath($initial) . '/hooks');
        $this->io->write($originPath);

        $targetPath = realpath($this->vendorDir . '/../.git/hooks');
        $this->io->write($targetPath);

        // throws exception if one of both paths doesn't exists
        $this->filesystem->ensureDirectoryExists($originPath);
        $this->filesystem->ensureDirectoryExists($targetPath);

        $this->copyGitHooks($originPath, $targetPath, true);
    }

    private function copyGitHooks($sourcePath, $targetPath, $isUpdate = false)
    {
        $i = new \FilesystemIterator($sourcePath);

        foreach ($i as $githook) {
            // ignore all files not matching a git hook name
            if (!array_search($githook->getFilename(), GitHooks::$hookFilename)) {
                $this->io->write(sprintf('Found % not matching any valid git hook name', $githook->getFilename()));
                continue;
            }

            $newPath = $targetPath.'/'.$githook->getFilename();

            // check if .sample version exists in that case rename it
            if (file_exists($newPath . GitHooks::SAMPLE)) {
                rename($newPath . GitHooks::SAMPLE, $newPath . GitHooks::SAMPLE . 'bk');
            }

            // check if there is already a git hook with same name do nothing
            if (file_exists($newPath) && !$isUpdate) {
                $this->io->write(sprintf('Found already existing %s git hook. Doing nothing.', $githook->getFilename()));
                continue;
            }

            // if hook already exist but anything changed update it
            if (file_exists($newPath) && $isUpdate && sha1_file($githook->getPathname()) === sha1_file($newPath)) {
                continue;
            }

            $this->io->write('Installing ' . $githook->getPathname() . ' into ' . $newPath);
            copy($githook->getPathname(), $newPath);
            Silencer::call('chmod', $newPath, 0777 & ~umask());
        }
    }
}
