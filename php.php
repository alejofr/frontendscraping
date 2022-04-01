<?php 

$datosRecibidos = file_get_contents("php://input");
$data = json_decode($datosRecibidos);
$datos = [
      "site_id" => "MLV",
      "title" => $data->titulo,
      "category_id" => $data->categoria,
      "price" => str_replace('.','',$data->precio),
      "currency_id" => "USD",
      "available_quantity" => 1,
      "buying_mode" => "buy_it_now",
      "condition" => "new",
      "listing_type_id" => "free",
      "pictures" => $data->images,
      //"description" => $data->descripcion
       
];

$datos = json_encode($datos);



/*$ch = curl_init();

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
$token = "APP_USR-48223952437252-033112-1a85ec5fc9b6e01c4ca5a015739952d0-542052125";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.mercadolibre.com/sites/MCO/categories');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);


curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization : Bearer ".$token
));

$response = curl_exec($ch);
curl_close($ch);

//echo $response;

//print("<br>");

$images = [
    0 => ["source" => "https://m.media-amazon.com/images/I/71vFKBpKakL._AC_SX466_.jpg"]
];

              "seller" => [
          "id" => 542052125,
          "power_seller_status" => null,
          "car_dealer" =>false,
          "real_estate_agency" =>false,
        ],

$datos = [
      //"site_id" => "MCO",
      "title" => "computadora",
      //"seller_id" => 542052125,
      //"official_store_id" => null,
      "category_id" => "MCO449878",
      "price" => 290000,
      "currency_id" => "COP",
      "available_quantity" => 1,
      "buying_mode" => "buy_it_now",
      "condition" => "new",
      "listing_type_id" => "free",
      "sale_terms" => [
            0 => [
                "id" => "WARRANTY_TYPE",
                "value_name" => "Garantía del vendedor"
             ],
            1 => [
                "id" => "WARRANTY_TIME",
                "value_name" => "90 días"
             ]
        ],
      "pictures" => $images
      /*"attributes" => [
            0 => [
                "id" => "BRAND",
                "value_name" => "Marca del producto"
             ],
            1 => [
                "id" => "EAN",
                "value_name" => "7898095297749"
             ]
         ]
      //"description" => $data->descripcion
       
];

//print_r($datos);
$datos = json_encode($datos);
//echo $datos;

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
        "Authorization : Bearer ".$token
    ),
));


$response = curl_exec($ch);
curl_close($ch);

echo $response;

$ch = curl_init();

$urlSeller ='https://api.mercadolibre.com/categories/MCO441917';

curl_setopt($ch, CURLOPT_URL, $urlSeller);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);


curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization : Bearer ".$token
));

$response = curl_exec($ch);
curl_close($ch);

// echo $response;*/
{"cause":[],"message":"Invalid token","error":"not_found","status":401}
[{"department":"items","cause_id":126,"type":"error","code":"item.category_id.invalid","references":["item.category_id"],"message":"Is not allowed to post in category MCO417044. Make sure you're posting in a leaf category"}]}