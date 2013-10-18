<?php
/**
 * Small testing framework.
 *
 * @author Kaspars Foigts
 * @link http://github.com/laacz/php-microtest
 */
class MicroTest {

    static $tests = Array();
    static $current_test = null;
    static $shouldFail = false;

    /**
     * Assertion did not fail.
     */
    static function expectationOK() {
        self::$tests[self::$current_test]['assertions'][] = Array('success' => !self::$shouldFail, 'backtrace' => debug_backtrace());
    }

    /**
     * Assertion failed.
     */
    static function expectationFailed() {
        self::$tests[self::$current_test]['assertions'][] = Array('success' => self::$shouldFail, 'backtrace' => debug_backtrace());
    }

    /**
     * Flag that further test case assertions should fail.
     */
    static function shouldFail() {
        self::$shouldFail = true;
    }

    /**
     * Flag that further test case assertions should not fail.
     */
    static function shouldNotFail() {
        self::$shouldFail = false;
    }

    static function ok($a) {
        $a ? self::expectationOK() : self::expectationFailed();
    }

    static function isEqual($a, $b) {
        self::ok($a == $b);
    }

    static function isIdentical($a, $b) {
        self::ok($a === $b);
    }

    static function isNull($a) {
        self::ok($a === null);
    }

    static function isNotNull($a) {
        self::ok($a !== null);
    }

    /**
     * Adds tests.
     */
    static function add($tests) {
        foreach ($tests as $name=>$test) {
            self::$tests[$name] = Array('test' => $test, 'result' => null, 'assertions' => Array());
        }
    }

    /**
     * Empty tests.
     */
    static function removeTests() {
        self::$tests = Array();
    }

    /**
     * Runs tests.
     */
    static function run($tests = array()) {
        self::add($tests);

        foreach (self::$tests as $name=>$test) {
            self::$current_test = $name;
            self::shouldNotFail();
            self::$tests[$name]['result'] = $result = $test['test']();
        }

    }

    /**
     * Just quick and dirty results output to HTML.
     */
    static function resultsHTML() {
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=utf-8');
        }
        $return = '';
        $return .= '<style>
        #mtresults {
            font-family: sans-serif;
            font-size: 10pt;
        }

        #mtresults thead th {
            background-color: #ccc;
        }

        #mtresults tbody th {
            text-align: left;
            background-color: #f0f0f0;
        }

        #mtresults tbody td {
            font-family: monospace;
        }

        #mtresults th,
        #mtresults td {
            padding: .2em 1em;
        }

        #mtresults tfoot {
            font-size: 140%;
        }

        #mtresults tfoot th {
            background-color: #ccc;
            text-align: right;
        }

        #mtresults tfoot td {
            background-color: #f0f0f0;
        }

        #mtresults tfoot tr.success td {
            color: #090;
        }

        #mtresults tfoot tr.failure td {
            color: #c00;
        }

        </style>';
        $return .= '<table id="mtresults"><thead><tr><th>Test</th><th>Assertions</th><th>Result</th></tr></thead><tbody?';
        $assertions_ok = $assertions_failed = $tests_ok = $tests_failed = 0;
        foreach (self::$tests as $name=>$test) {
            $return .= '<tr><th>' . $name . '</th><td>';
            $success = true;
            foreach ($test['assertions'] as $assertion) {
                $return .= $assertion['success'] ? '<span style="color: #9c9;">✔</span>' : '<span style="color: #c99;">✘</span>';
                $success = $success && $assertion['success'];

                if ($assertion['success']) {
                    $assertions_ok++;
                } else {
                    $assertions_failed++;
                }

            }

            $return .= '</td><td>';
            $return .= $success ? '<span style="color: #090;">✔</span>' : '<span style="color: #900;">✘</span>';
            $return .= '</td></tr>';

            if ($success) {
                $tests_ok++;
            } else {
                $tests_failed++;
            }

        }
        $return .= '</tbody>';

        $return .= '<tfoot><tr class="success"><th><span style="color: #090;">✔</span></th><td>' . $assertions_ok . '</td><td>' . $tests_ok . '</td></tr>';
        $return .= '<tr class="failure"><th><span style="color: #900;">✘</span></th><td>' . $assertions_failed . '</td><td>' . $tests_failed . '</td></tr>';

        $return .= '</foot></table>';
        return $return;
    }

    /**
     * Just quick and dirty results output to HTML.
     */
    static function resultsPlain() {
        $assertions_ok = $assertions_failed = $tests_ok = $tests_failed = 0;
        $return = '';
        foreach (self::$tests as $name=>$test) {
            $success = true;
            $assertions_str = "";
            foreach ($test['assertions'] as $assertion) {
                $success = $success && $assertion['success'];

                if ($assertion['success']) {
                    $assertions_ok++;
                    $assertions_str .= "x";
                } else {
                    $assertions_failed++;
                    $assertions_str .= "v";
                }

            }

            if (!$success) {
                $return .= "$name: Failed. Individual assertions: $assertions_str\n";
            }

            if ($success) {
                $tests_ok++;
            } else {
                $tests_failed++;
            }

        }
        $return .= "Success: $assertions_ok assertions in $tests_ok tests\n";
        $return .= "Failure: $assertions_failed assertions in $tests_failed tests\n";
        return $return;
    }
}
