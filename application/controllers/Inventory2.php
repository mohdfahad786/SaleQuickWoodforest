<?php 
ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Inventory extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Home_model');
	    $this->load->model('profile_model');
		$this->load->model('admin_model');
		$this->load->model('session_checker_model');
  		if (!$this->session_checker_model->chk_session_merchant()) {
  		  	redirect('login');
  		}
		date_default_timezone_set("America/Chicago");
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
	}

  	public function editInventory() {
	    // Call the verification method and store the return value in the variable
	    $data = array(); 
	    $in_id = $this->uri->segment(3);
	    $merchant_id = $this->session->userdata('merchant_id');
		
		$stmt = $this->db->query("SELECT `id`,item_id,title, `name`,sku, `price`, `tax`,`quantity`,sold_quantity, category_id, `item_image` as itemImage,mode,title FROM `adv_pos_item` where merchant_id='".$merchant_id."' and id='".$in_id."'  and status=0 order by id desc");
			
		$package_data = $stmt->result_array();
		$data['package_data'] = $package_data;

		$stmt_cat = $this->db->query("SELECT id,index_id,name FROM `adv_pos_category` where merchant_id='".$merchant_id."'  order by index_id desc");
			
		$package_data_cat = $stmt_cat->result_array();
		$data['package_data_cat'] = $package_data_cat;

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;

		$data['bct_id'] = $in_id;
		//echo $package_data[0]['item_id'];
		//print_r($package_data);  die();
		// echo '<pre>';print_r($data);die;

		$data['meta'] = "Edit Item";
		$data['upload_loc'] = base_url()."uploads/item_image";
		$data['loc'] = "edit_Inventory";
		$data['action'] = "Update Item";
		$this->load->view('merchant/edit_inventory', $data);
	}

	public function edit_Inventory() {
		// echo '<pre>';print_r($_FILES);die;
		$merchantId = $this->session->userdata('merchant_id');
		$id = $_POST['bct_id'];
		$itemCategory = $_POST['category_id'];
		$itemName = $_POST['name'];
		$tax = $_POST['tax'];
		$sku = $_POST['sku'];
		$price = $_POST['price'];

		$mode = $_POST['mode'];
		$title = strtolower($_POST['title']);
		$itemId = $_POST['item_id'];
		if(empty($_POST['quantity'])) {
			$quantity = 'I';
		} else {
			if($_POST['quantity'] == '∞') {
				$quantity = 'I';
			} else {
				$quantity = $_POST['quantity'];
			}
		}
		// $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 'I';
		// $item_image_old =$_POST['item_image_old'];

		// if ( isset($_FILES['item_image']['name']) && ($_FILES['item_image']['name'] != '') ) {
		// 	$date = date("mdHis");
		// 	$image = $_FILES['item_image']['name'];
		// 	$exp = explode(".", $image);
		// 	$extension = end($exp);
		// 	$image_name = strtolower("adv_pos_item") . "_" . $merchantId . "_" . $date . "." . $extension;
            
  //           $config['file_name'] = $image_name; 
  //           $config['upload_path'] = './uploads/item_image/';
  //           $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
  //           $config['max_size'] = 1000;
  //           $config['max_width'] = 3024;
  //           $config['max_height'] = 3068;
  //           $this->load->library('upload', $config);

  //           if ($this->upload->do_upload('item_image')) {
  //           	$data = array('upload_data' => $this->upload->data());
  //           	// $this->load->view('upload_success', $data);
  //           	$uploadedFileName=$data['upload_data']['file_name']; 
  //           }
  //           $image_name =$uploadedFileName;
  //        	// echo "1"; die();

		// } else {
		// 	$image_name = $item_image_old;
		// 	// echo "2"; die();
		// }
		// if($mode==0){
		// 	$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."',`item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		
		// } elseif ($mode==1 && $title=='regular') {
		// 	$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."',`item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		// }

		// $stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_id`='".$itemId."',`category_id`='".$itemCategory."',`name`='".$itemName."', `sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."', `quantity`='".$quantity."', `item_image`='".$image_name."' WHERE `id`='".$id."'  and `merchant_id` ='".$merchantId."'");

		if($mode==0){
			$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		
		} elseif ($mode==1 && $title=='regular') {
			$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		}

		$stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_id`='".$itemId."',`category_id`='".$itemCategory."',`name`='".$itemName."', `sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."', `quantity`='".$quantity."' WHERE `id`='".$id."'  and `merchant_id` ='".$merchantId."'");

		//print_r($this->db->last_query());
		//die();

		$this->session->set_flashdata("success", "Data Has Been Updated.");
		redirect('pos/inventorymngt');
    }

    public function update_item_image() {
    	// echo '<pre>';print_r($_POST);print_r($_FILES);die;
    	$response = array();
		$merchantId = $this->session->userdata('merchant_id');
		// $itemId = $_POST['item_id'];
		$id = $_POST['bct_id'];

		if ( isset($_FILES['item_image']['name']) && ($_FILES['item_image']['name'] != '') ) {
			$date = date("mdHis");
			$image = $_FILES['item_image']['name'];
			$exp = explode(".", $image);
			$extension = end($exp);
			$image_name = strtolower("adv_pos_item") . "_" . $merchantId . "_" . $date . "." . $extension;
            
            $config['file_name'] = $image_name;
            $config['upload_path'] = './uploads/item_image/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
            $config['max_size'] = 10000;
            $config['max_width'] = 3024;
            $config['max_height'] = 3068;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('item_image')) {
            	$data = array('upload_data' => $this->upload->data());
            	// $this->load->view('upload_success', $data);
            	$uploadedFileName=$data['upload_data']['file_name']; 
	            $image_name =$uploadedFileName;

	            // $smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
	            $stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_image`='".$image_name."' WHERE `id`='".$id."'  and `merchant_id` ='".$merchantId."'");
	            $response['status'] = 'success';
	            $response['msg'] = $image_name;
	            echo json_encode($response);die;

            } else {
            	$response['status'] = 'error';
	            $response['msg'] = 'Error! Image not uploaded.';
	            echo json_encode($response);die;
            }
         	// echo "1"; die();

		} else {
			$response['status'] = 'error';
            $response['msg'] = 'Error! Please select an image to upload.';
            echo json_encode($response);die;
			// echo "2"; die();
		}
    }

    public function remove_category_image() {
      	$merchant_id = $this->session->userdata('merchant_id');
      	$id = $this->uri->segment(3);

      	// $stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_image`='' WHERE `id`='".$id."'  and `merchant_id` ='".$merchant_id."'");
      	// echo 200;
      	$data = array('item_image' => NULL);
		$this->db->where('id', $id);
		if($this->db->update('adv_pos_item', $data)) {
			echo 200;die;
		} else {
			echo 500;die;
		}
    }

    public function addProductVariant() {
	    $merchant_id = $this->session->userdata('merchant_id');
    	$data = array(); 
	    $parent_id = $this->uri->segment(3);
	    $stmt = $this->db->query("SELECT name as product_name, category_id FROM `adv_pos_item_main` where merchant_id='".$merchant_id."' and id='".$parent_id."'  and status=0 order by id desc");
	    // echo '<pre>';print_r($package_data);die;
	    $package_data = $stmt->row();
		$data['product_name'] = $package_data->product_name;
		$data['cat_id'] = $package_data->category_id;

		$stmt_cat = $this->db->query("SELECT id,index_id,name FROM `adv_pos_category` where merchant_id='".$merchant_id."'  order by index_id desc");	
		$package_data_cat = $stmt_cat->result_array();
		$data['package_data_cat'] = $package_data_cat;

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;

		$data['parent_id'] = $parent_id;
		
		$data['meta'] = "Add Item";
		$data['upload_loc'] = base_url()."uploads/item_image";
		$data['loc'] = "addVariantSubmit";
		$data['action'] = "Add Item";
		$this->load->view('merchant/add_variant', $data);
    }

    public function addVariantSubmit() {
		// echo '<pre>';print_r($_FILES);die;
		$merchantId = $this->session->userdata('merchant_id');
		$parent_id = $_POST['parent_id'];
		$itemCategory = $_POST['category_id'];
		$itemName = $_POST['name'];
		$tax = $_POST['tax'];
		$sku = $_POST['sku'];
		$price = $_POST['price'];
		$product_name = $_POST['title'];

		$mode = $_POST['mode'];
		$title = strtolower($_POST['name']); //
		$itemId = $parent_id;
		if(empty($_POST['quantity'])) {
			$quantity = 'I';
		} else {
			if($_POST['quantity'] == '∞') {
				$quantity = 'I';
			} else {
				$quantity = $_POST['quantity'];
			}
		}

		$stmt = $this->db->query("INSERT INTO `adv_pos_item` SET `category_id`='".$itemCategory."',`item_id`='".$itemId."',`mode`='".$mode."',`title`='".$itemName."',`name`='".$product_name."', `sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."', `quantity`='".$quantity."',`merchant_id`='".$merchantId."',`item_image`=''");

		$this->session->set_flashdata("success", "Product variant added successfully.");
		redirect('pos/inventorymngt');
    }

    public function editInventory2() {
	    // Call the verification method and store the return value in the variable
	    $data = array(); 
	    $in_id = $this->uri->segment(3);
	  
	    $merchant_id = $this->session->userdata('merchant_id');
		$path = "https://salequick.com/uploads/item_image/";
		$stmt = $this->db->query("SELECT `id`,item_id,title,barcode_data, `name`,sku, `price`, `tax`,`quantity`,sold_quantity, category_id, `item_image` as itemImage,mode FROM `adv_pos_item` where merchant_id='".$merchant_id."' and id='".$in_id."'  and status=0 order by id desc");
				
		// if (isset($_POST['catID'], $_POST['subCatID'])) {
		// 	$stmt = $this->db->query("SELECT `id`, `name`,sku, `price`, `tax`,`quantity`,sold_quantity, category_id,size,  `item_image` as itemImage,mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and sub_category_id='".$_POST['subCatID']."' and status=0 order by id desc");
			
		// } else if (isset($_POST['catID'])) {
		// 	$stmt = $this->db->query("SELECT item_id,category_id, `name`,GROUP_CONCAT(id) as 'id',GROUP_CONCAT(sku) as 'sku', GROUP_CONCAT(`price`) as 'price',GROUP_CONCAT(`title`) as 'title',tax,GROUP_CONCAT(`quantity`) as 'quantity',GROUP_CONCAT(sold_quantity) as 'sold_quantity', `item_image` as itemImage,mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and item_id !=0 and status=0 group by item_id
		// 	UNION SELECT item_id,category_id, `name`,`id`,sku, `price`,title, `tax`,`quantity`,sold_quantity,  `item_image` as itemImage, mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and category_id='".$_POST['catID']."' and item_id=0 and status=0  order by id desc");
			
		// } else {
		// 	$stmt = $this->db->query("SELECT item_id,category_id, `name`,GROUP_CONCAT(id) as 'id',GROUP_CONCAT(sku) as 'sku', GROUP_CONCAT(`price`) as 'price',GROUP_CONCAT(`title`) as 'title', tax,GROUP_CONCAT(`quantity`) as 'quantity',GROUP_CONCAT(sold_quantity) as 'sold_quantity',  `item_image` as itemImage, mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and item_id !=0 and status=0 group by item_id
		// 	UNION SELECT item_id,category_id, `name`,`id`,sku, `price`,title, `tax`,`quantity`,sold_quantity, `item_image` as itemImage , mode,barcode_data FROM `adv_pos_item` where merchant_id='".$_POST['merchant_id']."' and  item_id=0 and status=0  order by id desc");
			
		// }
			
		$posItems = array();
		$package_data = $stmt->result_array();
		$data['package_data'] = $package_data;
		$data['bct_id'] = $in_id;
		//echo $package_data[0]['item_id'];
		//print_r($package_data); 
  		$data['meta'] = "Edit Item";
    	$data['loc'] = "add_tax";
    	$data['action'] = "Add New Tax";
      	
      	$this->load->view('merchant/edit_inventory', $data);
		//die();
			
		$mem = array();
        if (isset($package_data)) {
			foreach ($package_data as $each) {
			    $package['item_id'] = $each['item_id'];
				$package['category_id'] = $each['category_id'];
				$package['name'] = $each['name'] ? $each['name'] : "" ;
				$package['prod_mode'] = $each['mode'] ? $each['mode'] : "0";
				// $package['remaningQuantity'] = $quantity - $sold_quantity;
				//$package['itemImage'] = $each['itemImage'] ? $each['itemImage'] : "";
				
				if(!empty($each['itemImage'])) {
                  	$package['itemImage'] = $path.$each['itemImage'];
				} else {
					$package['itemImage'] = "";
				}
            	$package['tax'] = $each['tax'] ? $each['tax'] : "";
				//$titleList=is_null($each['title']) ? $each['title'] : "Regular"  ; 
				//$titleList= $each['title'] ? $each['title'] : "Regular" ;
				$titleList= $each['title'] ? $each['title'] : "Regular"  ;
				$package['barcode_data']= $each['barcode_data'] ? $each['barcode_data'] : ""  ;
				 
				//   String to Array  
				$idarray=explode(",",$each['id']);
				$skuarray=explode(",",$each['sku']);
				$pricearray=explode(",",$each['price']);
				$taxarray=explode(",",$each['tax']);
				$quantityarray=explode(",",$each['quantity']);
				$titleListarray=explode(",",$titleList);   //  is_null($title) ? "Regular" : $each['title'] 
				$sold_quantityarray=explode(",",$each['sold_quantity']);
				$regularIndex=array_search("Regular", $each['titleListarray'],false);
				$countOfSku=count($skuarray);
				if($countOfSku > 0) {
					$listData=array();
					$listData2 = array();
					for($i=0; $i < $countOfSku; $i++){
					    if(strtolower($titleListarray[$i])=="regular"){
    					    $temp12 = array();
    						$temp12['id'] = $idarray[$i];
                            $temp12['sku'] = $skuarray[$i];
    						$temp12['price'] = $pricearray[$i];
    				        $temp12['remaningQuantity'] = $quantityarray[$i] - $sold_quantityarray[$i];
    						$temp12['quantity'] = $quantityarray[$i];
    						$temp12['title'] = $titleListarray[$i] ? $titleListarray[$i] : "";
    						$temp12['soldQuantity'] = $sold_quantityarray[$i];
    						
    						array_push($listData2, $temp12);
					    } else {
    						$temp2 = array();
    						$temp2['id'] = $idarray[$i];
                            $temp2['sku'] = $skuarray[$i];
    						$temp2['price'] = $pricearray[$i];
    						$temp2['quantity'] = $quantityarray[$i];
    						$temp2['title'] = $titleListarray[$i] ? $titleListarray[$i] :"";
    						$temp2['soldQuantity'] = $sold_quantityarray[$i];
					        $temp2['remaningQuantity'] = $quantityarray[$i] - $sold_quantityarray[$i];
					        
                            array_push($listData, $temp2);
					    }
					}
					if(!empty($listData2)){
					    $listData= array_merge($listData2,$listData);
					}
				}
				// $price = array_column($listData, 'id');
			    // rsort($price);
			    // array_multisort($price, SORT_desc, $listData);
			    // // usort($listData, make_comparer('id'));
				
				foreach ($listData as $key => $row) {
	                // replace 0 with the field's index/key
	                $ids[$key]  = $row[0];
	            }
            
	            array_multisort($ids, SORT_ASC, $listData);
			    print_r($listData);die;
				$package['tierdata'] = $listData;
			
				$mem[] = $package;
			}
		}	
     	$posItems = $mem;
	}

	public function deleteAdvPOSMainItem() {
     	$merchant_id = $this->session->userdata('merchant_id');
       	$userdata = array();
	   	$item_id =$this->uri->segment(3);
	   
	 	$getDashboard = $this->db->query("SELECT count(*) as cartItem FROM  `adv_pos_cart_item` ci join adv_pos_item i on i.id=ci.item_id where i.item_id='".$item_id."' and i.merchant_id='".$merchant_id."' and i.status=0 and  ci.status=0");
		$getDashboardData = $getDashboard->result_array();
		//print_r($getDashboardData);
        $cartItem = $getDashboardData[0]['cartItem'];
			 
	   	if (isset($cartItem) && $cartItem > 0) {
			$response = ['status' => '401', 'errorMsg' => 'Item not deleted! Item added in cart!'];
		} else {
	   		$branch_info = array(
				'status' => 2,
			);
			$this->admin_model->update_data('adv_pos_item', $branch_info, array('item_id' => $item_id,'merchant_id' => $merchant_id));
			$this->admin_model->update_data('adv_pos_item_main', $branch_info, array('id' => $item_id,'merchant_id' => $merchant_id));

			// $this->session->set_flashdata("success", "POS item tier deleted");
			// redirect('pos/inventorymngt');
     		$response = ['status' => '200', 'successMsg' => 'POS item tier deleted'];
		}
		echo json_encode($response);die;
	}

 	public function deleteAdvPOSItem() {
       	$merchant_id = $this->session->userdata('merchant_id');
       	$userdata = array();
	   	$item_id =$this->uri->segment(3);
	   
	   	$getDashboard = $this->db->query("SELECT count(*) as cartItem FROM `adv_pos_cart_item` where item_id='" . $item_id . "' and merchant_id='" . $merchant_id . "' and status=0 order by id desc ");
		$getDashboardData = $getDashboard->result_array();
        $cartItem = $getDashboardData[0]['cartItem'];
			 
	   	if (isset($cartItem) && $cartItem > 0) {
			$response = ['status' => '401', 'errorMsg' => 'Item not deleted! Item added in cart!'];
		} else {
	   		$branch_info = array(
				'status' => 2,
			);
			$this->admin_model->update_data('adv_pos_item', $branch_info, array('id' => $item_id,'merchant_id' => $merchant_id));
			
    		// Send the return data as reponse
    		// $status = parent::HTTP_OK;
    		$response = ['status' => '200', 'successMsg' => 'POS item tier deleted'];
    		// $this->session->set_flashdata("success", "POS item tier deleted");
			// redirect('pos/inventorymngt');
		}
		echo json_encode($response);die;
	}

	public function all_category() {
		$data['meta'] = "All Category";
		$merchant_id = $this->session->userdata('merchant_id');
		$categories = $this->db->select('id, name, code')
			->where('merchant_id', $merchant_id)
			->order_by('id', 'desc')
			->get('adv_pos_category')->result_array();
		$data['categories'] = $categories;

		$this->load->view('merchant/all_category', $data);
	}

	public function add_category() {
		$data['meta'] = "Add Category";
    	$data['loc'] = "add_category";
    	$data['action'] = "Add Category";
    	if (isset($_POST['submit'])) {
    	  	$this->form_validation->set_rules('name', 'Name', 'required');
    	  	$name = $this->input->post('name') ? $this->input->post('name') : "";
    	  	
    	  	if ($this->form_validation->run() == FALSE) {
    	  	  	$this->load->view("merchant/add_category", $data);

    	  	} else {
    	  	  	$merchant_id = $this->session->userdata('merchant_id');
    	  	  	$ins_data = Array(
    	  	  	  	'merchant_id' => $merchant_id,
    	  	  	  	'name' => $name,
    	  	  	  	'description' => $name,
    	  	  	  	'code' =>strtoupper(str_replace(" ","-",$name)."-".time())
    	  	  	);
    	  	  	$id = $this->admin_model->insert_data("adv_pos_category", $ins_data);
    	  	  	$this->session->set_flashdata("success", "Category added successfully.");
			    redirect('inventory/all_category');
    	  	}
    	} else {
    	  	$this->load->view("merchant/add_category", $data);
    	}
	}

	public function edit_category() {
		$cat_id = $this->uri->segment(3);
		// echo $cat_id;die;
		$merchant_id = $this->session->userdata('merchant_id');
		$category = $this->db->select('id, name')
			->where('merchant_id', $merchant_id)
			->where('id', $cat_id)
			->get('adv_pos_category')->result_array();
		foreach ($category as $cat) {
	        $data['bct_id'] = $cat['id'];
	        $data['name'] = $cat['name'];
	        break;
      	}
		// print_r($data);die;

		$data['meta'] = "Edit Category";
    	$data['loc'] = "edit_category";
    	$data['action'] = "Edit Category";
    	if (isset($_POST['submit'])) {
    	  	$this->form_validation->set_rules('name', 'Name', 'required');
    	  	$name = $this->input->post('name') ? $this->input->post('name') : "";
    	  	$bct_id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
    	  	
    	  	if ($this->form_validation->run() == FALSE) {
    	  	  	$this->load->view("merchant/add_category", $data);

    	  	} else {
    	  	  	$code = strtoupper(str_replace(" ","-",$name)."-".time());
    	  	  	$smtp1 = $this->db->query("UPDATE `adv_pos_category` SET `name`='".$name."',`description`='".$name."',`code`='".$code."' WHERE `id`='".$bct_id."' and `merchant_id` ='".$merchant_id."'");

    	  	  	$this->session->set_flashdata("success", "Category updated successfully.");
			    redirect('inventory/all_category');
    	  	}
    	} else {
    		// print_r($data);die;
    	  	$this->load->view("merchant/add_category", $data);
    	}
	}

	public function delete_category() {
     	$merchant_id = $this->session->userdata('merchant_id');
       	$response = array();
	   	$cat_id =$this->uri->segment(3);
	   
	 	$stmt = $this->db->query("delete FROM `adv_pos_category`  where id='".$cat_id."' and merchant_id='".$merchant_id."' ");
		$stmt1 = $this->db->query("UPDATE  `adv_pos_item_main` set status='2'  where category_id='".$cat_id."' and merchant_id='".$merchant_id."' ");
		$stmt2 = $this->db->query("UPDATE  `adv_pos_item`  set status='2'   where category_id='".$cat_id."' and merchant_id='".$merchant_id."' ");

		$response = ['status' => '200', 'successMsg' => 'Category deleted successfully.'];
		echo json_encode($response);die;
	}

}