<?php
use Codeception\Util\HttpCode;

class NegativeTestsCest
{
    public function testData($type)
    {
        $auth = require('src\Clases\Users.php');
        $data = require('src\Clases\RequestData.php');

        if($type == 'auth'){
            return $auth;
        }
        if($type == 'data') {
            return $data;
        }
    }

    public function verifyValidTransWrongAuth(ApiTester $I)
    {
        $I->haveHttpHeader($this->testData('auth')['InvalidAuth']['Basic'], $this->testData('auth')['InvalidAuth']['BasicValue']);
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
                "address" => "Panda Street, China"]]);

        $I->seeResponseCodeIs(401);

        $I->seeResponseContains("Access denied");
    }

    public function verifyVoidInvalidTransaction(ApiTester $I)
    {
        $I->haveHttpHeader($this->testData('auth')['ValidAuth']['Basic'], $this->testData('auth')['ValidAuth']['BasicValue']);
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "reference_id" => '2426fd1bfb8test7e049a9cedea4e91', "transaction_type" => "void"
            ]]);

        $I->seeResponseCodeIs(422);

        $I->seeResponseIsJson();

        $I->seeResponseContains("Invalid reference transaction");
    }

    public function verifyValidTransWrongCard(ApiTester $I)
    {
        $I->haveHttpHeader($this->testData('auth')['ValidAuth']['Basic'], $this->testData('auth')['ValidAuth']['BasicValue']);
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "card_number" => $this->testData('data')["Cards"]['invalidCard'],
                "cvv" => "123",
                "expiration_date" => "06/2019",
                "amount" => "500",
                "usage" => "Coffeemaker",
                "transaction_type" => "sale",
                "card_holder" => "Panda Panda",
                "email" => "panda@example.com",
                "address" => "Panda Street, China"]]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseContains("Your transaction has been declined");
    }

}