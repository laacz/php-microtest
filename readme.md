Tiny testing framework for PHP 5.3+
===================================

This is small testing framework, written in PHP, for PHP 5.3+.

It should be extremely easy to use. 

Without crazy OOP, without initializing something, and so on. Everything is static, so you do not need to worry about anything. It does not have any integration with anything.

Quickstart
----------

All you have to do, is run an array of tests:

``` php
require('../micro-test.php');

// Run tests
MicroTest::run(Array(
                     'Small test case' => function() {
                        MicroTest::isIdentical(false, false);
                        },
                    'Twice as previous' => function() {
                        MicroTest::isNull(null);
                        MicroTest::isNotNull(false);
                    },
));

// Output ugly HTML results
MicroTest::resultsHTML();
```

API
---

Though, all tests can be done via `MicroTest::ok($value)`, there are some helper methods:

* `MicroTest::isNull($value)`
* `MicroTest::isNotNull($value)`
* `MicroTest::isEqual($a, $b)`
* `MicroTest::isIdentitcal($a, $b)`

If your assertion SHOULD fail, use `MicroTest::shouldFail()`. Following assertions inside current test case will fail, if evaluate to true. If you need to revert this behaviour, use `MicroTest::shouldNotFail()`, of course. For example.

``` php
MicroTest::run(Array(
                     'shouldFail' => function() {
                        MicroTest::isIdentical(false, false);
                        },
                    'should fail 2' => function() {
                        MicroTest::ok(true); // This one is correct.
                        MicroTest::shouldFail();
                        MicroTest::ok(false); // This one fails, but, since we expect it to, it's great success.
                        MicroTest::shouldNotFail();
                        MicroTest::ok(1); // This one does not fail
                    },
));

```