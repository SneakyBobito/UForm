UForm
=====

[![Build Status](https://travis-ci.org/gsouf/UForm.svg)](https://travis-ci.org/gsouf/UForm)
[![Test Coverage](https://codeclimate.com/github/SneakyBobito/UForm/badges/coverage.svg)](https://codeclimate.com/github/SneakyBobito/UForm/coverage)
[![Code Climate](https://codeclimate.com/github/SneakyBobito/UForm/badges/gpa.svg)](https://codeclimate.com/github/SneakyBobito/UForm)


UForm is a form validation/filtering/rendering library that solve all the problems I had with other similar libraries.
It is mostly based on the Phalcon\Form one, but totaly refactored to be more flexible.

The library is tested then stable.

Build status
============

[![Build Status](https://travis-ci.org/SneakyBobito/UForm.png)](https://travis-ci.org/SneakyBobito/UForm)



Installation
============

The library is [available on packagist](https://packagist.org/packages/sneakybobito/uform) :

```json
{
    "require": {
        "sneakybobito/uform": "v0.0.2-beta"
    }
}
```

Usage
=====

DOC INCOMING...


ROADMAP
=======

* [x] Subrendering (render only one child from a group)
* [ ] Filters / validators interaction with rendering
* [ ] csrf
* [ ] full form rendering + deep attribute definition
* [ ] collection/group detailled rendering + deep attribute definition
* [ ] not empty checkbox
* [ ] complet element types
* [ ] complet filters
* [ ] complet validators
* [ ] make a doc
* [ ] select improvement (multi, default value, invalidation) + test
* [ ] textarea test
* [x] implement collection array
* [ ] globalize form and render context methods
* [ ] globalize error messages in render context