FOSUserBundle
=================

[![Latest Stable Version](https://poser.pugx.org/FOS/user-bundle/v/stable)](https://packagist.org/packages/FOS/user-bundle)
[![Latest Unstable Version](https://poser.pugx.org/FOS/user-bundle/v/unstable)](https://packagist.org/packages/FOS/user-bundle)
[![License](https://poser.pugx.org/FOS/user-bundle/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/FOS/user-bundle/downloads)](https://packagist.org/packages/FOS/user-bundle)
[![Monthly Downloads](https://poser.pugx.org/FOS/user-bundle/d/monthly)](https://packagist.org/packages/FOS/user-bundle)
[![Daily Downloads](https://poser.pugx.org/FOS/user-bundle/d/daily)](https://packagist.org/packages/FOS/user-bundle)

[![Continuous Integration](https://github.com/FOS/FOSUserBundle/workflows/Continuous%20Integration/badge.svg)](https://github.com/FOS/FOSUserBundle/actions?query=workflow%3A"Continuous+Integration"+branch%3Amain)
[![Code Coverage](https://codecov.io/gh/FOS/FOSUserBundle/branch/main/graph/badge.svg)](https://codecov.io/gh/FOS/FOSUserBundle)
[![Type Coverage](https://shepherd.dev/github/FOS/FOSUserBundle/coverage.svg)](https://shepherd.dev/github/FOS/FOSUserBundle)

The FOSUserBundle is a fork of [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle/) which adds a lightweight support for a database-backed user system in symfony.

There are some major changes and refactorings if you want to migrate from FOS:

- It does not provide any advanced features like profile management or registration
- Swift mailer was dropped in favor of symfony mailer
- Couch DB support was removed
- Only symfony 4.4 / 5.x support
- There are only two *optional* dependencies: **doctrine/orm** and **doctrine/mongodb-odm**

Features included:

- Users can be stored via Doctrine ORM or MongoDB ODM
- Password reset support

Documentation
-------------

The source of the documentation is stored in the `docs/` folder
in this bundle.

[Read the Documentation](https://docs.FOS.rocks/projects/user-bundle/)

Installation
------------

All the installation instructions are located in the documentation.
