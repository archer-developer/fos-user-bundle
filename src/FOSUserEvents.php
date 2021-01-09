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

namespace FOS\UserBundle;

/**
 * Contains all events thrown in the FOSUserBundle.
 */
final class FOSUserEvents
{
    /**
     * The CHANGE_PASSWORD_COMPLETED event occurs after saving the user in the change password process.
     *
     * This event allows you to access the response which will be sent.
     *
     * @Event("FOS\UserBundle\Event\FilterUserResponseEvent")
     */
    public const CHANGE_PASSWORD_COMPLETED = 'FOS_user.change_password.edit.completed';

    /**
     * The USER_CREATED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the created user and to add some behaviour after the creation.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_CREATED = 'FOS_user.user.created';

    /**
     * The USER_PASSWORD_CHANGED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the created user and to add some behaviour after the password change.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_PASSWORD_CHANGED = 'FOS_user.user.password_changed';

    /**
     * The USER_ACTIVATED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the activated user and to add some behaviour after the activation.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_ACTIVATED = 'FOS_user.user.activated';

    /**
     * The USER_DEACTIVATED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the deactivated user and to add some behaviour after the deactivation.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_DEACTIVATED = 'FOS_user.user.deactivated';

    /**
     * The USER_PROMOTED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the promoted user and to add some behaviour after the promotion.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_PROMOTED = 'FOS_user.user.promoted';

    /**
     * The USER_DEMOTED event occurs when the user is created with UserManipulator.
     *
     * This event allows you to access the demoted user and to add some behaviour after the demotion.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_DEMOTED = 'FOS_user.user.demoted';

    /**
     * The USER_LOCALE_CHANGED event occurs when the user changed the locale.
     *
     * This event allows you to access the user settings and to add some behaviour after the locale change.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_LOCALE_CHANGED = 'FOS_user.user.locale_changed';

    /**
     * The USER_TIMEZONE_CHANGED event occurs when the user changed the timezone.
     *
     * This event allows you to access the user settings and to add some behaviour after the timezone change.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const USER_TIMEZONE_CHANGED = 'FOS_user.user.timezone_changed';

    /**
     * The CHANGE_PASSWORD_INITIALIZE event occurs when the change password process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const CHANGE_PASSWORD_INITIALIZE = 'FOS_user.change_password.edit.initialize';

    /**
     * The CHANGE_PASSWORD_SUCCESS event occurs when the change password form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     *
     * @Event("FOS\UserBundle\Event\FormEvent")
     */
    public const CHANGE_PASSWORD_SUCCESS = 'FOS_user.change_password.edit.success';

    /**
     * The RESETTING_RESET_REQUEST event occurs when a user requests a password reset of the account.
     *
     * This event allows you to check if a user is locked out before requesting a password.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseUserEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const RESETTING_RESET_REQUEST = 'FOS_user.resetting.reset.request';

    /**
     * The RESETTING_RESET_INITIALIZE event occurs when the resetting process is initialized.
     *
     * This event allows you to set the response to bypass the processing.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const RESETTING_RESET_INITIALIZE = 'FOS_user.resetting.reset.initialize';

    /**
     * The RESETTING_RESET_SUCCESS event occurs when the resetting form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     *
     * @Event("FOS\UserBundle\Event\FormEvent ")
     */
    public const RESETTING_RESET_SUCCESS = 'FOS_user.resetting.reset.success';

    /**
     * The RESETTING_RESET_COMPLETED event occurs after saving the user in the resetting process.
     *
     * This event allows you to access the response which will be sent.
     *
     * @Event("FOS\UserBundle\Event\FilterUserResponseEvent")
     */
    public const RESETTING_RESET_COMPLETED = 'FOS_user.resetting.reset.completed';

    /**
     * The SECURITY_LOGIN_INITIALIZE event occurs when the send email process is initialized.
     *
     * This event allows you to set the response to bypass the login.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseLoginEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseLoginEvent")
     */
    public const SECURITY_LOGIN_INITIALIZE = 'FOS_user.security.login.initialize';

    /**
     * The SECURITY_LOGIN_COMPLETED event occurs after the user is logged in.
     *
     * This event allows you to set the response to bypass the the redirection after the user is logged in.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseUserEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const SECURITY_LOGIN_COMPLETED = 'FOS_user.security.login.completed';

    /**
     * The SECURITY_IMPLICIT_LOGIN event occurs when the user is logged in programmatically.
     *
     * This event allows you to access the response which will be sent.
     *
     * @Event("FOS\UserBundle\Event\UserEvent")
     */
    public const SECURITY_IMPLICIT_LOGIN = 'FOS_user.security.implicit_login';

    /**
     * The RESETTING_SEND_EMAIL_INITIALIZE event occurs when the send email process is initialized.
     *
     * This event allows you to set the response to bypass the email confirmation processing.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseNullableUserEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseNullableUserEvent")
     */
    public const RESETTING_SEND_EMAIL_INITIALIZE = 'FOS_user.resetting.send_email.initialize';

    /**
     * The RESETTING_SEND_EMAIL_CONFIRM event occurs when all prerequisites to send email are
     * confirmed and before the mail is sent.
     *
     * This event allows you to set the response to bypass the email sending.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseUserEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const RESETTING_SEND_EMAIL_CONFIRM = 'FOS_user.resetting.send_email.confirm';

    /**
     * The RESETTING_SEND_EMAIL_COMPLETED event occurs after the email is sent.
     *
     * This event allows you to set the response to bypass the the redirection after the email is sent.
     * The event listener method receives a FOS\UserBundle\Event\GetResponseUserEvent instance.
     *
     * @Event("FOS\UserBundle\Event\GetResponseUserEvent")
     */
    public const RESETTING_SEND_EMAIL_COMPLETED = 'FOS_user.resetting.send_email.completed';
}
