<?php

namespace kahlanIssues\spec;

use Kahlan\Plugin\Double;
use kahlanIssues\SomeClass;

describe('Tests of various Kahlan issues', function () {

   describe('Tests of issue 380: Bug: cannot stub method without using "methods" option', function () {
        it("should be possible to stub a method without using 'methods' option", function () {
            $someObject = new SomeClass();

            expect($someObject->myMethodWithoutReturnType())->toBe('real value');

            $double = Double::instance(['extends' => SomeClass::class]);
            allow($double)->toReceive('myMethodWithoutReturnType')->andReturn('stubbed value');

            expect($double->myMethodWithoutReturnType())->toBe('stubbed value');
        });

        it("works when I use 'methods' option", function () {
            $someObject = new SomeClass();

            expect($someObject->myMethodWithoutReturnType())->toBe('real value');

            $double = Double::instance(['extends' => SomeClass::class, 'methods'=>['myMethodWithoutReturnType']]);
            allow($double)->toReceive('myMethodWithoutReturnType')->andReturn('stubbed value');

            expect($double->myMethodWithoutReturnType())->toBe('stubbed value');
        });
    });
});
