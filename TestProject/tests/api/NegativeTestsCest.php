<?php

use Codeception\Util\HttpCode;
use Methods\data;
require_once "PositiveTestsCest.php";
include_once('src\Methods\Functions.php');

class NegativeTestsCest
{

    public function verifyTransactionWrongAuth(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with an incorrect authentication");

        data::Authentication($I, "invalidAuth");

        data::validPaymentTransactions($I, "validCard", 'validCVV', "validAmount");

        $I->seeResponseCodeIs(401);

        $I->seeResponseContains("Access denied");
    }

    public function verifyTransactionNoAuth(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with no authentication");

        data::Authentication($I, "noAuth");

        data::validPaymentTransactions($I, "validCard", 'validCVV', "validAmount");

        $I->seeResponseCodeIs(500);

        $I->seeResponseContains("Internal Server Error");
    }

    public function verifyTransactionNoAuthHeader(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with no authentication header");

        data::validPaymentTransactions($I, "validCard", 'validCVV', "validAmount");

        $I->seeResponseCodeIs(401);

        $I->seeResponseContains("Access denied");
    }

    public function verifyTransactionNoBody(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with no body");

        data::Authentication($I, "validAuth");

        $I->sendPOST("/payment_transactions");

        $I->seeResponseCodeIs(400);

        $I->seeResponseContains("Bad Request");
    }



    public function verifyTransactionWrongCard(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with an incorrect card number");

        data::Authentication($I, "validAuth");

        data::validPaymentTransactions($I, "invalidCard", "validCVV", "validAmount");

        $I->seeResponseCodeIs(200);

        $I->seeResponseContains("Your transaction has been declined");
    }


    public function verifyTransactionWrongCVV(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with an incorrect CVV number");

        data::Authentication($I, "validAuth");

        data::validPaymentTransactions($I, "validCard", "invalidCVV", "validAmount");

        $I->seeResponseCodeIs(422);

        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array("cvv" => ["is invalid"]));
    }

    public function verifyTransactionWrongAmount(ApiTester $I)
    {
        $I->amGoingTo("Send a transaction with an incorrect amount");

        data::Authentication($I, "validAuth");

        data::validPaymentTransactions($I, "validCard", "validCVV", "invalidAmount");

        $I->seeResponseCodeIs(422);

        $I->seeResponseIsJson();

        $I->seeResponseContainsJson(array("amount" => ["must be greater than 0"]));

    }

    public function verifyVoidInvalidTransaction(ApiTester $I)
    {
        $I->amGoingTo("Void a transaction with an incorrect RefID");

        data::Authentication($I, "validAuth");

        data::voidPaymentTransactions($I, "2426fd1bfb8test7e049a9cedea4e91");

        $I->seeResponseCodeIs(422);

        $I->seeResponseIsJson();

        $I->seeResponseContains("Invalid reference transaction");
    }
}