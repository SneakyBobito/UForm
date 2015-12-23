File Upload
===========

Html forms allow to send files through http post requests.

UForm builder manages it very well:

```php

$builder->file("someFile", "Some File");

```

That will render some [html input file](http://www.w3.org/TR/html-markup/input.file.html):

```html

<label>Some File</label>
<input type="file" name="someFile">

```

Multiple files and accept type
------------------------------

It is possible to add additional controls to the form with 
[multiple](http://www.w3schools.com/tags/att_input_multiple.asp) and 
[accept](http://www.w3schools.com/tags/att_input_accept.asp) attributes:

```php

$builder->file("someFile", "Some File", true, ".png,.gif");

```

The third and fourth parameters are respectively ``multiple`` and ``accept`` attributes.

```html

<label>Some File</label>
<input type="file" name="someFile" multiple accept=".png,.gif">

```

Validation
----------

By default adding a file from the builder will ensure that the file is either null 
or a valid file (with successful upload).
You will have to add the required validator to ensure that the input data is a valid file:

```php

$builder->file("someFile", "Some File")
    ->required();

```

### File type

TODO




Work with the file
------------------

Php uses to manage files uploads with the global array ``$_FILES``. The structure of ``$_FILES`` is not very convenient
and thus UForm translates it to a set of ``UForm\FileUpload`` instances.

### move the file at the good place

When a file is uploaded it is placed in the temporary directory and will be destroyed when the script exits. If you 
want to conserve the file you will have to store it at the place of your convenience:

```php

$formContext->getData()->findValue("myFile")->moveTo("uploadDirectory/myfile.png");

```

This way the file will be moved to ``uploadDirectory/myfile.png``.


About upload security
--------------------

If you import the data with the method ``$form->getInputFromGlobals()`` then
the [is_uploaded_file](http://php.net/manual/fr/function.is-uploaded-file.php) check will be processed.
