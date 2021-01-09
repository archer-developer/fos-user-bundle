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

namespace FOS\UserBundle\Tests\Form\Type;

use FOS\UserBundle\Form\Model\Resetting;
use FOS\UserBundle\Form\Type\ResettingFormType;
use FOS\UserBundle\Model\UserInterface;

final class ResettingFormTypeTest extends ValidatorExtensionTypeTestCase
{
    public function testSubmit(): void
    {
        $model = new Resetting($this->createStub(UserInterface::class));

        $form     = $this->factory->create(ResettingFormType::class, $model);
        $formData = [
            'plainPassword' => [
                'first'  => 'test',
                'second' => 'test',
            ],
        ];
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
        static::assertSame($model, $form->getData());
        static::assertSame('test', $model->getPlainPassword());
    }

    protected function getTypes(): array
    {
        return array_merge(parent::getTypes(), [
            new ResettingFormType(Resetting::class),
        ]);
    }
}
