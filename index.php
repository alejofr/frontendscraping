<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Meli\Api\OAuth20Api(
    new GuzzleHttp\Client()
);


if(  isset($_GET['code']) ){
    if(  isset($_GET['client_id']) && isset($_GET['client_secret']) && isset($_GET['redirect_url'])){
        $grant_type = 'authorization_code';
        $client_id = $_GET['client_id'];
        $client_secret = $_GET['client_secret'];
        $redirect_uri = $_GET['redirect_url'];
        $code = $_GET['code']; 
        $refresh_token = '';

        try {
            $result = $apiInstance->getToken($grant_type, $client_id, $client_secret, $redirect_uri, $code, $refresh_token);
               $resultado = $result[0];
      
            http_response_code(200);
            echo  $result[0];
        } catch (Exception $e) {
            http_response_code(400);
          echo json_encode($e->getMessage());
           //$grant_type = 'authorization_code';
    
       
            //echo 'Exception when calling OAuth20Api->getToken: ', $e->getMessage(), PHP_EOL;
        }
        
    }else{
        echo $_GET['code'];
    }
}else if( isset($_GET['token']) && !isset($_GET['id_cate']) && !isset($_GET['id_anterior']) ){
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.mercadolibre.com/sites/MCO/categories');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization : Bearer ".$_GET['token']
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    /*$categorias = json_decode($response);
    print_r($categorias);
    $token = $_GET['token'];
    
    for ($i=0; $i < count($categorias) ; $i++) { 
        repeatCateg($i, $categorias[$i]->id, $categorias);
    }*/
    
    
    echo $response;
}else if( isset($_GET['id_cate']) && isset($_GET['token']) ){
    $id = $_GET['id_cate'];
    
    $urlSeller ='https://api.mercadolibre.com/categories/'.$id.'';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlSeller);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization : Bearer ".$_GET['token']
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    
    $categoria = json_decode($response);
    $token = $_GET['token'];
    
    //print_r($categoria);
    
    $categorias = [];
    
    $categorias['id'] = $categoria->id;
    $categorias['name'] = $categoria->name;
    
    if ( isset($categoria->children_categories) && count($categoria->children_categories) != 0 ){
        $categorias['children_categories'] = $categoria->children_categories;
    }else{
        $categorias['children_categories'] = "null";
    }
    
    echo json_encode($categorias);
    
    /*if ( isset($categoria->children_categories) && count($categoria->children_categories) != 0 ){
        
        
       $categorias = $categoria->children_categories;
  
    
       for ($i=0; $i < count($categorias) ; $i++) { 
            repeatCateg($i, $categorias[$i]->id, $categorias);
        }
        
    }else{
        $categoria->children_categories = "null";
        $categorias = $categoria;
    }
 
  
    
  
   echo json_encode($categorias);*/
    
}else if( isset($_GET['id_anterior']) && isset($_GET['token']) ){
    $id = $_GET['id_anterior'];
    
    $urlSeller ='https://api.mercadolibre.com/categories/'.$id.'';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $urlSeller);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization : Bearer ".$_GET['token']
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    
    $categoria = json_decode($response);
    $token = $_GET['token'];
    
    $categorias = [];
    //print_r($categoria);
    $categorias['path_from_root'] = "null";
    $categorias['name'] = "";
    
    if ( isset($categoria->path_from_root) && count($categoria->path_from_root) != 0 ){
        $path_from_root = $categoria->path_from_root;
        
        if ( count($path_from_root) > 1 ){
            $i = count($path_from_root) - 1;
            $i = $i - 1;
            $categorias['path_from_root'] = $path_from_root[$i]->id;
            $categorias['name'] = $path_from_root[$i]->name;
        }
        
        
        //print_r($path_from_root);
        
        //echo $path_from_root[$i]->id;
        
        
        /*if( $path_from_root[0]->id != $_GET['id_anterior'] ){
            $categorias['path_from_root'] = $path_from_root[0]->id;
            $categorias['name'] = $path_from_root[0]->name;
        }*/
    }
    
       
    echo json_encode($categorias);
}

function repeatCateg($indice, $id, $categorias){
    $categoria = json_decode(getCateg($id));
    
     if ( isset($categoria->children_categories) && count($categoria->children_categories) != 0 ){
        $categorias[$indice]->children_categories = "nonull";
    }else{
        $categorias[$indice]->children_categories = "null";
    }
        
}


function getCateg($id){
    $ch = curl_init();
    
    $urlSeller ='https://api.mercadolibre.com/categories/'.$id.'';

    curl_setopt($ch, CURLOPT_URL, $urlSeller);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization : Bearer ".$token
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}







?>
