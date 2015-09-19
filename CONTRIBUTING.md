Contributing
============


Contributions need to be tested
-------------------------------

Any contribution is welcome but your contribution needs to be tested.

If you add a class to the library, then create the unit test matching 
for the class is a test method method by class method.

Some examples are available : https://github.com/gsouf/UForm/tree/master/test/suites/UForm/Test

If your contribution fixes an existing issue, please add an annotation ``@fixes #issueNumber``

If you need to write more global tests, please put them into
https://github.com/gsouf/UForm/tree/master/test/suites/UForm/Test/Scenario 


Before merging
--------------

Please make sure to check that your modifications are not breaking the unit test :

``phpunit -c phpunit.dist.xml``

And make sure your code respects the coding standards 

``./test/bin/phpcs.bash emacs``

You can fix some errors automatically by running ``./test/bin/phpcbf.bash``