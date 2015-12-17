UForm's builder
===============

Options
-------

Some options are avaible to configure the builder.


### csrf

That allows to set a custom
[CSRF implementation](validation/csrf-protection.md)
for CSRF protection.

Set it to false to disable CSRF validation.

Leave it null to use the Environment validation.

Note: If you it null and if you dont have an environment CSRF
then CSRF protection will be disabled

### csrf-name

Set the name of the CSRF input.
[More informations]((validation/csrf-protection.md))
