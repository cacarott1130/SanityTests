# SanityTests

### Introduction
This is a simple PHP, codeception test application used to cover a payment gateway API with santity test related to Sale and Void transaction.

### Tools used
1. composer;
2. flow/jsonpath;
2. codeception;

### How to install tool

## Composer
Download and install from "https://getcomposer.org/download/".

## flow/jsonpath

$composer require flow/jsonpath

## Codeception
$composer require codeception/codeception --dev


### Running Tests

## Usage
$codecept run: run all tests
$codecept run api: run all api tests
$codecept run api PositiveTestsCest: Run only PositiveTestsCest
$codecept run api MyCest:myTestName: run one test from a Cest

## Verbosity modes
$codecept run -v:
$codecept run --steps: print step-by-step execution
$codecept run -vv:
$codecept run --debug: print steps and debug information
$codecept run -vvv: print internal debug information