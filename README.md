Git Hooks Composer Installer
===========================
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

The git hooks scripts should be located in a directory named `hooks` within your project root directory.