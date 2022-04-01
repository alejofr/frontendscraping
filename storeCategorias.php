<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$datosRecibidos = file_get_contents("php://input");

$data = json_decode($datosRecibidos);

$precio = $data->precio;

if ( strpos($precio, ',') ){
    $precio = str_replace(',','',$data->precio);
}

$datos = [
      "site_id" => "MCO",
      "title" => $data->titulo,
      "category_id" => $data->categoria,
      //"seller_id" => 542052125,
      //"official_store_id" => null,
      "price" => $precio,
      "currency_id" => "COP",
      "available_quantity" => 1,
      "buying_mode" => "buy_it_now",
      "condition" => "new",
      "listing_type_id" => "free",
      "pictures" => $data->images,
      "description" => $data->descripcion,
      "attributes" => [
            0 => [
                "id" => "BRAND",
                "value_name" => "Marca del producto"
             ],
            1 => [
                "id" => "EAN",
                "value_name" => "7898095297749"
             ]
         ]
       
];

$datos = json_encode($datos);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mercadolibre.com/items");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

curl_setopt_array($ch, array(
    // Indicar que vamos a hacer una petici贸n POST
    CURLOPT_CUSTOMREQUEST => "POST",
    // Justo aqu铆 ponemos los datos dentro del cuerpo
    CURLOPT_POSTFIELDS => $datos,
    // Encabezados
    //CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array(
         "Content-Type: application/json",
        "Authorization : Bearer ".$data->token
    ),
));


$response = curl_exec($ch);
curl_close($ch);

echo $response;


?>