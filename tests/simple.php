<?php

require('../micro-test.php');

MicroTest::run(Array(
                     'Test is being run' => function() {
                        MicroTest::expectationOK();
                        },
                    'shouldFail' => function() {
                        MicroTest::shouldFail();
                        MicroTest::expectationFailed();
                        MicroTest::shouldNotFail();
                        MicroTest::expectationOK();
                    },
                    'ok' => function() {
                        MicroTest::ok(true);
                        MicroTest::ok(1);
                        MicroTest::shouldFail();
                        MicroTest::ok(false);
                        MicroTest::ok(0);
                    },
                    'isEqual' => function(){
                        MicroTest::isEqual(1, true);
                        MicroTest::isEqual(1, 1);
                        MicroTest::isEqual(1, true);
                        
                        MicroTest::shouldFail();
                        MicroTest::isEqual(1, false);
                        MicroTest::isEqual(1, '11');
                    },
                    'isIdentical' => function(){
                        MicroTest::isIdentical(false, false);
                        MicroTest::isIdentical(1, 1);
                        MicroTest::isIdentical(Array(1=>'1'), Array(1=>'1'));
                        
                        MicroTest::shouldFail();
                        MicroTest::isIdentical(1, true);
                        MicroTest::isIdentical(true, null);
                        MicroTest::isIdentical(Array(1=>'1'), Array(1=>'2'));
                    },
                    'isNull' => function(){
                        MicroTest::isNull(null);
                        
                        MicroTest::shouldFail();
                        MicroTest::isNull(false);
                    },
                    'isNull' => function(){
                        MicroTest::isNull(null);
                        
                        MicroTest::shouldFail();
                        MicroTest::isNull(false);
                    },
                    'isNotNull' => function(){
                        MicroTest::isNull(null);
                        
                        MicroTest::shouldFail();
                        MicroTest::isNull(false);
                    },
));

echo MicroTest::resultsHTML();

