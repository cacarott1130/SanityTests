<?php
use Codeception\Util\HttpCode;

class PositiveTestsCest{

public function methodCall (){
    $methods = include_once('src\Methods\Functions.php');
    return $methods;
}


    // tests
    public function verifyValidTransaction(ApiTester $I)
    {
        $I->amGoingTo("Send a valid transaction");
        $this->methodCall().\Methods\data::Authentication($I, "ValidAuth");

        $this->methodCall().\Methods\data::paymentTransactions($I, "validCard", "validCVV", "validAmount");

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
        $this->methodCall().\Methods\data::Authentication($I, "ValidAuth");
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "reference_id" => $this->verifyValidTransaction($I)[0], "transaction_type" => "void"
            ]]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();

        $I->seeResponseContains("voided successfully");
    }

}