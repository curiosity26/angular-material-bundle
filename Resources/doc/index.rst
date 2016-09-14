Angular Material Bundle
=======================

Installation
------------

Install the bundle the usual way:

.. code-block:: php
    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new Curiosity26\AngularMaterialBundle\Curiosity26AngularMaterialBundle(),
            );

            // ...
        }

        // ...
    }
..

Dump The Assets
---------------

Symfony 2.x

.. code-block:: bash
    php app/console assetic:dump
..

Symfony 3.x

.. code-block:: bash
    php bin/console assetic:dump
..

Install the Assets
------------------

Symfony 2.x

.. code-block:: bash
    php app/console assets:install --symlink
..

Symfony 3.x

.. code-block:: bash
    php bin/console assets:install --symlink
..

Wire-Up JavaScript
------------------

.. code-block:: twig
    {% block javascripts %}
        <!-- Wire-Up the Angular assets -->
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular/angular.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-animate/angular-animate.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-aria/angular-aria.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-messages/angular-messages.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-material/angular-material.min.js') }}"></script>

        <!-- Wire-up the Symfony Form Angular Controller -->
        <script src="{{ asset('bundles/curiosity26angularmaterial/js/mdform.js') }}"></script>

        // ... The rest of your scripts here
    {% endblock %}
..

Wire-Up Material Stylesheets
----------------------------

.. code-block:: twig
    {% block stylesheets %}
        <link rel="stylesheet" type="text/css" href="{{ asset('bundles/curiosity26angularmaterial/components/angular-material/angular-material.min.css') }}">
        // ... Other stylesheets here
    {% endblock %}
..

Wire-Up the Form Template
-------------------------

.. code-block:: yaml
    # Twig Configuration
    twig:
        # ...
        form:
            resources: ['@Curiosity26AngularMaterialBundle/Resources/Form/material_1_layout.html.twig']
..

Create Your Angular App
-----------------------

Create an Angular app and include the `symfony.mdForm` as a dependency. This will also bring in the Angular, Material, Animate, Aria and Messages modules.

.. code-block:: JavaScript
    angular.module('myApp', ['symfony.mdForm'])
        .controller('MainCtrl', function($scope) {
            // ...
        })
    ;
..

Connect Your App and Controllers in Templates
---------------------------------------------

You can connect you Angular app in the base template or any extended templates. How you configure your templates to work with your Angular application is up to you.

.. code-block:: twig
    {# ::base.html.twig #}
    <html lang="en" ng-app="{{ ngApp|default('myApp') }}">
        <head>
            <!-- ... -->
        </head>
        <body ng-controller="{{ ngController|default('MainCtrl') }}">
            <!-- ... -->
        </body>
    </html>
..