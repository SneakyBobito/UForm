Contributing
============


Contributions need to be tested
-------------------------------

Any contribution is welcome but your contribution needs to be tested.


If you add a class to the library, then create the test matching 
the class. Try to add a test method by class method.
You must annotate the test with ``@covers ClassName`` 
([info](https://phpunit.de/manual/current/en/appendixes.annotations.html#appendixes.annotations.covers))

Some examples are available : https://github.com/gsouf/UForm/tree/master/test/suites/UForm/Test

Keep these test simple : the goal is to cover 100% of the code to avoid any mistake or typo.
Try to cover obvious edge cases. Weird issues should be reported in the issue tracker 
and a test covering this issue will be created.

If your contribution fixes an existing issue, please create 
a specific test for it and add an annotation ``@issue #issueNumber``

If you need to write more global tests, please put them into
https://github.com/gsouf/UForm/tree/master/test/suites/UForm/Test/Scenario
Scenario test must be annotated with ``@codeCoverageIgnore``
([info](https://phpunit.de/manual/current/en/appendixes.annotations.html#appendixes.annotations.codeCoverageIgnore))
in order to no generate coverage


Before merging
--------------

Please make sure to check that your modifications are not breaking the unit test :

``phpunit -c phpunit.dist.xml``

And make sure your code respects the coding standards 

``./test/bin/phpcs.bash emacs``

You can fix some errors automatically by running ``./test/bin/phpcbf.bash``
