<?php

namespace App\Service;

use Exception;
use GuzzleHttp\Client;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;

class EmailService
{
    private $apiInstance;

    public function __construct()
    {
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $_ENV["SENDINBLUE"]);
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    public function sendTransactionalEmail($userEmail, $templateId, $params)
    {
        $sendSmtpEmail = new SendSmtpEmail();
        $sendSmtpEmail['to'] = array(array('email' => $userEmail));
        $sendSmtpEmail['templateId'] = $templateId;
        $sendSmtpEmail['params'] = $params;

        try {
            return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            // Gérez les erreurs en renvoyant une exception ou en renvoyant un message d'erreur adapté à votre utilisation
            //throw $e;
            echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
        }
    }
}