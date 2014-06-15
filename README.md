UForm
=====

Php reimplemented and refactored version of Phalcon\Form, because the concept is good, but some things were missing

[![Build Status](https://travis-ci.org/SneakyBobito/UForm.png)](https://travis-ci.org/SneakyBobito/UForm)

What has been Refactored
========================

Filtering Improved and simplified
---------------------------------

* No more sanitize notion, only simple filter that you can use has any object
* Filter definition is easier : possibility to do it with closures
* No more need to DI to use it : use it easily in any application

Element Management
------------------

Management of elements has been refactored.

The first problem was the hard implementation of grouped elements.



Rendering Refactoring
---------------------

Some stuff has been updated :

* input id are now more suitable.