Angular Material Bundle
=======================

Installation
------------

Install the bundle the usual way:

```php
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
````

Dump The Assets
---------------

Symfony 2.x

```bash
    php app/console assetic:dump
```

Symfony 3.x

```bash
    php bin/console assetic:dump
```

Install the Assets
------------------

Symfony 2.x

```bash
    php app/console assets:install --symlink
```

Symfony 3.x

```bash
    php bin/console assets:install --symlink
```

Wire-Up JavaScript
------------------

```twig
    {% block javascripts %}
        <!-- Wire-Up the Angular assets -->
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular/angular.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-animate/angular-animate.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-aria/angular-aria.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-messages/angular-messages.min.js') }}"></script>
        <script src="{{ asset('bundles/curiosity26angularmaterial/components/angular-material/angular-material.min.js') }}"></script>

        <!-- Wire-up the Symfony Form Angular Controller -->
        <script src="{{ asset('bundles/curiosity26angularmaterial/js/mdform.js') }}"></script>
        
        <!-- Wire-up the Symfony Angular Addons -->
        <script src="{{ asset('bundles/curiosity26angularmaterial/js/mdaddons.js') }}"></script>

        // ... The rest of your scripts here
    {% endblock %}
```

Wire-Up Material Stylesheets
----------------------------

```twig
    {% block stylesheets %}
        <link rel="stylesheet" type="text/css" href="{{ asset('bundles/curiosity26angularmaterial/components/angular-material/angular-material.min.css') }}">
        // ... Other stylesheets here
    {% endblock %}
```

Wire-Up the Form Template
-------------------------

```yaml
    # Twig Configuration
    twig:
        # ...
        form:
            resources: ['@Curiosity26AngularMaterialBundle/Resources/Form/material_1_layout.html.twig']
```

Create Your Angular App
-----------------------

Create an Angular app and include the `symfony.mdForm` as a dependency. This will also bring in the Angular, Material, Animate, Aria and Messages modules.

```JavaScript
    angular.module('myApp', ['symfony.mdForm'])
        .controller('MainCtrl', function($scope) {
            // ...
        })
    ;
```

If you want to use the [Bundled Addons](#bundled-addons), include the addons module:

```JavaScript
    angular.module('myApp', ['symfony.mdForm', 'symfony.mdAddons'])
        .controller('MainCtrl', function($scope) {
            // ...
        })
    ;
```

Connect Your App and Controllers in Templates
---------------------------------------------

You can connect you Angular app in the base template or any extended templates. How you configure your templates to work with your Angular application is up to you.

```twig
    {# ::base.html.twig #}
    <html lang="en" ng-app="{{ ngApp|default('myApp') }}">
        <head>
            <!-- ... -->
        </head>
        <body ng-controller="{{ ngController|default('MainCtrl') }}">
            <!-- ... -->
        </body>
    </html>
```

Material Icons
--------------

You can use Assetic to load Material Icons from the CDN.

```yaml
assetic:
    ...
    assets:
        material_icons:
            inputs:
                - https://fonts.googleapis.com/icon?family=Material+Icons
````

```twig
    {% stylesheets output="style.min.css" "@material_icons" %}
        <link rel="stylesheet" href="{{ asset_url }}">
    {% endstylesheets %}
````

Bundled Addons
--------------

As I used Angular Material inside Symfony, I decided to make some helper directives to help with things like Toast Alerts and Dialogs.

## sf-alert

The `sf-alert` directive is an **element directive** to display toast alerts. Alerts are automatically displayed when the page load completes.

```HTML
    <sf-alert sf-alert-action="Yea" sf-alert-parent="#wrapper">This is the message in the alert</sf-alert>
```

### Attributes

| Attribute | Definition |
--- | ---
| sf-alert-action | The text as it appears on the action button |
| sf-alert-position | The position of the alert using any combination of 'top, right, bottom, left, end, start' |
| sf-alert-auto-wrap | Automatically wrap the contents of the Toast message. *Defaults to true* |
| sf-alert-capsule | Adds `md-capsule` to the Toast |
| sf-alert-hide-delay | The number of milliseconds the message displays before hiding the message. 0 disables auto-hiding and is the default value. |
| sf-alert-parent | The CSS selector of the element the Toast message will align to. Best to use an ID here, as the first item found will be used. |

## sf-dialog-link

The `sf-dialog` directive can be used as an **attribute** or a **class**. I've found this directive to be very useful. 

When the directive is applied to an existing `a` or `md-button` element, the URL in the `href` or `ng-href` attribute are loaded
and rendered using the `$mdDialog` service.

The `$http` service is used to make the request call and load the response. The `sf-dialog` directive overrides the 
`$http` service to pass the request header `X-Requested-With: XMLHttpRequest` in order to allow smarty to use 
`{% app.request.isXmlHttpRequest() %}`.

```twig
    {# homepage.html.twig #}
    <md-button ng-href="{{ path('add_object') }}" sf-dialog-link>Open Dialog</md-button>
```

```twig
    {# add_object.html.twig #}
    {% extends app.request.isXmlHttpRequest() ? '::dialog.html.twig' : '::base.html.twig' %}
    
    {% block title %}
        Page Title
    {% endblock %}
    
    {% block body %}
        ...
    {% endblock %}
```

```twig
    {# dialog.html.twig #}
    
    <md-toolbar class="md-primary">
        <div class="md-toolbar-tools">
            <h2>{% block title %}{% endblock %}</h2>
            <span flex></span>
            <md-button ng-click="dialog.closeDialog()" class="md-icon-button" aria-label="Close">
                <md-icon>close</md-icon>
            </md-button>
        </div>
    </md-toolbar>
    {% block body %}{% endblock %}
```

### Attributes

| Attribute | Definition |
--- | ---
| href, ng-href | The URL to load in the dialog |
| sf-dialog-method | The HTTP Method used for the request |
| sf-dialog-data | Sets the `data` attribute for the `$http` service |
| sf-dialog-controller | Set the controller to be used for the dialog. A default controller is used which provides a method `closeDialog` that should be bound to a close button. The controller, default or custom, is aliased as 'dialog'. |
| sf-dialog-success | A callback triggered when `$mdDialog.hide()` is called. |
| sf-dialog-cancel | A callback triggered when `$mdDialog.cancel()` is called. |
| sf-dialog-error | A callback triggered when an error is reported the HTTP response with the returned `$err` object as the only parameter. Default behavior shows a Toast with the error message. |
| sf-dialog-fullscreen |  An option to toggle whether the dialog should show in fullscreen or not. *Defaults to false.* |
| sf-dialog-has-backdrop | Whether there should be an opaque backdrop behind the dialog. *Default true.* |
| sf-dialog-click-outside-to-cancel | Whether the user can click outside the dialog to close it. *Default false.* |
| sf-dialog-disable-parent-scroll | Whether to disable scrolling while the dialog is open. *Default true.* |