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
		$this->load->model('Inventory_merchant_model');
  		if (!$this->session_checker_model->chk_session_merchant()) {
  		  	redirect('login');
  		}
		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
		// error_reporting(E_ALL);
	}

	public function dateTimeConvertTimeZone($Adate) {
		date_default_timezone_set("UTC");
		if($this->session->userdata('time_zone')) {
			$time_Zone=$this->session->userdata('time_zone') ? $this->session->userdata('time_zone') :'America/Chicago';
			$datetime = new DateTime($Adate);
			$la_time = new DateTimeZone($time_Zone);
			$datetime->setTimezone($la_time);
			$convertedDateTime=$datetime->format('Y-m-d H:i:s');
			
		} else {
			$convertedDateTime=$Adate;
		}
		return $convertedDateTime; 
	}

	public function inventorymngt() {
		//echo '<pre>';print_r($_POST);die;
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->Inventory_merchant_model->get_full_inventory_spdata($start_date, $end_date,$merchant_id);
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] = $_POST['end_date'];

		} else {
			$package_data = $this->Inventory_merchant_model->get_full_inventory_data_no_limit($merchant_id);
			$data['package_data_no_main_item'] = $this->Inventory_merchant_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		}
		// echo '<pre>';print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if(count($each) > 0   && $each->status!='2') {
	           	$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['barcode_data'] = $each->barcode_data;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		$data['mem'] = $mem;
		// echo '<pre>';print_r($data);die;
		// $data['msg'] = "<h3>" . $this->session->userdata('mymsg') . "</h3>";
		// $this->session->unset_userdata('mymsg');
		$data["title"] ='Inventory Management';
		$data["meta"] ='Inventory Management';
		$this->load->view('merchant/inventory_dash', $data);
		// $this->load->view('merchant/inventory', $data);
	}

	public function inventorymngt_FullExcelDownload() {
		// $this->load->library('export');
		$this->load->library('Excel');
		// echo 1;die;
		$fileName = 'Inventory Management Excel.xlsx';
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		// echo $merchant_id;die;
		$package_data_no_main_item = $this->Inventory_graph_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		$package_data = $this->Inventory_graph_model->get_full_inventory_data_no_limit($merchant_id);
		// echo '<pre>';print_r($package_data);die;
	
		$mem = array();
		$event_export = array();
		foreach ($package_data as $each) {
			if($each && $each->status!='2') {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		// set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SKU');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Tax');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'In Stock');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sold Quantity');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        // set Row
		$rowCount = 2;

		foreach ($package_data_no_main_item as $a_data) {
			$export_price = $a_data['price'] ? number_format($a_data['price'],2) : '0.00';
			$export_price = '$'.$export_price;

			$export_tax = $a_data['tax'].'%';
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];
			$export_sold = ($a_data['sold_quantity']=='I') ? 'Infinite' : $a_data['sold_quantity'];
			if($a_data['status']=='0') {
				$export_status = 'active';
			} else if($a_data['status']=='1'){
				$export_status = 'inactive';
			} else if($a_data['status']=='2'){
				$export_status = 'deleted';
			} else {
				$export_status = '--';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['name'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['cat_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['sku']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
            $rowCount++;
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$parent = $this->Inventory_graph_model->get_full_inventory_data_no_limit_list($a_data['merchant_id'],$a_data['item_id']);

			foreach ($parent as $parent_Data) {
				$export_title = '  -'.$parent_Data['title'];
				$export_price = $parent_Data['price'] ? number_format($parent_Data['price'],2) : '0.00';
				$export_price = '$ '.$export_price;

				$export_tax = $parent_Data['tax'].'%';
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];
				$export_sold = ($parent_Data['sold_quantity']=='I') ? 'Infinite' : $parent_Data['sold_quantity'];
				if($a_data['status']=='0') {
					$export_status = 'active';
				} else if($a_data['status']=='1'){
					$export_status = 'inactive';
				} else if($a_data['status']=='2'){
					$export_status = 'deleted';
				} else {
					$export_status = '--';
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $export_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['cat_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
				$rowCount++;
			}
			$i++;
		}
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
		// download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(site_url().$fileName);
	}

	public function inventorymngt_FullCSVDownload() {
		// $this->load->library('export');
		$this->load->library('Excel');
		// $fileName = 'Inventory Management Excel.xlsx';
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		// echo $merchant_id;die;
		$package_data_no_main_item = $this->Inventory_graph_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		$package_data = $this->Inventory_graph_model->get_full_inventory_data_no_limit($merchant_id);
		// echo '<pre>';print_r($package_data);die;
	
		$mem = array();
		$event_export = array();
		foreach ($package_data as $each) {
			if($each && $each->status!='2') {
				$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Column Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		// set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Item Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SKU');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Tax');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'In Stock');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sold Quantity');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
        // set Row
		$rowCount = 2;

		foreach ($package_data_no_main_item as $a_data) {
			$export_price = $a_data['price'] ? number_format($a_data['price'],2) : '0.00';
			$export_price = '$'.$export_price;

			$export_tax = $a_data['tax'].'%';
			$export_quantity = ($a_data['quantity']=='I') ? 'Infinite' : $a_data['quantity'];
			$export_sold = ($a_data['sold_quantity']=='I') ? 'Infinite' : $a_data['sold_quantity'];
			if($a_data['status']=='0') {
				$export_status = 'active';
			} else if($a_data['status']=='1'){
				$export_status = 'inactive';
			} else if($a_data['status']=='2'){
				$export_status = 'deleted';
			} else {
				$export_status = '--';
			}

			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['name'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $a_data['cat_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $a_data['sku']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
            $rowCount++;
		}

		$i = 1;
		foreach ($mem as $a_data) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, htmlentities(Ucfirst($a_data['mname'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
			$rowCount++;
			
			$parent = $this->Inventory_graph_model->get_full_inventory_data_no_limit_list($a_data['merchant_id'],$a_data['item_id']);

			foreach ($parent as $parent_Data) {
				$export_title = '  -'.$parent_Data['title'];
				$export_price = $parent_Data['price'] ? number_format($parent_Data['price'],2) : '0.00';
				$export_price = '$ '.$export_price;

				$export_tax = $parent_Data['tax'].'%';
				$export_quantity = ($parent_Data['quantity']=='I') ? 'Infinite' : $parent_Data['quantity'];
				$export_sold = ($parent_Data['sold_quantity']=='I') ? 'Infinite' : $parent_Data['sold_quantity'];
				if($a_data['status']=='0') {
					$export_status = 'active';
				} else if($a_data['status']=='1'){
					$export_status = 'inactive';
				} else if($a_data['status']=='2'){
					$export_status = 'deleted';
				} else {
					$export_status = '--';
				}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $export_title);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $parent_Data['cat_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $parent_Data['sku']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $export_price);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $export_tax);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $export_quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $export_sold);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $export_status);
				$rowCount++;
			}
			$i++;
		}
		// create file name
		$fileName = 'Inventory Management CSV';
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function add_inventoryItem() {
		$data = array(); 
	    $merchant_id = $this->session->userdata('merchant_id');
		
		$stmt_cat = $this->db->query("SELECT id,index_id,name FROM `adv_pos_category` where merchant_id='".$merchant_id."'  order by index_id desc");
		$package_data_cat = $stmt_cat->result_array();
		$data['package_data_cat'] = $package_data_cat;

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;

		// echo '<pre>';print_r($data);die;

		$data['meta'] = "Add Product";
		$data['upload_loc'] = base_url()."uploads/item_image";
		$data['loc'] = "add_inventory";
		$data['action'] = "Add";
		$this->load->view('merchant/add_inventory', $data);
	}

	public function add_inventory() {
		// echo '<pre>';print_r($_POST);die;
		$merchantId = $this->session->userdata('merchant_id');
		$mode = $_POST['mode'];

		$date = date("mdHis");
		$image = $_FILES['item_image']['name'];
		$exp = explode(".", $image);
		$extension = end($exp);
		$image_name = strtolower("adv_pos_item") . "_" . $merchant_id . "_" . $date . "." . $extension;

		$config['file_name'] = $image_name; 
        $config['upload_path']          = './uploads/item_image/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
        $config['max_size']             = 1000;
        $config['max_width']            = 3024;
        $config['max_height']           = 3068;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('item_image')) {
	        $data = array('upload_data' => $this->upload->data());
	        $uploadedFileName=$data['upload_data']['file_name'];
	    } else {
	    	$this->session->set_flashdata("error", $this->upload->display_errors());
			redirect('inventory/add_inventoryItem');
	    }

	    if ($mode == 0) {

	    	$itemName = $_POST['name'];
			$itemCategory = $_POST['category_id'];
			$barcode_data = $_POST['barcode_data'];
			$price = str_replace(",", "", $_POST['price']);
			$sold_qty_alert = $_POST['sold_qty_alert'];
			$tax = $_POST['tax'];
			$sku = $_POST['sku'];
			$title = 'Regular';

			//$title = strtolower($_POST['title']);
			$itemId = $_POST['item_id'];

			if(isset($_POST['quantity'])) {
				$quantity = $_POST['quantity'];
			} else {
				$quantity = 'I';
			}

			$ins_main_data = array();
			$ins_main_data['merchant_id'] = $merchantId;
			$ins_main_data['name'] = $itemName;
			$ins_main_data['category_id'] = $itemCategory;
			$ins_main_data['item_img'] = $uploadedFileName;

			$itemId = $this->admin_model->insert_data("adv_pos_item_main", $ins_main_data);

			$ins_tier_data = array();
			$ins_tier_data['category_id'] = $itemCategory;
			$ins_tier_data['item_id'] = $itemId;
			$ins_tier_data['mode'] = $mode;
			$ins_tier_data['title'] = $title;
			$ins_tier_data['name'] = $itemName;
			$ins_tier_data['sku'] = $sku;
			$ins_tier_data['price'] = $price;
			$ins_tier_data['tax'] = $tax;
			$ins_tier_data['merchant_id'] = $merchantId;
			$ins_tier_data['description'] = $itemName;
			$ins_tier_data['quantity'] = $quantity;
			$ins_tier_data['sold_quantity'] = '0';
			$ins_tier_data['sold_qty_alert'] = $sold_qty_alert;
			$ins_tier_data['item_image'] = $uploadedFileName;
			$ins_tier_data['barcode_data'] = $barcode_data;
			// echo '<pre>';print_r($ins_tier_data);die;
			$this->admin_model->insert_data("adv_pos_item", $ins_tier_data);

			$this->session->set_flashdata("success", "Product Created");
			redirect('inventory/inventorymngt');

	    } else {
	    	$var_name_arr = $_POST['var_name'];
	    	// echo '<pre>';print_r($_POST);die;
	    	$itemName = $this->input->post('name') ? $this->input->post('name') : "";
			$itemCategory = $this->input->post('category_id') ? $this->input->post('category_id') : "";
			$tax = $this->input->post('tax') ? $this->input->post('tax') : "";

			$fulldata = Array(
				'name' => $itemName,
				'merchant_id' => $merchantId, 
				'category_id' => $itemCategory,
				'item_img' => $uploadedFileName
			);
			$itemId = $this->admin_model->insert_data("adv_pos_item_main", $fulldata);

			$var_name_arr = $_POST['var_name'];
			if (!empty($itemId)) {
				$var_name_arr = $_POST['var_name'];

				foreach ($var_name_arr as $key => $val) {
					// echo $_POST['price'][$key];
					$var_data = array(
						'item_id' 		=> $itemId,
						'name' 			=> $itemName,
						'title' 		=> $_POST['var_name'][$key],
						'sku' 			=> $_POST['sku'][$key], 
						'price' 		=> str_replace(",", "", $_POST['price'][$key]),
						'tax' 			=> $tax,
						'merchant_id' 	=> $merchantId, 
						'description' 	=> $itemName,
						'quantity' 		=> ($_POST['quantity'][$key] == '∞') ? 'I' : $_POST['quantity'][$key],
						'category_id' 	=> $itemCategory,
						'mode' 			=> $mode, 
						'item_image' 	=> $uploadedFileName
					);
					// echo '<pre>';print_r($var_data);die;
					$stmt = $this->admin_model->insert_data("adv_pos_item", $var_data);
				}
				$this->session->set_flashdata("success", "Product Created");
				redirect('inventory/inventorymngt');
 			}
	    }
	}
	public function getQty($id)
	{
		// echo $id;die;
		$responseArr = array();
		
		$q=$this->db->query("SELECT quantity from adv_pos_item where id=".$id)->result_array();
		$qty=$q[0]['quantity'];
		if($qty!='') {
				$responseArr['status'] = 200;
				$responseArr['qty'] = $qty;
				$responseArr['message'] = 'Record found.';
	    } else {
				$responseArr['status'] = 501;
				$responseArr['message'] = 'No Recor exist.';
		}
		
			echo json_encode($responseArr);//die;
	}
  	public function editInventory() {

	    // Call the verification method and store the return value in the variable
	    $data = array(); 
	    $in_id = $this->uri->segment(3);
	    $merchant_id = $this->session->userdata('merchant_id');
		
		$stmt = $this->db->query("SELECT `id`,item_id,title, `name`,sku, `price`, `tax`,`quantity`,sold_quantity,barcode_data, category_id,sold_qty_alert, `item_image` as itemImage,mode,title FROM `adv_pos_item` where merchant_id='".$merchant_id."' and id='".$in_id."'  and status=0 order by id desc");
			
		$package_data = $stmt->result_array();
		$data['package_data'] = $package_data;
		
		//echo $package_data[0]['item_id'];die;

		$stmt_item=$this->db->query("SELECT title,price,quantity,sku from adv_pos_item where item_id='".$package_data[0]['item_id']."'");
		$package_data_variant= $stmt_item->result_array();
		$data['package_data_variant']=$package_data_variant;

		$stmt_cat = $this->db->query("SELECT id,index_id,name FROM `adv_pos_category` where merchant_id='".$merchant_id."'  order by index_id desc");
			
		$package_data_cat = $stmt_cat->result_array();
		$data['package_data_cat'] = $package_data_cat;

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;

		$data['bct_id'] = $in_id;
		//echo $package_data[0]['item_id'];
		//echo '<pre>';print_r($data);  die();
		// echo '<pre>';print_r($data);die;

		$data1 = array();
		$merchant_id = $this->session->userdata('merchant_id');
		if ($this->input->post('mysubmit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$status = $_POST['status'];
			$package_data = $this->Inventory_merchant_model->get_full_inventory_spdata($start_date, $end_date,$merchant_id);
			$data1["start_date"] = $_POST['start_date'];
			$data1["end_date"] = $_POST['end_date'];

		} else {
			$package_data = $this->Inventory_merchant_model->get_full_inventory_data_no_limit($merchant_id);
			$data1['package_data_no_main_item'] = $this->Inventory_merchant_model->get_full_inventory_data_no_limit_no_main_item($merchant_id);
		}
	//echo '<pre>';print_r($package_data);die;
		$mem = array();
		$member = array();
		foreach ($package_data as $each) {
			if(count($each) > 0   && $each->status!='2') {
	           	$each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				$package['id'] = $each->id;
				$package['merchant_id'] = $each->merchant_id;
				$package['mname'] = $each->mname;
				$package['item_id'] = $each->item_id;
				$package['name'] = $each->name;
				$package['title'] = $each->title;
				$package['sku'] = $each->sku;
				$package['barcode_data'] = $each->barcode_data;
				$package['price'] = $each->price;
				$package['tax'] = $each->tax;
				$package['description'] = $each->description;
				$package['quantity'] = $each->quantity;
				$package['sold_quantity'] = $each->sold_quantity;
				$package['item_image'] = $each->item_image;
				$package['status'] = $each->status;
				$package['date'] = $each->created_at;
				$package['cat_name'] = $each->cat_name;
				$package['cat_code'] = $each->cat_code;
				$mem[] = $package;
			}
		}
		array_multisort(array_column($mem, 'date'),SORT_DESC,$mem);
		$data['mem'] = $mem;
		$data['meta'] = "Edit Item";
		$data['upload_loc'] = base_url()."uploads/item_image";
		$data['loc'] = "edit_Inventory";
		$data['action'] = "Update Item";
		// echo '<pre>';print_r($data);die;
		$this->load->view('merchant/edit_inventory', $data);
	}
	public function updateQty($id,$qty)
	{
		//$x=$this->input->post('Update_Qty') ? $this->input->post('Update_Qty') : "";
		$this->db->query("UPDATE adv_pos_item SET quantity=quantity+$qty where id=".$id);
		//echo $this->db->last_query();die;
		$this->session->set_flashdata("success", "Quantity Updated Successfully.");
		redirect('inventory/inventorymngt');
	}

	public function get_single_multi_items($in_id) {
		// echo $item_id;die;
		$data = array(); 
	    // $in_id = $this->uri->segment(3);
	    $merchant_id = $this->session->userdata('merchant_id');
		
		$stmt = $this->db->query("SELECT `id`,item_id,title, `name`,sku, `price`, `tax`,`quantity`,sold_quantity,barcode_data, category_id,sold_qty_alert, `item_image` as itemImage,mode,title FROM `adv_pos_item` where merchant_id='".$merchant_id."' and id='".$in_id."'  and status=0 order by id desc");
			
		$package_data = $stmt->row();
		$data['package_data'] = $package_data;
		// echo '<pre>';print_r($data);die; 
		echo json_encode($data);die;
	}

	public function edit_Inventory() {
		 //echo '<pre>';print_r($_POST);die;
		$merchantId = $this->session->userdata('merchant_id');
		$mode = $_POST['mode'];
		$oldmode=$_POST['oldmode'];
		$id = $_POST['bct_id'];
		$itemCategory = $_POST['category_id'];
		$itemName = $_POST['name'];
		$tax = $_POST['tax'];
		$sku = $_POST['sku'];
		$price = str_replace(",", "", $_POST['price']);
		$barcode_data = $_POST['barcode_data'];
		$sold_qty_alert = $_POST['sold_qty_alert'];
		// $img=$_POST['item_image_old'];

		
		$title = ($mode==0)?"Regular": strtolower($_POST['title']);
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
		$item_image_old =$_POST['item_image_old'];

		if ( isset($_FILES['item_image']['name']) && ($_FILES['item_image']['name'] != '') ) {
			$date = date("mdHis");
			$image = $_FILES['item_image']['name'];
			$exp = explode(".", $image);
			$extension = end($exp);
			$image_name = strtolower("adv_pos_item") . "_" . $merchantId . "_" . $date . "." . $extension;
            
            $config['file_name'] = $image_name; 
            $config['upload_path'] = './uploads/item_image/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|ico|jpeg|ps|psd|svg|tif|odp|pps|ppt|pptx|doc|pdf|odt|docx';
            $config['max_size'] = 1000;
            $config['max_width'] = 3024;
            $config['max_height'] = 3068;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('item_image')) {
            	$data = array('upload_data' => $this->upload->data());
            	// $this->load->view('upload_success', $data);
            	$uploadedFileName=$data['upload_data']['file_name']; 
            
            $image_name =$uploadedFileName;
         	// echo "1"; die();
		    }
		} else {
			if(empty($item_image_old)) {
				$this->session->set_flashdata("error", "Item image is required.");
				redirect('Inventory/editInventory/'.$id);
			}
			$image_name = $item_image_old;
			// echo "2"; die();
		}

		//echo 'c';
		//echo $image_name;die;
		// if($mode==0){
		// 	$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."',`item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		
		// } elseif ($mode==1 && $title=='regular') {
		// 	$smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."',`item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");
		// }

		// $stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_id`='".$itemId."',`category_id`='".$itemCategory."',`name`='".$itemName."', `sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."', `quantity`='".$quantity."', `item_image`='".$image_name."' WHERE `id`='".$id."'  and `merchant_id` ='".$merchantId."'");


		if($mode==0 && $title=='Regular'){
			//echo '11';die;
			// $smtp1 = $this->db->query("UPDATE `adv_pos_item_main` SET `name`='".$itemName."',`category_id`='".$itemCategory."' ,`item_img`='".$image_name."' WHERE `id`='".$itemId."' and `merchant_id` ='".$merchantId."'");

			//  $smtp2=$this->db->query("UPDATE adv_pos_item SET mode='".$mode."',title='".$title."' status=2 where `item_id`='".$itemId."'");
		
			$q1=$this->db->query("UPDATE adv_pos_item_main set name='".$itemName."',category_id='".$itemCategory."',item_img='".$image_name."' where id='".$itemId."' and merchant_id='".$merchantId."'");

			$q2=$this->db->query("DELETE from adv_pos_item where item_id='".$itemId."'");

			$q3=$this->db->query("INSERT into adv_pos_item(category_id,mode,title,name,sku,price,tax,description,quantity,sold_qty_alert,item_image,barcode_data,merchant_id,item_id,status) values ('".$itemCategory."','0','Regular','".$itemName."','".$sku."','".$price."','".$tax."','".$itemName."','".$quantity."','".$sold_qty_alert."','".$image_name."','".$barcode_data."','".$merchantId."','".$itemId."','0')");
				//echo $this->db->last_query();die;
		
		} elseif ($mode==1) {
			//echo '12';die;
			
			$q1=$this->db->query("UPDATE adv_pos_item_main set name='".$itemName."',category_id='".$itemCategory."',item_img='".$image_name."' where id='".$itemId."' and merchant_id='".$merchantId."'");

			
			// echo $this->db->last_query();die;
			// if($oldmode==$mode){
			// 	echo 'oldmode=mode';
			// 	echo '<pre>';print_r($_POST);die;
			// 	$stmt = $this->db->query("UPDATE `adv_pos_item` SET `item_id`='".$itemId."',`category_id`='".$itemCategory."',`name`='".$itemName."', `sku`='".$sku."', `price`='".$price."', `barcode_data`='".$barcode_data."',`tax`='".$tax."',`description`='".$itemName."', `quantity`='".$quantity."', `sold_qty_alert`='".$sold_qty_alert."' WHERE `id`='".$id."'  and `merchant_id` ='".$merchantId."'");
			// }else{

				//$stmt=$this->db->query("UPDATE adv_pos_item set category_id='".$itemCategory."',mode='".$mode."',title='".$itemName."'where item_id='".$itemId."' and merchant_id='".$merchantId."'");
				$stmt=$this->db->query("DELETE from adv_pos_item where item_id='".$itemId."' and merchant_id='".$merchantId."'");
				//echo $this->db->last_query();die;
				// echo 'oldmode!=mode';
				// echo '<pre>';print_r($_POST);die;
				$var_name_arr = $_POST['var_name'];
				if (!empty($itemId)) {
				$var_name_arr = $_POST['var_name'];

				foreach ($var_name_arr as $key => $val) {
					// echo $_POST['price'][$key];
					$var_data = array(
						'item_id' 		=> $itemId,
						'name' 			=> $itemName,
						'title' 		=> $_POST['var_name'][$key],
						'sku' 			=> $_POST['sku'][$key], 
						'price' 		=> str_replace(",", "", $_POST['price'][$key]),
						'tax' 			=> $tax,
						'merchant_id' 	=> $merchantId, 
						'description' 	=> $itemName,
						'quantity' 		=> ($_POST['quantity'][$key] == '∞') || ($_POST['quantity'][$key] == '') ? 'I' : $_POST['quantity'][$key],
						'category_id' 	=> $itemCategory,
						'mode' 			=> $mode, 
						//'item_image' 	=> $uploadedFileName
					);
					 // echo '<pre>';print_r($var_data);
					// $stmt1 = $this->admin_model->insert_data("adv_pos_item", $var_data);
					 $this->db->insert("adv_pos_item", $var_data);
					// echo $this->db->last_query();
				}
				
				$this->db->query("UPDATE adv_pos_item SET item_image='".$image_name."' where item_id='".$itemId."' and merchant_id='".$merchantId."'");
			//}
				
					// echo $this->db->last_query();die;
			}
			
		}
		//print_r($this->db->last_query());
		//die();

		$this->session->set_flashdata("success", "Data Updated Successfully.");
		redirect('inventory/inventorymngt');
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
    	// print_r($_POST);die;
	    $merchant_id = $this->session->userdata('merchant_id');
    	$data = array(); 
	    $parent_id = $this->uri->segment(3);
	    // echo $parent_id;die;
	    $stmt = $this->db->query("SELECT name as product_name, category_id,item_img FROM `adv_pos_item_main` where merchant_id='".$merchant_id."' and id='".$parent_id."'  and status=0 order by id desc");
	    // echo '<pre>';print_r($package_data);die;
	    $package_data = $stmt->row();
		$data['product_name'] = $package_data->product_name;
		$data['cat_id'] = $package_data->category_id;
		$data['item_img'] = $package_data->item_img;

		$stmt_cat = $this->db->query("SELECT id,index_id,name FROM `adv_pos_category` where merchant_id='".$merchant_id."'  order by index_id desc");	
		$package_data_cat = $stmt_cat->result_array();
		$data['package_data_cat'] = $package_data_cat;

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;

		$data['parent_id'] = $parent_id;
		// echo '<pre>';print_r($data);die;
		$data['meta'] = "Add Variant";
		$data['upload_loc'] = base_url()."uploads/item_image";
		$data['loc'] = "addVariantSubmit";
		$data['action'] = "Add Variant";
		$this->load->view('merchant/add_variant', $data);
    }

    public function addVariantSubmit() {
		 // echo '<pre>';print_r($_POST);die;
		$merchantId = $this->session->userdata('merchant_id');
		$parent_id = $_POST['parent_id'];
		$itemCategory = $_POST['category_id'];
		$itemName = $_POST['name'];
		$tax = $_POST['tax'];
		$sku = $_POST['sku'];
		$item_img = $_POST['item_img'];
		$price = str_replace(",", "", $_POST['price']);
		$product_name = $_POST['title'];
		$barcode_data = $_POST['barcode_data'];
		$sold_qty_alert = $_POST['sold_qty_alert'];

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
		// echo $quantity.',aaa';die;

		$stmt = $this->db->query("INSERT INTO `adv_pos_item` SET `category_id`='".$itemCategory."',`item_id`='".$itemId."',`mode`='".$mode."',`title`='".$itemName."',`item_image`='".$item_img."',`name`='".$product_name."', `sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."',`barcode_data`='".$barcode_data."', `quantity`='".$quantity."',`sold_qty_alert`='".$sold_qty_alert."',`merchant_id`='".$merchantId."'");

		$this->session->set_flashdata("success", "Product variant added successfully.");
		redirect('inventory/inventorymngt');
    }

    public function editProductVariant() {
	    $merchant_id = $this->session->userdata('merchant_id');
    	$data = array(); 
	    $prod_id = $this->uri->segment(3);
	    // echo $prod_id;die;
	    $stmt = $this->db->query("SELECT `id`,title,sku,`price`,`tax`,`quantity`,sold_quantity,barcode_data,sold_qty_alert FROM `adv_pos_item` where merchant_id='".$merchant_id."' and id='".$prod_id."'  and status=0 order by id desc");
		$data['package_data'] = $stmt->row();

		$stmt_tax = $this->db->query("SELECT title,percentage FROM `tax` where merchant_id='".$merchant_id."' and status='active' order by id desc");
		$package_data_tax = $stmt_tax->result_array();
		$data['package_data_tax'] = $package_data_tax;
		// echo '<pre>';print_r($data['package_data_tax']);die;
		
		$data['meta'] = "Edit Variant";
		$data['loc'] = "updateVariantSubmit";
		$data['action'] = "Update Variant";
		$this->load->view('merchant/edit_variant', $data);
    }

    public function updateVariantSubmit() {
		//echo '<pre>';print_r($_POST);die;
		$merchantId = $this->session->userdata('merchant_id');
		$prod_id = $_POST['prod_id'];
		$itemName = $_POST['name'];
		$tax = $_POST['tax'];
		$sku = $_POST['sku'];
		$price = str_replace(",", "", $_POST['price']);
		$barcode_data = $_POST['barcode_data'];
		$sold_qty_alert = $_POST['sold_qty_alert'];

		if(empty($_POST['quantity'])) {
			$quantity = 'I';
		} else {
			if($_POST['quantity'] == '∞') {
				$quantity = 'I';
			} else {
				$quantity = $_POST['quantity'];
			}
		}

		$smtp1 = $this->db->query("UPDATE `adv_pos_item` SET `title`='".$itemName."',`sku`='".$sku."', `price`='".$price."',`tax`='".$tax."',`description`='".$itemName."',`barcode_data`='".$barcode_data."', `quantity`='".$quantity."',`sold_qty_alert`='".$sold_qty_alert."' WHERE `id`='".$prod_id."' and `merchant_id` ='".$merchantId."'");

		$this->session->set_flashdata("success", "Product variant updated successfully.");
		redirect('inventory/inventorymngt');
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
	   	// echo $merchant_id.','.$item_id;die;
	   
	 	$getDashboard = $this->db->query("SELECT count(*) as cartItem FROM  `adv_pos_cart_item` ci join adv_pos_item i on i.id=ci.item_id where i.item_id='".$item_id."' and i.merchant_id='".$merchant_id."' and i.status=0 and  ci.status=0");
		$getDashboardData = $getDashboard->result_array();
		// print_r($getDashboardData);
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
    		$response = ['status' => '200', 'successMsg' => 'Variant deleted successfully'];
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
		

		$data['meta'] = "Edit Category";
    	$data['loc'] = "edit_category";
    	$data['action'] = "Edit Category";
    	//print_r($data);die;
    	if (isset($_POST['submit'])) {

    	  	$this->form_validation->set_rules('name', 'Name', 'required');
    	  	$name = $this->input->post('name') ? $this->input->post('name') : "";
    	  	$bct_id = $this->input->post('bct_id') ? $this->input->post('bct_id') : "";
    	  	//echo $bct_id;die;
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

	public function inventoryreport() {
		$data = array();
		$merchant_id = $this->session->userdata('merchant_id');
		$getQuery1 = $this->db->query("SELECT * from merchant where id ='".$merchant_id."'");
		$data['merchantdata'] = $getQuery1->result_array();

		//$data['getInventry_main_items']= $this->admin_model->get_all_inventry_main_items($merchant_id);
		$data['getInventry_main_items']= $this->admin_model->get_all_inventry_category($merchant_id);
		$this->db->get('adv_pos_item_main');
		
		if ($this->input->post('mysubmit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];

			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);
			$data['package_data_no_main_item']=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);

			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] =  $_POST['end_date'];
			$data["main_items"] = $_POST['main_items'];

		} elseif ($this->input->post('search_Submit')) {
			$start_date = $_POST['start_date'];
			$end_date = $_POST['end_date'];
			$main_items = $_POST['main_items'];

			$package_data = $this->Inventory_model->get_full_inventory_spreportdata($start_date, $end_date,$main_items,$merchant_id);
			$package_data_no_main_item=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$package_data_mis_item=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			
			$package_data_total_count_confirm = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'confirm', $merchant_id,'pos');
			$package_data_total_count_refund = $this->Inventory_model->get_search_merchant_pos_total_count($start_date, $end_date,'Chargeback_Confirm', $merchant_id,'pos');
			$package_data_invoice_refund = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund($start_date, $end_date,$main_items,$merchant_id);

			$refund_amount=0;
			$total_order = count($package_data_invoice_refund);
			foreach($package_data_invoice_refund as $invoice_refund) {
				$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				$refund_amount+= $refund_check['amount'];
			}

			$refund_amount_split=0;
			$package_data_invoice_refund_split = $this->Inventory_model->get_full_inventory_spreportdata_invoice_refund_split($start_date, $end_date,$main_items,$merchant_id);
			$total_order_split = count($package_data_invoice_refund_split);
			
			//print_r($package_data_invoice_refund_split); die();
			foreach($package_data_invoice_refund_split as $invoice_refund_split) {
				$refund_check = $this->Inventory_model->refund_check($invoice_refund->order_id);
				$refund_amount_split+= $refund_check['amount'];
			}
			$data["start_date"] = $_POST['start_date'];
			$data["end_date"] =  $_POST['end_date'];
			$data["main_items"] = $_POST['main_items'];
			
		} else {
			$start_date = date('Y-m-d', strtotime('-30 days'));
			$end_date = date('Y-m-d');
			$data["start_date"] = $start_date;
			$data["end_date"] =  $end_date;
			$main_items ='';
			
			$package_data = $this->Inventory_model->get_full_inventory_reportdata_main($start_date,$end_date,$merchant_id);
			$data['package_data_no_main_item']=$this->Inventory_model->get_full_inventory_reportdata_main_no_main_item($start_date, $end_date,$merchant_id,$main_items);
			$data['package_data_mis_item']=$this->Inventory_model->get_full_inventory_reportdata_mis_item($start_date, $end_date,$merchant_id,$main_items);
			//print_r($data['package_data_mis_item']);
		}

		//Pdf html
		$parent_sale = $this->Inventory_model->get_full_inventory_reportdata_sale($data['start_date'],$data['end_date'],$merchant_id,$main_items);
		
		foreach ($parent_sale as $a_sale) {
			$text_Sale_html .= '<tr>
            <td style="border-left: 1px solid grey; border-bottom:1px solid grey">'.date("Y-m-d", strtotime($a_sale['updated_at'])).'</td>
			<td style=" border-bottom:1px solid grey">'.$a_sale['transaction_id'].'</td>
			<td style=" border-bottom:1px solid grey">'.$a_sale['order_id'].'</td>
			<td style=" border-bottom:1px solid grey" >'.ucfirst($a_sale['item_name']).'/'.ucfirst($a_sale['item_title']).'</td>
			<td style="border-bottom:1px solid grey">'.$a_sale['quantity'].'</td>
			<td style=" border-bottom:1px solid grey">$ '.number_format($a_sale['sold_price'],2).'</td>
			<td style="border-bottom:1px solid grey">$ '.number_format(str_replace("-",'',$a_sale['discount']),2).'</td>
			<td style="border-bottom:1px solid grey">$ '.number_format($a_sale['tax_value'],2).'</td>
			<td style="border-bottom:1px solid grey">$ '.number_format(($a_sale['sold_price']+$a_sale['tax_value'])-$a_sale['discount'],2).'</td>
            <td style="border-right: 1px solid grey; border-bottom:1px solid grey">Paid</td> 
			</tr>';
		}
		//End html
		
		$mem = array();
		$member = array();

		foreach ($package_data as $each) {
			if(count($each) > 0) {
	            $each->created_at=$this->dateTimeConvertTimeZone($each->created_at);
				
				$package['item_id'] = $each->item_id;
				$package['main_item_id'] = $each->main_item_id;
				$package['mname'] = $each->mname;
				$package['merchant_id'] = $merchant_id;
				$package['price'] = $each->price;
				$package['tax_value'] = $each->tax_value;
				$package['sku'] = $each->sku;
				$package['new_price'] = $each->new_price;
				$package['quantity'] = $each->quantity;
				$package['cat_name'] = $each->cat_name;
				$package['status'] = $each->status;
				$package['discount'] = $each->discount;
				$package['date'] = $each->created_at;
				$package['updated_at'] = $each->updated_at;
				$package['rowtype'] ="parent";
				$package['sold_price'] = $each->sold_price;
				// $package['tax'] = $each->tax;
				$package['item_name'] = $each->item_name;
				$package['base_price'] = $each->base_price;
				$package['item_image'] = $each->item_image;
				$package['item_title'] = $each->item_title;
				$mem[] = $package;
			}
		}

		$data['mem'] = $mem;
		$data['title'] = 'Merchant || Inventory Report';
		$data['meta'] = 'Inventory Report';
		
		$this->load->view('merchant/inventoryreport_dash', $data);
		// $this->load->view('merchant/inventoryreport', $data);
		//print_r($mem);
		//array_multisort(array_column($mem, 'item_id'),SORT_DESC,$mem);
		
		if ($this->input->post('search_Submit')) {
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Inventory Report";
	        $title_head = '';
			 
			$obj_pdf->SetTitle($title);
			//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$obj_pdf->SetFont('helvetica', '', 9);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->AddPage();			
			//$obj_pdf->SetPrintHeader(false);
			//$obj_pdf->setHeaderTemplateAutoreset(true);
			ob_start();

			$startdate = date('M  jS, Y', strtotime($start_date));
			$enddate = date('M  jS, Y', strtotime($end_date));
			$enddatee = date("M  jS, Y h:i A");
		
	    	$j = 1;
		 	$total_item_s = 0;
		 	$total_paid_s = 0;
		 	$sold_price_s = 0;
		 	$tax_value_s = 0;
		 	$discount_s = 0;
			foreach ($package_data_no_main_item as $a_data) {
			  	$textcolors .= '<tr>
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%">'.($a_data['sku']).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
				</tr>';
			
				$total_item_s+= $a_data['quantity'];
				$sold_price_s+= $a_data['sold_price'];

				if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0) {
	              	$tax_value_s+= $a_data['bill_tax'];
				} else {
					$tax_value_s+= $a_data['tax_value'];
				}

				if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0) {
	              	$discount_s+= $a_data['bill_discount'];
				} else {
					$discount_s+= $a_data['discount'];
				}
		 		$j++;
			}
		
		 	$k = 1;
		 	$total_item_m = 0;
		 	$total_paid_m = 0;
		 	$sold_price_m = 0;
		 	$tax_value_m = 0;
		 	$discount_m = 0;
			foreach ($package_data_mis_item as $a_data) {
			  	$textcolors .= '<tr>
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%"></td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['discount'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
				</tr>';
			
				$total_item_m+= $a_data['quantity'];
				$sold_price_m+= $a_data['sold_price'];
				if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0)
				{
            	  $tax_value_m+= $a_data['bill_tax'];
				}
				else
				{
					$tax_value_m+= $a_data['tax_value'];
				}

				if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0)
				{
            	  $discount_m+= $a_data['bill_discount'];
				}
				else
				{
					$discount_m+= $a_data['discount'];
				}
		 		$k++; 
			}
	
		 	$i = 1;
		 	$total_item = 0;
		 	$total_paid = 0;
		 	$sold_price = 0;
		 	$tax_value = 0;
		 	$discount = 0;
			foreach ($mem as $a_data) {
			  	$textcolors .= '<tr>
				<td  style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%" >'.ucfirst($a_data['mname']).'</td>
				 <td style=" border-bottom:1px solid grey" width="10%"></td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">'.$a_data['quantity'].'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;"width="10%">0</td>
				<td style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['sold_price'],2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(str_replace("-",'', $a_data['discount']),2).'</td>
				<td style="border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format($a_data['tax_value'],2).'</td>
				<td style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">$ '.number_format(($a_data['sold_price']+$a_data['tax_value'])-$a_data['discount'],2).'</td>
				</tr>';
			
				$parent = $this->Inventory_model->get_full_inventory_reportdata($data['start_date'],$data['end_date'],$merchant_id,$a_data['main_item_id']);
				foreach ($parent as $parent_Data) {
					$parent_name= Ucfirst($parent_Data['item_title']);
					$textcolors .= '<tr>
                 	<td style="border-left: 1px solid grey; border-bottom:1px solid grey;" width="30%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;'.$parent_name.'</td>
				 	<td style=" border-bottom:1px solid grey" width="10%">'.$parent_Data['sku'].'</td>
					<td style="border-bottom:1px solid grey" width="10%">'.$parent_Data['quantity'].'</td>
					<td style="border-bottom:1px solid grey" width="10%">0</td>
					<td style=" border-bottom:1px solid grey" width="10%">$ '.number_format($parent_Data['sold_price'],2).'</td>
					<td style="border-bottom:1px solid grey" width="10%">$ '.number_format(str_replace("-",'',$parent_Data['discount']),2).'</td>
					<td style="border-bottom:1px solid grey" width="10%">$ '.number_format($parent_Data['tax_value'],2).'</td>
					<td style="border-right: 1px solid grey; border-bottom:1px solid grey" width="10%">$ '.number_format(($parent_Data['sold_price']+$parent_Data['tax_value'])-$parent_Data['discount'],2).'</td>
                    </tr>';	
				}		 
			
				$total_item+= $a_data['quantity'];
				$sold_price+= $a_data['sold_price'];
				//$tax_value+= $a_data['tax_value'];
				//$discount+= $a_data['discount'];

				if($a_data['bill_tax']!='' or $a_data['bill_tax']!=0)
				{
	              $tax_value+= $a_data['bill_tax'];
				}
				else
				{
					$tax_value+= $a_data['tax_value'];
				}

				if($a_data['bill_discount']!='' or $a_data['bill_discount']!=0)
				{
	              $discount+= $a_data['bill_discount'];
				}
				else
				{
					$discount+= $a_data['discount'];
				}
			}
			$text_Sale = $text_Sale_html;
			
			$html = '
			<table cellpadding="2">
			<tr>
			<td align="left">
    		<img src="https://salequick.com/logo/'.$data['merchantdata'][0]['logo'].'"  width="60">
  			</td>
  			<td align="left" colspan="3">
  			<span style="font-size: 12px;font-weight:900;">'.ucfirst($data['merchantdata'][0]['business_name']).'</span> 
  			<br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['business_dba_name']).' </span> 
  			<br>&nbsp;&nbsp;<span>'.ucfirst($data['merchantdata'][0]['address1']).'</span>
			</td>
			<td>
			</td>
			<td>
			</td>
			<td  align="right" colspan="3"> 
			Report Period: '.$enddate.', 12:00 am <br>-'.$startdate.', 11:59 pm
			<br> Generated -   '.$enddatee.'
			</td>
			</tr>
			</table>
		
			<table cellpadding="2">
				<tr>
					<td> <h2>'.($total_item+$total_item_s+$total_item_m).'</h2> <br> Total Item Sold </td>
					<td> <h2>$ '.number_format(($package_data_total_count_confirm[0]['amount']+$package_data_total_count_refund[0]['amount']+$sold_price+$tax_value+$sold_price_s+$tax_value_m+$sold_price_m+$tax_value_m)-($discount+$refund_amount+$package_data_total_count_refund[0]['amount']+$discount_s),2).'</h2> <br> Total Paid  </td>
					<td> 
					<h2>'.($total_order_split+$total_order+$package_data_total_count_confirm[0]['id']+$package_data_total_count_refund[0]['id']).'</h2> <br>Number Of Orders 
					</td>
					<td> <h2>$ '.number_format(($refund_amount_split+$refund_amount+$package_data_total_count_refund[0]['amount']),2).'</h2> <br> Total Refund  </td>
					
					<td colspan="2">
					</td>
				</tr>
			</table>
			<h3>Summary</h3>
			<table cellpadding="2">
				<tr >
					<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="30%">Item Name</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;"  width="10%">Sku</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Sold</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Total Refund</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">SubTotal</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Discount</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 10px;" width="10%">Tax</th>
					<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%">Grand Total</th>
				</tr>
				'.$textcolors.'
			</table>';
			$html_Sale = '<h3>Item Sale</h3>
			<table cellpadding="2">
				<tr>
					<th bgcolor="#cccccc" style="border-left: 1px solid grey; border-bottom:1px solid grey;font-size: 10px;" width="10%" >Date</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%" >Transaction id</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;"  width="15%">Order Id </th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="15%">Item Name</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="5%">Qty</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="9%">SubTotal</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="8%">Discount</th>
					<th bgcolor="#cccccc" style=" border-bottom:1px solid grey;font-size: 9px;" width="7%">Tax</th>
					<th bgcolor="#cccccc" style="border-bottom:1px solid grey;font-size: 9px;" width="10%">Grand Total</th>
					<th bgcolor="#cccccc" style="border-right: 1px solid grey; border-bottom:1px solid grey;font-size: 9px;" width="7%">Status</th>
				</tr>'.$text_Sale.'
			</table>';
			$content = $textcolors;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->setDestination('Summary', 0, '');
			$obj_pdf->Bookmark('Summary', 0, 0, '', 'BI', array(128,0,0), -1, '#Summary');
			$obj_pdf->Cell(0, 10, 'Summary', 0, 1, 'L');
			$obj_pdf->writeHTML($html, true, false, true, false, '');
			$obj_pdf->AddPage();
			$obj_pdf->setDestination('Item Sale', 0, '');
			$obj_pdf->Bookmark('Item Sale', 0, 0, '', 'BI', array(128,0,0), -1, '#Item Sale');
			$obj_pdf->Cell(0, 10, 'Item Sale', 0, 1, 'L');
			$obj_pdf->writeHTML($html_Sale, true, false, true, false, '');
			$obj_pdf->Output('Inventory Report.pdf', 'D');
		}
	}

}