CSRF Protection
===============

[CSRF protection](https://en.wikipedia.org/wiki/Cross-site_request_forgery)
is necessary for security reason.

UForm's builder takes care of CSRF processing and can check
the validity of a given token. The only one condition is that
you tell it how to retrieve and check token validity.

Implement CSRF Interface
-------------------------

The first step is to implement the interface ``UForm\Validator\Csrf\CsrfInterface``

The following example shows you a very basic CSRF example:

```php
  <?php

  use UForm\Validator\Csrf\CsrfInterface;

  class MyCsrfImplementation implements CsrfInterface
  {

    protected $tokenHandler;

    function __construct(TokenHandler $tokenHandler)
    {
      $this->tokenHandler = $tokenHandler;
    }

    public function getToken(){
      return $this->tokenHandler->getCsrfToken();
    }

    public function tokenIsValid($token){
      return $this->tokenHandler->isValid($token);
    }

  }
```


Tell UForm's builder about your CSRF implementation
----------------------------------------------------

There are two ways to pass a CSRF implementation : **globally** or **locally**

### Set a global CSRF implementation

UForm environment is used to globally store your CSRF implementation.

```php
  use UForm\Environment;
  use UForm\Builder;

  $myCsrfImplementation = new MyCsrfImplementation($myTokenHandler);

  Environment::setCsrfResolver($myCsrfImplementation);

  // Now UForm's builder is aware of your token
  // and it's transparent to use it
  // Just do :
  $form = Builder::init()->getForm();

  // $form is protected by csrf

```

### Set a local CSRF implementation

Sometimes you dont want to put a global instance of the CSRF implementation,
then you can use the builder options:

```php
  use UForm\Environment;
  use UForm\Builder;

  $myCsrfImplementation = new MyCsrfImplementation($myTokenHandler);

  $builderOptions = [
    "csrf" => $myCsrfImplementation
  ];

  $form = Builder::init()->getForm();

  // $form is protected by csrf

```

Change the name of the CSRF element
-----------------------------------

When the builder creates a CSRF, it actually creates and hidden field
with a name set automatically. In some edges cases you want to use
a custom name for this hidden field. The builder option ```csrf-name```
can do it:

```php
  use UForm\Builder;

  $myCsrfImplementation = new MyCsrfImplementation($myTokenHandler);

  $builderOptions = [
    "csrf" => $myCsrfImplementation,
    "csrf-name" => "customName"
  ];

  $form = Builder::init()->getForm();

  // The generated hidden will have the name "customName":
  // <input type="hidden" name="customName" />
```

[View more builder options](../builder.md#options)
