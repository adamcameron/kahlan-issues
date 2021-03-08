# Replicating Kahlan bugs

This has a repro case for [Bug: cannot stub method without using 'methods' option](https://github.com/kahlan/kahlan/issues/380).

I have tracked it down to some incompatibility with / interference from the `laminas/laminas-code` package.

I do not install this directly, but it's a dependency of `symfony/polyfill-php80` which is installed as part of Symfony 5.

How to use this portable repro case:

```shell
git clone git@github.com:adamcameron/kahlan-issues.git
cd kahlan-issues
docker build -t kahlan-issues .
docker run -it --rm --name kahlan-issues kahlan-issues /bin/bash
vendor/bin/kahlan --no-header=true --cc=true
```

This will display the error:
```shell
F.                                                                  2 / 2 (100%)


Tests of various Kahlan issues
  Tests of issue 380: Bug: cannot stub method without using "methods" option
    ✖ it should be possible to stub a method without using 'methods' option
      expect->toBe() failed in `.spec/someClass.spec.php` line 19

      It expect actual to be identical to expected (===).

      actual:
        (string) "real value"
      expected:
        (string) "stubbed value"


Expectations   : 4 Executed
Specifications : 0 Pending, 0 Excluded, 0 Skipped

Passed 1 of 2 FAIL (FAILURE: 1) in 0.006 seconds (using 2MB)
```

To demonstrate `laminas/laminas-code` is causing the problem

```shell
composer remove laminas/laminas-code
vendor/bin/kahlan --no-header=true --cc=true
```

And you will see the tests now pass. 

I have replicated this natively on Windows 10 as well, without having Docker in the mix.
