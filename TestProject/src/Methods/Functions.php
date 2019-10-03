<?php


namespace Methods;

class data
{
    public static function testData($type)
    {
        $auth = require('src\Clases\Users.php');
        $data = require('src\Clases\RequestData.php');

        if($type == 'auth'){
            return $auth;
        }
        if($type == 'data'){
            return $data;
        }
    }

    public static function Authentication($I, $Auth)
    {
        $I->haveHttpHeader(data::testData('auth')[$Auth]['Basic'], data::testData('auth')[$Auth]['BasicValue']);
    }



    public static function validPaymentTransactions($I, $Card, $CVV, $Amount)
    {
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "card_number" => data::testData('data')['Cards'][$Card],
                "cvv" => data::testData("data")["CVV"][$CVV],
                "expiration_date" => "06/2019",
                "amount" => data::testData('data')['Amount'][$Amount],
                "usage" => "Coffeemaker",
                "transaction_type" => "sale",
                "card_holder" => "Panda Panda",
                "email" => "panda@example.com",
                "address" => "Panda Street, China"]]
        );

    }

    public static function voidPaymentTransactions($I, $RefID){
        $I->sendPOST("/payment_transactions",
            ["payment_transaction" => [
                "reference_id" => $RefID, "transaction_type" => "void"
            ]]);
    }

}