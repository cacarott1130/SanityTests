<?php
use Codeception\Util\HttpCode;

class FirstApiTestCest{
    public function userAuth()
    {
        $Auth = require('src\Clases\Users.php');
        return $Auth;
    }


    // tests
    public function verifyValidTransaction(ApiTester $I)
    {
        $I->haveHttpHeader($this->userAuth()['ValidAuth']['Basic'], $this->userAuth()['ValidAuth']['BasicValue']);
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "card_number" => "4200000000000000",
                "cvv" => "123",
                "expiration_date" => "06/2019",
                "amount" => "500",
                "usage" => "Coffeemaker",
                "transaction_type" => "sale",
                "card_holder" => "Panda Panda",
                "email" => "panda@example.com",
                "address" => "Panda Street, China"]]
        );

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
        $I->haveHttpHeader($this->userAuth()['ValidAuth']['Basic'], $this->userAuth()['ValidAuth']['BasicValue']);
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "reference_id" => $this->verifyValidTransaction($I)[0], "transaction_type" => "void"
            ]]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();

        $I->seeResponseContains("voided successfully");
    }


}