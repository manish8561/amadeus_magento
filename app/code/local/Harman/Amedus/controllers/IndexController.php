<?php 
/**
 * Amedus Index Controller for frontend
 *
 * @category    Amedus
 * @package     Harman_Amedus
 * @author      Manish Sharma <manish198646@yahoo.com>
 */
class Harman_Amedus_IndexController extends Mage_Core_Controller_Front_Action{
    /*form display function*/
    public function IndexAction() {      
      $this->loadLayout();   
      $this->getLayout()->getBlock("head")->setTitle($this->__("Flight Search"));
      $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link"  => Mage::getBaseUrl()
      ));

      $breadcrumbs->addCrumb("flight search", array(
            "label" => $this->__("Flight Search"),
            "title" => $this->__("Flight Search")
      ));

      $this->renderLayout(); 	  
    }
    /*Flight Autocomplete action*/
    public function autocompleteAction(){
      $helper = Mage::helper('amedus');
      $post = $this->getRequest()->getPost();
      if($term = trim($post['term'])){
        $results = $helper->location_search($term);
        if(count($results['airports']) > 0){
          $this->getResponse()->setBody(json_encode($results['airports']));
        }        
      }
      
    }
    /* Flight serach action */
    public function searchAction(){
      $get = $this->getRequest()->getParams();
      /*echo '<pre>';
      print_R($get);*/ 
      if(!empty($get)){
        $helper = Mage::helper('amedus');
        extract($get);

        if(!isset($no_adults)){
          $no_adults = '1';
        }
        $adults=$no_adults;
        if(!isset($no_children)){
          $no_children = 0; 
        }
        if(!isset($no_infants)){
          $no_infants = 0; 
        }

        $departure_date=date_create($departure_date);
        $departure_date = date_format($departure_date,"Y-m-d");

        if(trim($origin_label) == ''){       
          $exp = explode('[', $origin);
          $exp = explode(']', $exp[1]);
          $origin_label = $exp[0];
        }
        if(trim($destination_label) == ''){        
          $exp = explode('[', $destination);
          $exp = explode(']', $exp[1]);
          $destination_label = $exp[0];
        }

        $basic_params2['adults']=$adults;
        if($no_children > 0) {
          $basic_params2['children']=$no_children;
        }
        if($no_infants > 0) {
          $basic_params2['infants']=$no_infants;
        }   

        $basic_params2['origin']=$origin_label;
        $basic_params2['destination']=$destination_label;
        $basic_params2['departure_date']=$departure_date;
        $basic_params2['travel_class']=$travel_class;


        if($is_return=='yes')
        {
          $return_date=date_create($return_date);
          $return_date = date_format($return_date,"Y-m-d");
          $basic_params2['return_date']=$return_date;
        }
        $currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
    

        /* $basic_params2['nonstop']='true';*/       

        $basic_params2['currency']=$currency_code;

        if(!isset($limit)){
          $limit = 12;
        }
        $basic_params2['number_of_results']=$limit;

        /*calling amedus api from this function */
        $results = $helper->low_fare_search($basic_params2);
       /* echo '<pre>';
        print_R($results); die;*/

        if(isset($results['message']) and trim($results['message']) !=''){
          Mage::getSingleton('core/session')->setFlightError(trim($results['message']));
          $this->_redirect('*/*');
          return;
        } else {
        //print_r($results); exit;
          Mage::register('flight_results', $results);
          $this->loadLayout();   
          $this->getLayout()->getBlock("head")->setTitle($this->__("Flight Search Results"));

          $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
          $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link"  => Mage::getBaseUrl()
          ));

          $breadcrumbs->addCrumb("flight search", array(
            "label" => $this->__("Flight Search Results"),
            "title" => $this->__("Flight Search Results")
          ));

            $this->renderLayout(); 
        }
      }else {
        $this->_redirect('*/*');
        return;
      }      
    }
    /*flight product view function*/
    public function viewAction(){
        $post = $this->getRequest()->getPost();
        if(!empty($post) or 1){
          Mage::register('product_result', $post);
          $this->loadLayout();   
          $this->getLayout()->getBlock("head")->setTitle($this->__("Flight"));

          $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
          $breadcrumbs->addCrumb("home", array(
                  "label" => $this->__("Home Page"),
                  "title" => $this->__("Home Page"),
                  "link"  => Mage::getBaseUrl()
             ));

          $breadcrumbs->addCrumb("flight search", array(
                  "label" => $this->__("Flight"),
                  "title" => $this->__("Flight")
             ));

          $this->renderLayout(); 
        } else {
          $this->norouteAction();
          return;
        }  
    }
    /* flight product save function*/
    /*public function saveAction(){
      $json['success'] = 'NOK';
      $post = $this->getRequest()->getPost();
      if(!empty($post)){
        print_r($post);
        exit;
        $json['product_id'] = '1';
        $json['success'] = 'OK';
      }
      $this->getResponse()->setBody(json_encode($json));
    }*/

}