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

namespace FOS\UserBundle\Validator;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use Symfony\Component\Validator\ObjectInitializerInterface;

final class Initializer implements ObjectInitializerInterface
{
    /**
     * @var CanonicalFieldsUpdater
     */
    private $canonicalFieldsUpdater;

    public function __construct(CanonicalFieldsUpdater $canonicalFieldsUpdater)
    {
        $this->canonicalFieldsUpdater = $canonicalFieldsUpdater;
    }

    /**
     * @param object $object
     */
    public function initialize($object): void
    {
        if ($object instanceof UserInterface) {
            $this->canonicalFieldsUpdater->updateCanonicalFields($object);
        }
    }
}
