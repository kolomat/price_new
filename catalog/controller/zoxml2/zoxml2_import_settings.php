<?php
class ControllerZoXml2ZoXml2ImportSettings extends Controller {      
	public function index() {
    $json   = array();
    $json[] = "You do not have permission to access this page!";
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  }

	public function add() {
    $json   = array();
    $json[] = "scan: You do not have permission to access this page!";
    $session_key = 'import_settings';
    if (empty($this->request->post['url'])) {
      $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_log SET session_key = '" . $this->db->escape($session_key) . "', type = 'error', data = 'Отсутствует url!', user = '" . $this->db->escape($this->request->post['user']) . "'");
      }
    else {
      $salt = (string)time (); 
      $session_key    = md5 ($salt . $this->request->post['url']);

$xml = simplexml_load_file(html_entity_decode ($this->request->post['url']),"SimpleXMLElement");
//      $ch = curl_init(); 
//      curl_setopt($ch, CURLOPT_URL, html_entity_decode ($this->request->post['url']));
//      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//      curl_setopt($ch, CURLOPT_HEADER, false);
//      curl_setopt($ch, CURLOPT_TIMEOUT, 300); 
//      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//    	$src = curl_exec($ch);
//      curl_close ($ch);
//$dest = DIR_CACHE . $session_key . ".TMP";
//file_put_contents ($dest, $src );

//      $xml = simplexml_load_string ($src, 'SimpleXMLElement', LIBXML_COMPACT);
foreach(libxml_get_errors() as $error) {
  $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_log SET session_key = '0', type = 'error', data = '" . $this->db->escape('Ошибка: ' . $error->message) ."', user = 'Import'");
  }
//      unset ($src);
      if ($xml) {
        if (isset($xml->SupplierMainSettings->settings)) {
          $value = $xml->SupplierMainSettings->settings;
          $data = array(              
      			'module'       => trim($value->module),
      			'name'         => trim($value->name),
      			'url'          => trim($value->url),
      			'license'      => trim($value->license),
      			'session_key'  => $session_key,
            'supplier'     => trim($value->supplier),
            'before'       => trim($value->before),
            'images'       => trim($value->images),
            'link'         => trim($value->link),
            'add_before'   => trim($value->add_before),
            'mul_after'    => trim($value->mul_after),
            'add_after'    => trim($value->add_after),
            'before_mode'  => trim($value->before_mode),     
            'stores'       => isset($value->stores)?trim($value->stores):0,
            'image_save_to'     => isset($value->image_save_to)?trim($value->image_save_to):$session_key,
            'image_save_as'     => isset($value->image_save_as)?trim($value->image_save_as):'url',
            'option_image_save_as'     => isset($value->option_image_save_as)?trim($value->option_image_save_as):'old',
            'curl_options'      => isset($value->curl_options)?trim($value->curl_options):'',
            'zo_image_loader'   => isset($value->zo_image_loader)?trim($value->zo_image_loader):'file_get_contents',
            'hide_by_attribute' => isset($value->hide_by_attribute)?trim($value->hide_by_attribute):'0',
            'user_exception'    => isset($value->user_exception)?trim($value->user_exception):'0',
            'user_exceptions'   => isset($value->user_exceptions)?trim($value->user_exceptions):'',
            'getXML_method'     => isset($value->getXML_method)?trim($value->getXML_method):'simplexml_load_file',
            'meta_keyword'      => isset($value->meta_keyword)?trim($value->meta_keyword):'',
            'meta_description'  => isset($value->meta_description)?trim($value->meta_description):'',
            'meta_title'        => isset($value->meta_title)?trim($value->meta_title):'',
            'meta_h1'           => isset($value->meta_h1)?trim($value->meta_h1):'',
            'seo_title'         => isset($value->seo_title)?trim($value->seo_title):'',
            'seo_h1'            => isset($value->seo_h1)?trim($value->seo_h1):'',
            'tag'               => isset($value->tag)?trim($value->tag):'',
            'sku'               => isset($value->sku)?trim($value->sku):'',
            'name_tpl'          => isset($value->name_tpl)?trim($value->name_tpl):'',
            'url_tpl'           => isset($value->url_tpl)?trim($value->url_tpl):'',
            'model_tpl'         => isset($value->model_tpl)?trim($value->model_tpl):'',
            'tag_shop'          => isset($value->tag_shop)?trim($value->tag_shop):'shop',
            'tag_offers'        => isset($value->tag_offers)?trim($value->tag_offers):'offers',
            'tag_offer'         => isset($value->tag_offer)?trim($value->tag_offer):'offer',
            'tag_categories'    => isset($value->tag_categories)?trim($value->tag_categories):'categories',
            'tag_category'      => isset($value->tag_category)?trim($value->tag_category):'category',
            'round_mode'        => isset($value->round_mode)?trim($value->round_mode):4,
            'price_table'       => isset($value->price_table)?trim($value->price_table):'',
            'dov_required'      => isset($value->dov_required)?trim($value->dov_required):0,
            'dov_price_prefix'  => isset($value->dov_price_prefix)?trim($value->dov_price_prefix):'+',
            'dov_subtract'      => isset($value->dov_subtract)?trim($value->dov_subtract):0,
            'dov_quantity'      => isset($value->dov_quantity)?trim($value->dov_quantity):1,
            'dov_price'         => isset($value->dov_price)?trim($value->dov_price):0,
            'quantity'          => isset($value->quantity)?trim($value->quantity):1,
            'minimum'           => isset($value->minimum)?trim($value->minimum):1,
            'subtract'          => isset($value->subtract)?trim($value->subtract):1,
            'stock_status_id'   => isset($value->stock_status_id)?trim($value->stock_status_id):5,
            'tax_class_id'      => isset($value->tax_class_id)?trim($value->tax_class_id):'',
            'length_class_id'   => isset($value->length_class_id)?trim($value->length_class_id):'',
            'weight_class_id'   => isset($value->weight_class_id)?trim($value->weight_class_id):'',
            'weight_to_attr'    => isset($value->weight_to_attr)?trim($value->weight_to_attr):0,   
            'length_to_attr'    => isset($value->length_to_attr)?trim($value->length_to_attr):0,   
            'width_to_attr'     => isset($value->width_to_attr)?trim($value->width_to_attr):0,   
            'height_to_attr'    => isset($value->height_to_attr)?trim($value->height_to_attr):0,   
            'l_w_h_to_attr'     => isset($value->l_w_h_to_attr)?trim($value->l_w_h_to_attr):0,   
            'l_w_h_template'    => isset($value->l_w_h_template)?trim($value->l_w_h_template):'{length}/{width}/{height}',   
            'stock_id'          => isset($value->stock_id)?trim($value->stock_id):0,
            'max_image_size'    => !empty($value->max_image_size)?trim($value->max_image_size):'',
            'img_path'          => isset($value->img_path)?trim($value->img_path):'',
            );
                    
          if (isset($value->link2category_ids))     $data['link2category_ids'] = 1;
          if (isset($value->ms_seller))             $data['ms_seller'] = trim($value->ms_seller);
          if (isset($value->auto_atributes))        $data['auto_atributes'] = 1;
          if (isset($value->hide_missing))          $data['hide_missing'] = 1;
          if (isset($value->zero_missing))          $data['zero_missing'] = 1;
          if (isset($value->user_exceptions_attributes)) $data['user_exceptions_attributes'] = (array)$value->user_exceptions_attributes;
          if (isset($value->xml2cache))             $data['xml2cache'] = 1;
          if (isset($value->price_table4mc))        $data['price_table4mc'] = 1;
          if (isset($value->hide))                  $data['hide'] = 1;
          if (isset($value->hide_new))              $data['hide_new'] = 1;
          if (isset($value->noindex_new))           $data['noindex_new'] = 1;
          if (isset($value->log_new))               $data['log_new'] = 1;
          if (isset($value->insert))                $data['insert'] = 1;
          if (isset($value->update))                $data['update'] = 1;
          if (isset($value->update_price))          $data['update_price'] = 1;
          if (isset($value->update_special))        $data['update_special'] = 1;
          if (isset($value->update_image))          $data['update_image'] = 1;
          if (isset($value->update_quantity))       $data['update_quantity'] = 1;
          if (isset($value->update_name))           $data['update_name'] = 1;
          if (isset($value->update_description))    $data['update_description'] = 1;
          if (isset($value->update_category))       $data['update_category'] = 1;
          if (isset($value->update_atributes))      $data['update_atributes'] = 1;
          if (isset($value->update_vendor))         $data['update_vendor'] = 1;
          if (isset($value->update_sku))            $data['update_sku'] = 1;
          if (isset($value->update_ean))            $data['update_ean'] = 1;
          if (isset($value->update_minimum))        $data['update_minimum'] = 1;
          if (isset($value->update_upc))            $data['update_upc'] = 1;
          if (isset($value->update_jan))            $data['update_jan'] = 1;
          if (isset($value->update_isbn))           $data['update_isbn'] = 1;
          if (isset($value->update_mpn))            $data['update_mpn'] = 1;
          if (isset($value->update_model))          $data['update_model'] = 1;
          if (isset($value->update_weight))         $data['update_weight'] = 1;
          if (isset($value->update_l_w_h))          $data['update_l_w_h'] = 1;
          if (isset($value->update_stock_status_id))$data['update_stock_status_id'] = 1;
          if (isset($value->no_update))             $data['no_update'] = 1;
          if (isset($value->not_empty_only))        $data['not_empty_only'] = 1;
          if (isset($value->user_filter))           $data['user_filter'] = trim($value->user_filter);
          if (isset($value->user_scan))             $data['user_scan'] = trim($value->user_scan);
          if (isset($value->user_xml_pre))          $data['user_xml_pre'] = trim($value->user_xml_pre);
          if (isset($value->user_start))            $data['user_start'] = trim($value->user_start);
          if (isset($value->user_pre))              $data['user_pre'] = trim($value->user_pre);
          if (isset($value->user_ro))               $data['user_ro'] = trim($value->user_ro);
          if (isset($value->user_after))            $data['user_after'] = trim($value->user_after);
          if (isset($value->insert_analyzer))       $data['insert_analyzer'] = trim($value->insert_analyzer);
          if (isset($value->update_analyzer))       $data['update_analyzer'] = trim($value->update_analyzer);
          if (isset($value->update_use_script))     $data['update_use_script'] = trim($value->update_use_script);
          if (isset($value->after))                 $data['after']  = 1;
          if (isset($value->link_vendor))           $data['link_vendor']  = 1;
          if (isset($value->link_supplier))         $data['link_supplier']  = 1;
        
          if (isset($value->default_atribute_group))  $data['default_atribute_group']  = trim($value->default_atribute_group);
          else                                        $data['default_atribute_group']  = 0;
          if (isset($value->auto_atributes_db))       $data['auto_atributes_db']  = trim($value->auto_atributes_db);
          else                                        $data['auto_atributes_db']  = "common";
        
          if (isset($value->language))               $data['language'] = trim($value->language);
          else                                       $data['language'] = $this->config->get( 'config_language_id' );
          if (isset($value->all_languages))          $data['all_languages'] = trim($value->all_languages);

          $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_suppliers SET session_key = '" . $this->db->escape($session_key) . "', data = '" . $this->db->escape(json_encode($data)) ."'");
          $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_log SET session_key = '" . $this->db->escape($session_key) . "', type = 'info', data = '" . $this->db->escape($value->name . ' добавлен в список поставщиков.') ."', user = '" . $this->db->escape($this->request->post['user']) . "'");
          }
       if (isset($xml->SupplierMainSettings->options->option)) {
          foreach ($xml->SupplierMainSettings->options->option as $key => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_options SET   session_key = '" . $this->db->escape($session_key) . "', `name` = '" . $this->db->escape($value['name']) . "', `dest_type` = '" . $this->db->escape(trim($value)) . "', `data` = '" . $this->db->escape($value['data']) . "'");
            }
          }
       if (isset($xml->SupplierMainSettings->replaces->replace)) {
          foreach ($xml->SupplierMainSettings->replaces->replace as $value) {
            if (isset($value->sort_order))  $sort_order  = trim($value->sort_order);
            else                            $sort_order  = 0;
            if (isset($value->type))        $type  = trim($value->type);
            else                            $type  = 'description';
            if (isset($value->mode))        $mode  = trim($value->mode);
            else                            $sort_order  = 'replace';
            if (isset($value->txt_before))  $txt_before  = trim($value->txt_before);
            else                            $txt_before  = '';
            if (isset($value->txt_after))   $txt_after  = trim($value->txt_after);
            else                            $txt_after  = '';
  			   $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_replace SET   `session_key` = '" . $this->db->escape($session_key) . "', 
                        type = '" . $this->db->escape($type) . "', 
                        mode = '" . $this->db->escape($mode) . "', 
                        txt_before = '" . $this->db->escape($txt_before) . "', 
                        txt_after = '" . $this->db->escape($txt_after) . "', 
                        sort_order = '" . (int)$sort_order . "'");
            }
          }           
        }
      else {
        foreach(libxml_get_errors() as $error) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "zoxml2_log SET session_key = '0', type = 'error', data = '" . $this->db->escape('Ошибка: ' . $error->message) ."', user = 'Import'");
          }
        }
      }


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  }

}
