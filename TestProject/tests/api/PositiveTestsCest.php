<?php

use Codeception\Util\HttpCode;
use Methods\data;

class PositiveTestsCest
{
    public $unique_id;

    // tests
    public function verifyValidTransaction(ApiTester $I)
    {
        $I->amGoingTo("Send a valid transaction");

        data::Authentication($I, "validAuth");

        data::validPaymentTransactions($I, "validCard", "validCVV", "validAmount");

        $I->seeResponseMatchesJsonType([
            "unique_id" => "string",
            "status" => "string",
            "usage" => "string",
            "amount" => "integer",
            "transaction_time" => "string:date ",
            "message" => "string"]);

        $I->seeResponseContains("Your transaction has been approved.");

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();

        $unique_id = $I->grabDataFromResponseByJsonPath('$..unique_id');

        return $unique_id;
    }

    public function verifyVoidTransaction(ApiTester $I)
    {
        $I->amGoingTo("Void a valid transaction");

        data::Authentication($I, "validAuth");

        data::voidPaymentTransactions($I, $this->verifyValidTransaction($I)[0]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();

        $I->seeResponseContains("voided successfully");
    }

}