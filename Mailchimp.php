<?php
/*
 * Classe de Integração com Mailchimp <https://mailchimp.com>
 */

/**
 * Integração da API do Mailchimp utilizando PHP
 * Documentação: <https://developer.mailchimp.com/documentation/mailchimp/reference/root/>
 *
 * @author Davson Santos: DavTech - Soluções Inteligentes
 * @URL https://davtech.com.br
 */
class Mailchimp
{

    private $API_KEY;
    private $LIST_ID;
    private $AUTH;
    private $SERVER;
    private $DATA;
    private $DEBUG = TRUE;
    private $EMAIL;
    private $RESULT;
    private $OPTION = "PUT"; //PUT; DELETE;

    public function __construct($API_KEY, $LIST_ID, $SERVER)
    {
        $this->API_KEY = $API_KEY;
        $this->LIST_ID = $LIST_ID;
        $this->SERVER = $SERVER;
        $this->AUTH = base64_encode('user:' . $this->API_KEY);
    }

    public function setLeadList($Data)
    {
       
        $this->EMAIL = md5(strtolower($Data['email']));
        $this->DATA = [
            'apikey' => $this->API_KEY,
            'email_address' => $Data['email'],
            'status' => 'subscribed',
            ];
            
         (!empty($Data['name']) ? $this->DATA['merge_fields']['FNAME'] = $Data['name']: NULL );
         (!empty($Data['lastname']) ? $this->DATA['merge_fields']['LNAME'] = $Data['lastname']: NULL );
         (!empty($Data['addr1']) ? $this->DATA['merge_fields']['ADDRESS']['addr1'] = $Data['addr1']: NULL );
         (!empty($Data['addr2']) ? $this->DATA['merge_fields']['ADDRESS']['addr2'] = $Data['addr2']: NULL );
         (!empty($Data['city']) ? $this->DATA['merge_fields']['ADDRESS']['city'] = $Data['city']: NULL );
         (!empty($Data['state']) ? $this->DATA['merge_fields']['ADDRESS']['state'] = $Data['state']: NULL );
         (!empty($Data['zip']) ? $this->DATA['merge_fields']['ADDRESS']['zip'] = $Data['zip']: NULL );
         (!empty($Data['country']) ? $this->DATA['merge_fields']['ADDRESS']['country'] = $Data['country']: NULL );
         (!empty($Data['birthday']) ? $this->DATA['merge_fields']['BIRTHDAY'] = $Data['birthday']: NULL );
         (!empty($Data['phone']) ? $this->DATA['merge_fields']['BIRTHDAY'] = $Data['phone']: NULL );
        $this->DATA = json_encode($this->DATA);
        return $this->MailchimpAuth();
    }

    private function MailchimpAuth()
    {        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->SERVER . '.api.mailchimp.com/3.0/lists/' . $this->LIST_ID . '/members/'. $this->EMAIL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->OPTION); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic ' . $this->AUTH));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->DATA);
        $this->RESULT = curl_exec($ch);
        if ($this->DEBUG):
            return json_decode($this->RESULT);
        endif;        
        
        
    }
}
