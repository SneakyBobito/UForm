UForm
=====

[![Build Status](https://travis-ci.org/gsouf/UForm.svg)](https://travis-ci.org/gsouf/UForm)
[![Test Coverage](https://codeclimate.com/github/gsouf/UForm/badges/coverage.svg)](https://codeclimate.com/github/SneakyBobito/UForm/coverage)
[![Code Climate](https://codeclimate.com/github/gsouf/UForm/badges/gpa.svg)](https://codeclimate.com/github/SneakyBobito/UForm)
[![Latest Stable Version](https://poser.pugx.org/gsouf/uform/version)](https://packagist.org/packages/gsouf/uform)


UForm is a form validation/filtering/rendering library that solve all the problems you encounter with web forms.

Why another form library? Because the other I tried had limitations. This library is an effort to make something more flexible and at the same time very concrete. 


UForm is structured as follows
------------------------------

- A **logicless and stateless core** that defines usual form elements
- Some **HTML structure aware** components (fieldset, row, colomns, tabs, panel...) 
- A flexible **validation/filtering** workflow with translatable messages
- An **extendable fluent builder** (factory) to create forms easily with **the additional needed logic** (CSRF, label, tooltip...)
- **Tools** to render forms with **twig**
- Some extendable default render engines for popular html frameworks like **Bootstrap** or **Foundation**
- **Standards for rendering** that make every engine compatible


Usage
-----

**Project is under heavy development** and doc will come when the API is frozen or more stable.

Here is an example of how the library works :

```php

use UForm\Builder;


$form = 
     // initialize the form with aciton and method
    Builder::init("action", "POST")
     // Add some input text with some validation rules
    ->text("firstname", "Firstname")->required()->stringLength(2, 20) 
    ->text("lastname", "Lastname")->required()->stringLength(2, 20)
    ->text("login", "Login")->required()->stringLength(2, 20)
    // Add an input password
    ->password("password", "Password")->required()->stringLength(2, 20)
    // Get the form instance
    ->getForm();



if (isset($_POST)) {
    //If its a post query we validate the form with the post data
    $formContext = $form->validate($_POST);
    if ($formContext->isValid()) {
        $filteredData = $formContext->getData();
        // Do some logic with data
    }
} else {
    // Or else we just generate a context with empty values
    $formContext = $form->generateContext([]);
}

// We want to render some html for bootstrap 3
$render = new Bootstrap3Render();
$html = $render->render($formContext);

echo $html;

```

Known Issues
------------

### Bootstrap3 Render

- Some additional css may be need to render bootstrap3 correctly: [additional css](https://github.com/gsouf/UForm/blob/gh-pages/render/Bootstrap3.md#additional-css)

### Foundation5 Render

- Some additional css may be needed to have a proper render: [additional css](https://github.com/gsouf/UForm/blob/gh-pages/render/Foundation5.md#additional-css)
- Foundation does not support inlined elements

Thanks
------

Thanks to @andresgutierrez for the 
[Phalcon form component](https://github.com/phalcon/cphalcon/tree/master/phalcon/forms) 
that served as inspiration for this one.
