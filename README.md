Git Hooks Composer Installer
===========================
[![Latest Stable Version](https://poser.pugx.org/ams/git-hooks-installer/v/stable)](https://packagist.org/packages/ams/git-hooks-installer)
[![Total Downloads](https://poser.pugx.org/ams/git-hooks-installer/downloads)](https://packagist.org/packages/ams/git-hooks-installer)
[![License](https://poser.pugx.org/ams/git-hooks-installer/license)](https://packagist.org/packages/ams/git-hooks-installer)

This plugin helps you automate the installation git hooks using [composer](https://github.com/composer/composer).

# Installation
Just run the following command:

    php composer.phar require --dev ams/git-hooks-installer

or if you prefer add the following to the `composer.json` file:

    {
        "require-dev": {
            "ams/git-hooks-installer": dev-master"
        }
    }

# Usage
##Include your git hooks
When the git-hooks-composer installer is run, it only looks for git-hooks among your project dependencies. If your package
is a git hook and you want it to be installed with composer automatically you'll need to define a `composer.json` as follows:

    {
        "type": "git-hook"
    }
    
<aside class="warning">
The git hooks scripts should be located in the package root directory.
</aside>

Currently are the following git hooks supported:
* `applypatch-msg`
* `pre-applypatch`
* `post-applypatch`
* `pre-commit`
* `prepare-commit-msg`
* `commit-msg`
* `post-commit`
* `pre-rebase`
* `post-checkout`
* `post-merge`
* `pre-push`
* `pre-receive`
* `update`
* `post-receive`
* `post-update`
* `pre-auto-gc`
* `post-rewrite`
