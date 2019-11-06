<?php
    namespace app;

    class Util{

    static function pegarParametro(){
    
        if(isset($_SERVER['PATH_INFO'])){
            $request = array_pop(explode('/', trim($_SERVER['PATH_INFO'],'/')));
            return $request;
        }
        
    }

    function json_format($json){
        
        $tab = "  ";
        $new_json = "";
        $indent_level = 0;
        $in_string = false;

        $json_obj = json_decode($json);

        if($json_obj === false)
            return false;

        $json = json_encode($json_obj);
        $len = strlen($json);

        for($c = 0; $c < $len; $c++)
        {
            $char = $json[$c];
            switch($char)
            {
                case '{':
                case '[':
                    if(!$in_string)
                    {
                        $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
                        $indent_level++;
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case '}':
                case ']':
                    if(!$in_string)
                    {
                        $indent_level--;
                        $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case ',':
                    if(!$in_string)
                    {
                        $new_json .= ",\n" . str_repeat($tab, $indent_level);
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case ':':
                    if(!$in_string)
                    {
                        $new_json .= ": ";
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case '"':
                    if($c > 0 && $json[$c-1] != '\\')
                    {
                        $in_string = !$in_string;
                    }
                default:
                    $new_json .= $char;
                    break;                   
            }
        }

        return $new_json;
    } 

    // function gerarJwt(){

    //     $key = "sua-mae";

    //     //Gerando o header do jwt
    //     $header = [
    //         'alg' => 'HS256',
    //         'typ' => 'JWT'
    //     ];

    //     $header = json_encode($header);
    //     $header = base64_encode($header);

    //     //Gerando o payload do jwt
    //     $payload = [
    //         'iss' => 'testeAPI',
    //         'username' => 'usuarioteste'
    //     ];

    //    $payload = json_encode($payload);
    //    $payload = base64_encode($payload);
       
    //    //Gerando a signature do jwt
    //    $signature = hash_hmac('sha256', "$header.$payload", $key, true);
    //    $signature = base64_encode($signature);

    //    $token = "$header.$payload.$signature";

    //     echo $token;

    // }

    function gerarAssinatura($value){
        
        $x = "testedeseguranca";
        $value = $value.$x;
       
        $fp=fopen('chaves/private.pem', "r");
        $privateKeyString=fread($fp, 8192);
        $pkeyid = openssl_pkey_get_private($privateKeyString);
        openssl_sign($value, $signature, $pkeyid);
        return base64_encode($signature);
    }

    function verificaAssinatura($value, $signature, $keyPath){

        $x = "testedeseguranca";
        $value = $value.$x;
       
        $pubKey = file_get_contents($keyPath);
        $pubKeyData = openssl_get_publickey($pubKey);
        $result = openssl_verify($value, base64_decode($signature), $pubKeyData, OPENSSL_ALGO_SHA1);
        openssl_free_key($pubKeyData);
        
        return $result;
    }

}

?>