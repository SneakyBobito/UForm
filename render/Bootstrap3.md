Bootstrap 3 Render
==================

UForm allows to render for bootstrap 3:

```php

    use UForm\Render\Html\Bootstrap3;

    $render = new Bootstrap3();
    $html = $render->render($formContext);

```

Known Issues
------------

- Bootstrap's addons with button, radio and checkbox are currently not implemented

Additional CSS
--------------

Some additional css is required to make the render of bootstrap3 render better.

Up to you to modify the following sample to adapt it to your theme.


```css
    /** Inline elements with help text wont be vertically aligned **/
    .form-inline .form-group{
        vertical-align: top;
    }


    /** Inline elements with label have spacing issues **/
    .form-inline .form-group,
    .form-inline label{
        margin-right: 15px;
    }

    /** Tabs with error are not displaying the error status **/
    .nav-tabs>li.error>a,
    .nav-tabs>li.active.error>a
    {
        color: #a94442;
        font-weight: bold;
        background: #FFF2F3;
    }
    .nav-tabs>li.error:hover>a{
        background: #F9CED1;
    }

    /** Tabs error are not highlited **/
    .nav-tabs>li.error>a,
    .nav-tabs>li.active.error>a
    {
        color: #a94442;
        font-weight: bold;
    }
    .nav-tabs>li.error:hover>a{
        background: #F9CED1;
    }
    .nav-tabs>li.error>a{
        background: #FFF2F3;
    }
    .nav-tabs>li.active.error>a{
        background: #FFF;
    }
```

Additional Javascript
---------------------

Some component need additional javascript to run properly:

- Tab: they are defaultly loaded correctly but if you load your html via ajax you will need additional
javascript to initialize them again : http://getbootstrap.com/javascript/#tabs

- Tooltip: bootstrap does not autoload tooltip,
you need additional javascript to initialize them : http://getbootstrap.com/javascript/#tooltips