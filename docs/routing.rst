Advanced routing configuration
==============================

By default, the routing file ``@FOSUserBundle/Resources/config/routing/all.xml`` imports
all the routing files and enables all the routes.
In the case you want to enable or disable the different available routes, use the
single routing configuration files.

.. code-block:: yaml

    # config/routes/FOS_user.yaml
    FOS_user_security:
        resource: "@FOSUserBundle/Resources/config/routing/security.xml"

    FOS_user_resetting:
        resource: "@FOSUserBundle/Resources/config/routing/resetting.xml"
        prefix: /resetting

    FOS_user_change_password:
        resource: "@FOSUserBundle/Resources/config/routing/change_password.xml"
        prefix: /security

