<?php
class amoCRM {
    private $subdomain = "";
    private $client_id = "";
    private $client_secret = "";
    private $grant_type = "";
    private $code = "";
    private $redirect_uri = "";
    private $error = "";
    private $access_token = "";
    private $refresh_token = "";
    private $token_type = "";
    private $expires_in = "";

    public function get_subdomain() {
        return $this->subdomain;
        }
    public function get_client_id() {
        return $this->client_id;
        }
    public function get_client_secret() {
        return $this->client_secret;
        }
    public function get_grant_type() {
        return $this->grant_type;
        }
    public function get_code() {
        return $this->code;
        }
    public function get_redirect_uri() {
        return $this->redirect_uri;
        }
    public function get_error() {
        return $this->error;
        }
    public function get_access_token() {
        return $this->access_token;
        }
    public function get_refresh_token() {
        return $this->refresh_token;
        }
    public function get_token_type() {
        return $this->token_type;
        }
    public function get_expires_in() {
        return $this->expires_in;
        }
    public function set_subdomain($subdomain) {
        $this->subdomain    = $subdomain;
        }
    public function set_client_id($client_id) {
        $this->client_id    = $client_id;
        }
    public function set_client_secret($client_secret) {
        $this->client_secret    = $client_secret;
        }
    public function set_grant_type($grant_type) {
        $this->grant_type    = $grant_type;
        }
    public function set_code($code) {
        $this->code    = $code;
        }
    public function set_redirect_uri($redirect_uri) {
        $this->redirect_uri    = $redirect_uri;
        }
    public function get_tokens() {
        $link = 'https://'.$this->subdomain.'.amocrm.ru/oauth2/access_token';
        $data = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => $this->grant_type,
            'code' => $this->code,
            'redirect_uri' => $this->redirect_uri,
            ];
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out    = curl_exec($curl);
        $code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        if ($code < 200 || $code > 204) {
            $this->error = print_r($code,true)." : ".print_r($out,true);
            return false;
            }
        $response = json_decode($out, true);
        $this->access_token     = $response['access_token'];
        $this->refresh_token    = $response['refresh_token'];
        $this->token_type       = $response['token_type'];
        $this->expires_in       = $response['expires_in'];
        return true;
        }
    public function get_deals($filter="") {
        if (trim($filter)=="") {
            $link = 'https://'.$this->subdomain.'.amocrm.ru/api/v2/leads';
            }
            else {
                $link = 'https://'.$this->subdomain.'.amocrm.ru/api/v2/leads?'.$filter;
                }
        $headers = [
            'Authorization: Bearer '.$this->access_token
            ];
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out    = curl_exec($curl);
        $code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        if ($code < 200 || $code > 204) {
            $this->error = print_r($code,true)." : ".print_r($out,true);
            return false;
            }
        $Response = json_decode($out, true);
        $Response = $Response['_embedded']['items'];
        return $Response;
        }
    public function add_task($id,$type,$txt) {
        $tasks['add'] = array(
            array(
                'element_id' => $id,
                'element_type' => 2,
                'task_type' => $type,
                'text' => $txt,
                )
            );
        $link = 'https://'.$this->subdomain.'.amocrm.ru/api/v2/tasks';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($tasks));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__.'/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__.'/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out    = curl_exec($curl);
        $code   = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        if ($code < 200 || $code > 204) {
            $this->error = print_r($code,true)." : ".print_r($out,true);
            return false;
            }
        return true;
        }
    }
?>
