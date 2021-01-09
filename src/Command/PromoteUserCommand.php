<?php

declare(strict_types=1);

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Command;

use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\Console\Output\OutputInterface;

final class PromoteUserCommand extends RoleCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'FOS:user:promote';

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('FOS:user:promote')
            ->setDescription('Promotes a user by adding a role')
            ->setHelp(
                <<<'EOT'
The <info>FOS:user:promote</info> command promotes a user by adding a role

  <info>php %command.full_name% matthieu ROLE_CUSTOM</info>
  <info>php %command.full_name% --super matthieu</info>
EOT
            )
        ;
    }

    protected function executeRoleCommand(UserManipulator $manipulator, OutputInterface $output, string $username, bool $super, string $role): void
    {
        if ($super) {
            $manipulator->promote($username);
            $output->writeln(sprintf('User "%s" has been promoted as a super administrator. This change will not apply until the user logs out and back in again.', $username));
        } elseif ($manipulator->addRole($username, $role)) {
            $output->writeln(sprintf('Role "%s" has been added to user "%s". This change will not apply until the user logs out and back in again.', $role, $username));
        } else {
            $output->writeln(sprintf('User "%s" did already have "%s" role.', $username, $role));
        }
    }
}
