<?php
namespace src;

class BitlyShortener
{
    private const token = '8a8d2e466491316e556207578cd79671432035ab';
    public static function shortener($long_link = 'https://www.youtube.com/watch?v=yThuwsKIFm8&t=820s'){

        $requestBody = json_encode(
                                    [
                                        "domain"=> "bit.ly",
                                        "long_url"=> $long_link
                                    ]);

        if(is_null($token = getBitlyToken())){
            return 'Please Provide token in bitly.php in config folder ' ;
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-ssl.bitly.com/v4/shorten',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$requestBody,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.config('bitly.token'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response) ;
        return isset($response->link) ? $response->link:'Check URL Is Correct OR ON' ;

    }
}
