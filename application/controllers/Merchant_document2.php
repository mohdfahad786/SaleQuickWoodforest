<?php ini_set('MAX_EXECUTION_TIME', '-1');
ini_set('memory_limit','2048M');
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Merchant_document extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('profile_model'); 
		$this->load->model('admin_model');
		$this->load->model('Inventory_model');
		$this->load->model('Inventory_graph_model');
		$this->load->model('Home_model');
		$this->load->library('email');
		$this->load->helper('pdf_helper');
		$this->load->model('customers_model', 'customers');
		date_default_timezone_set("America/Chicago");
		// ini_set('display_errors', 1);
	 //    error_reporting(E_ALL);
	    // ini_set('max_execution_time', -1);
	}

	public function ongoing_notes() {
		$data['meta'] = 'Ongoing Notes';

		$merchant_id = $this->uri->segment(3);
		$data['merchant_id'] = $merchant_id;

		$merchant = $this->db->select('business_dba_name,email')->where('id', $merchant_id)->get('merchant')->row();
		$data['merchant'] = $merchant;

		$ongoing_notes = $this->db->select('on.*, a.name as created_by')
			->from('merchant_ongoing_notes on')
			->where('merchant_id', $merchant_id)
			->join('admin a', 'on.created_by = a.id')
			->order_by('on.id','desc')
			->get()->result_array();
		$data['ongoing_notes'] = $ongoing_notes;

		if($_POST) {
			$merchant_id = $this->input->post('merchant_id') ? $this->input->post('merchant_id') : '';
			$subject = $this->input->post('subject') ? $this->input->post('subject') : '';
			$note = $this->input->post('note') ? $this->input->post('note') : '';
			$created_by = $this->session->userdata('id');

			$myfile=$_FILES['attachment']['name'];
			if($myfile!="") {
				$attach_arr = explode('.', $_FILES['attachment']['name']);
                $new_name = $attach_arr[0].date().time().'.'.$attach_arr[1];
				// echo $new_name;die;
                $config['file_name']            = $new_name; 
                $config['upload_path']          = './uploads/attachment/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|doc|pdf|docx';
                $config['max_size']             = '0';
                $config['max_width']            = '0';
                $config['max_height']           = '0';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('attachment')) {
                    $data = array('upload_data' => $this->upload->data());
                    $uploadedFileName=$data['upload_data']['file_name']; 
                } else {
                	$this->session->set_flashdata('error',$this->upload->display_errors());
		            redirect(base_url('merchant_document/ongoing_notes/'.$merchant_id));
                }

            } else {
                $uploadedFileName="";
            }
            $attachment=$uploadedFileName;

            $myfile2=$_FILES['attachment2']['name'];
            if($myfile2!="") {
				$attach_arr2 = explode('.', $_FILES['attachment2']['name']);
                $new_name2 = $attach_arr2[0].date().time().'.'.$attach_arr2[1];
				// echo $new_name2;die;
                $config2['file_name']            = $new_name2; 
                $config2['upload_path']          = './uploads/attachment/';
                $config2['allowed_types']        = 'gif|jpg|png|jpeg|doc|pdf|docx';
                $config2['max_size']             = '0';
                $config2['max_width']            = '0';
                $config2['max_height']           = '0';
                $this->load->library('upload2', $config2);
                if ($this->upload2->do_upload('attachment2')) {
                    $data2 = array('upload_data' => $this->upload2->data());
                    $uploadedFileName2=$data2['upload_data']['file_name']; 
                } else {
                	$this->session->set_flashdata('error',$this->upload->display_errors());
		            redirect(base_url('merchant_document/ongoing_notes/'.$merchant_id));
                }

            } else {
                $uploadedFileName2="";
            }
            $attachment2=$uploadedFileName2;

			$ins_data = array(
				'merchant_id' => $merchant_id,
				'subject' => $subject,
				'note' => $note,
				'created_by' => $created_by,
				'attachment' => $attachment,
				'attachment2' => $attachment2,
			);
			$this->db->insert('merchant_ongoing_notes', $ins_data);
			$this->session->set_flashdata('success','Ongoing notes added successfully.');
            redirect(base_url('merchant_document/ongoing_notes/'.$merchant_id));
		}
		$this->load->view('admin/ongoing_notes', $data);
	}

	public function sorted_ongoing_notes() {
		$response = array();
		$merchant_id = $this->input->post('merchant_id') ? $this->input->post('merchant_id') : '';
		$value = $this->input->post('value') ? $this->input->post('value') : '';

		$sorted_as = ($value == 'new_to_old') ? 'desc' : 'asc';

		$ongoing_notes = $this->db->select('on.*, a.name as created_by')
		->from('merchant_ongoing_notes on')
		->where('merchant_id', $merchant_id)
		->join('admin a', 'on.created_by = a.id')
		->order_by('on.id', $sorted_as)
		->get()->result_array();

		$notes_data = '';
		if(!empty($ongoing_notes)) {
			foreach ($ongoing_notes as $key => $val) {
				$subject = (strlen($val['subject']) > 25) ? substr($val['subject'], 0, 25).'...' : $val['subject'];

				$content = (strlen($val['note']) > 60) ? substr($val['note'], 0, 60).'...' : $val['note'];

				$edit_link = base_url('merchant_document/edit_ongoing_notes/'.$merchant_id.'/'.$val['id']);

				if(!empty($val['attachment'])) {
	                $ext = pathinfo($val['attachment'], PATHINFO_EXTENSION);
	                if( ($ext == 'jpg') || ($ext == 'png') ||($ext == 'jpeg') ||($ext == 'gif') ) {
	                	$attachment = base_url().'uploads/attachment/'.$val['attachment'];
	                    $attachment_data = '<div class="text-right" style="width: 30px;">
	                        <a class="attachment_img" href="javascript:void(0)" data-src="'.$attachment.'" data-alt="'.$val['attachment'].'">
	                            <i class="fa fa-paperclip"></i>
	                        </a>
	                    </div>';
	                } else {
	                	$attachment = base_url().'uploads/attachment/'.$val['attachment'];
	                    $attachment_data = '<div class="text-right" style="width: 30px;">
	                        <a class="download_doc" href="javascript:void(0)" data-src="'.$attachment.'">
	                            <i class="fa fa-paperclip attachment_doc" data-src="'.$attachment.'" data-alt="'.$val['attachment'].'"></i>
	                        </a>
	                    </div>';
	                }
	            }

				$notes_data .= '<div class="col-sm-6 col-md-4 col-lg-4 mb-4">
	                <div class="card notes_card">
	                    <div class="card-body" style="padding: 25px !important;">
	                        <div style="display: flex !important;">
	                            <div style="width: calc(100% - 30px);">
	                                <h5 class="subject_head" data-id="'.$val["id"].'" style="font-weight: 600 !important;">'.$subject.'</h5>
	                            </div>'.$attachment_data.'
	                        </div>
	                        <p class="mb-3">'.date("d F Y", strtotime($val["updated_at"])).'</p>
	                        <div style="min-height: 42px;">
	                            <p>'.$content.'</p>
	                        </div>
	                    </div>
	                    <div class="card-footer notes_card_footer">
	                        <div class="row">
	                            <div class="col-10">By: <strong>'.$val["created_by"].'</strong></div>
	                            <div class="col-2 text-right"><a href="'.$edit_link.'" title="Edit"><i class="fa fa-pencil" style="padding: 3px 0px !important;"></i></a></div>
	                        </div>
	                    </div>
	                </div>
	            </div>';
			}

			$response = array(
				'status' => 200,
				'content' => $notes_data
			);
			
		} else {
			$response = array(
				'status' => 400,
				'content' => ''
			);
		}
		echo json_encode($response);die;
	}

	public function get_single_ongoing_note() {
		$id = $_POST['id'];
		$note = $this->db->get_where('merchant_ongoing_notes', ['id' => $id])->row();

		if(!empty($note->created_by)) {
			$arr1 = $this->db->select('name as created_by')->where('id',$note->created_by)->from('admin')->get()->row();
			$note->created_by = $arr1->created_by;
		}
		if(!empty($note->updated_by)) {
			$arr2 = $this->db->select('name as updated_by')->where('id',$note->created_by)->from('admin')->get()->row();
			$note->updated_by = $arr1->updated_by;
		}
		$note->updated_at = date('d F Y', strtotime($note->updated_at));
		// print_r($note);die;
		echo json_encode($note);die;
	}

	public function edit_ongoing_notes() {
		// echo $this->uri->segment(4);die;
		$data['meta'] = 'Edit Ongoing Notes';

		$merchant_id = $this->uri->segment(3);
		$data['merchant_id'] = $merchant_id;

		$id = $this->uri->segment(4);
		$data['on_id'] = $id;

		$merchant = $this->db->select('business_dba_name,email')->where('id', $merchant_id)->get('merchant')->row();
		$data['merchant'] = $merchant;

		$ongoing_notes = $this->db->where('id', $id)->get('merchant_ongoing_notes')->row();
		$data['ongoing_notes'] = $ongoing_notes;
		// echo '<pre>';print_r($ongoing_notes);die;

		if($_POST) {
			// echo '<pre>';print_r($_FILES);die;
			$on_id = $this->input->post('on_id') ? $this->input->post('on_id') : '';
			// $merchant_id = $this->input->post('merchant_id') ? $this->input->post('merchant_id') : '';
			$subject = $this->input->post('subject') ? $this->input->post('subject') : '';
			$note = $this->input->post('note') ? $this->input->post('note') : '';
			$old_file = $this->input->post('old_file') ? $this->input->post('old_file') : '';
			$old_file2 = $this->input->post('old_file2') ? $this->input->post('old_file2') : '';
			$updated_by = $this->session->userdata('id');

			$myfile=$_FILES['attachment']['name'];
			if($myfile!="") {
				$attach_arr = explode('.', $_FILES['attachment']['name']);
                $new_name = $attach_arr[0].date().time().'.'.$attach_arr[1];
				// echo $new_name;die;
                $config['file_name']            = $new_name; 
                $config['upload_path']          = './uploads/attachment/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|doc|pdf|docx';
                $config['max_size']             = '0';
                $config['max_width']            = '0';
                $config['max_height']           = '0';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('attachment')) {
                    $data = array('upload_data' => $this->upload->data());
                    $attachment = $data['upload_data']['file_name']; 
                } else {
                	$this->session->set_flashdata('error',$this->upload->display_errors());
		            redirect(base_url('merchant_document/edit_ongoing_notes/'.$merchant_id.'/'.$on_id));
                }

            } else {
                $attachment = $old_file;
            }
            // echo $attachment;die;

            $myfile2=$_FILES['attachment2']['name'];
            if($myfile2!="") {
				$attach_arr2 = explode('.', $_FILES['attachment2']['name']);
                $new_name2 = $attach_arr2[0].date().time().'.'.$attach_arr2[1];
				// echo $new_name2;die;
                $config2['file_name']            = $new_name2; 
                $config2['upload_path']          = './uploads/attachment/';
                $config2['allowed_types']        = 'gif|jpg|png|jpeg|doc|pdf|docx';
                $config2['max_size']             = '0';
                $config2['max_width']            = '0';
                $config2['max_height']           = '0';
                $this->load->library('upload2', $config2);
                if ($this->upload2->do_upload('attachment2')) {
                    $data2 = array('upload_data' => $this->upload2->data());
                    $attachment2=$data2['upload_data']['file_name']; 
                } else {
                	$this->session->set_flashdata('error',$this->upload->display_errors());
		            redirect(base_url('merchant_document/ongoing_notes/'.$merchant_id));
                }

            } else {
                $attachment2 = $old_file2;
            }

			$up_data = array(
				// 'merchant_id' => $merchant_id,
				'subject' => $subject,
				'note' => $note,
				'updated_by' => $updated_by,
				'attachment' => $attachment,
				'attachment2' => $attachment2,
			);
			$this->db->where('id', $on_id);
			$this->db->update('merchant_ongoing_notes', $up_data);
			// $this->db->insert('merchant_ongoing_notes', $ins_data);
			$this->session->set_flashdata('success','Ongoing notes updated successfully.');
            redirect(base_url('merchant_document/ongoing_notes/'.$merchant_id));
		}
		$this->load->view('admin/edit_ongoing_notes', $data);
	}

	public function all_pdfs() {
		$data['meta'] = 'All PDFs';

		$merchant_id = $this->uri->segment(3);
		$data['merchant_id'] = $merchant_id;

		$merchant = $this->db->select('business_dba_name,email')->where('id', $merchant_id)->get('merchant')->row();
		$data['merchant'] = $merchant;

		$documents = array();
		$all_pdfs = $this->db->select('md.*, a.name as created_by')
			->from('merchant_document md')
			->where('merchant_id', $merchant_id)
			->join('admin a', 'md.created_by = a.id')
			->get()->result_array();
		// $data['all_pdfs'] = $all_pdfs;
		foreach ($all_pdfs as $key => $pdf) {
			$package['id'] = $pdf['id'];
			$package['merchant_id'] = $pdf['merchant_id'];
			$package['file_name'] = $pdf['file_name'];
			$package['created_by'] = $pdf['created_by'];
			$package['updated_at'] = $pdf['updated_at'];
			$package['via'] = 'merchant_document';
			$documents[] = $package;
		}

		$agreement_mails = $this->db->where('merchant_id', $merchant_id)->order_by('id', 'DESC')->get('agreement_mail_log')->result_array();
		// echo '<pre>';print_r($agreement_mails);die;
		foreach ($agreement_mails as $key => $mail) {
			if(!empty($mail['ip_address'])) {
				// print_r($mail);
				// echo $mail['add_datetime'];die;
				$file_name = str_replace(" ","_",$merchant->business_dba_name);
				$file_name = str_replace("'","",$file_name);
				$file_name = 'Merchant_Agreement_Details_'.$file_name.date('Ymdhis', strtotime($mail['add_datetime'])).'.pdf';
				// echo $file_name;die;

				$admin = $this->db->select('name')->where('id',$mail['admin_id'])->get('admin')->row();

				$package['id'] = $mail['id'];
				$package['merchant_id'] = $mail['merchant_id'];
				$package['file_name'] = $file_name;
				$package['created_by'] = $admin->name;
				$package['updated_at'] = $mail['add_datetime'];
				$package['via'] = 'agreement_mail_log';
				$documents[] = $package;
			}
		}
		// echo '<pre>';print_r($documents);die;
		// die;
		$data['all_pdfs'] = $documents;

		$this->load->view('admin/upload_document', $data);
	}

	public function upload_pdf_file() {
		// print_r($_FILES['file']['name']);die;
		$file_name = str_replace(' ','_',$_FILES['file']['name']);
		$file_name_new = time() . '_' . $file_name;
		// echo $file_name_new.','.$_FILES['file']['tmp_name'];die;
		move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/attachment/' . $file_name_new);

		$merchant_id = $this->uri->segment(3);
		$created_by = $this->session->userdata('id');

		$ins_data = array(
			'merchant_id' => $merchant_id,
			'file_name' => $file_name_new,
			'created_by' => $created_by
		);
		$this->db->insert('merchant_document', $ins_data);
		echo "PDF uploaded successfully.";
	}

	public function pdf_document() {
		$doc_id = $this->uri->segment(3);
		// echo $doc_id;die;

		$agreement_mail = $this->db->where('id',$doc_id)->get('agreement_mail_log')->row();
		// print_r($agreement_mail);die;

		$merchant = $this->db->select('business_dba_name,email')->where('id', $agreement_mail->merchant_id)->get('merchant')->row();

		$file_name = str_replace(" ","_",$merchant->business_dba_name);
		$file_name = str_replace("'","",$file_name);
		$file_name = 'Merchant_Agreement_Details_'.$file_name.date('Ymdhis', strtotime($agreement_mail->add_datetime)).'.pdf';

		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Merchant Agreement Details";
        $title_head = '';
		$obj_pdf->SetTitle($title);
		//$obj_pdf->SetHeaderData($data['merchantdata'][0]['logo'], PDF_HEADER_LOGO_WIDTH, $title,$title_head);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetHeaderMargin(10);
		$obj_pdf->SetFooterMargin(10);
		$obj_pdf->SetMargins(10, 10, 10);
		$obj_pdf->SetAutoPageBreak(TRUE, 10);

		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->AddPage();
		
		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->setHeaderTemplateAutoreset(true);
		ob_start();

		$pdf_html = '<h1 style="text-align: center;">MERCHANT SERVICES AGREEMENT</h1>
		<p style="text-align: justify;">This Payment Services Agreement (Agreement) is made by and between Milstead Technologies, a Texas limited liability company doing business as SaleQuick (SaleQuick), and the entity or person (Submerchant, You, Your) who completed the SaleQuick registration process to receive payment services.This Agreement sets forth the payment services SaleQuick will provide (Payment Services) and the terms that govern your use of the Payment Services, which are separate from any other services that SaleQuick may provide under any other agreement with you. This Agreement is in addition to the SaleQuick Terms of Use (TOU) that govern your use of the SaleQuick website and mobile application. If there is any conflict between the terms of this Agreement and the TOU, then to the extent such terms apply to the Payment Services, the terms of this Agreement will control.</p>
		<div class="et_pb_blurb_container">
		    <br>
		    <h4 class="et_pb_module_header"><span style="text-align:justify;">BE ADVISED THAT THIS AGREEMENT CONTAINS PROVISIONS THAT GOVERN HOW DISPUTES BETWEEN YOU AND US ARE RESOLVED, WHICH INCLUDE AN AGREEMENT TO SUBMIT ANY DISPUTE RELATED TO THE PAYMENT SERVICES TO BINDING INDIVIDUAL ARBITRATION RATHER THAN PROCEEDING IN COURT. THIS AGREEMENT ALSO INCLUDES A CLASS ACTION WAIVER, WHICH MEANS YOU AGREE NOT TO PROCEED WITH ANY DISPUTE AS PART OF A CLASS ACTION. SEE SECTION 12 OF THIS AGREEMENT FOR FURTHER INFORMATION.</span></h4>
		    <br>
		</div>
		<p style="text-align: justify;">SaleQuick is a payment facilitator  and you are a submerchant or sponsored merchant, as those terms are defined by Mastercard International Incorporated (Mastercard), Visa Inc. (Visa), Discover Financial Services (Discover), American Express Company (American Express), each including applicable subsidiaries, and certain other payment card associations (collectively, Card Brands). This Agreement is consistent with the Card Brands’ requirement that Submerchant enter into a submerchant or sponsored merchant agreement with SaleQuick to receive Payment Services.
		    This Agreement is effective as of the date you confirm your acceptance by completing the SaleQuick Merchant Account registration process or by using the Payment Services (Effective Date).<br>
		    <br>
		    This Agreement may subject you to an early termination fee if terminated prior to the end of the initial term. See Section 9.4 of this Agreement for further information.
		</p>

		<h4>1. DEFINITIONS</h4>
		<p style="text-align: justify;">1.1.	<b>ACH</b> means a national automated clearinghouse system and an electronic fund transfer made through an ACH.</p>
		<p style="text-align: justify;">1.2.	<b>Authorization</b> means an approval or the act of obtaining an approval through a Card Brand for an individual Transaction.</p>
		<p style="text-align: justify;">1.3.	<b>Brand Marks</b> means the trade name, trademark, service mark, logo, and logo type of each Card Brand.</p>
		<p style="text-align: justify;">1.4.	<b>Brand Materials</b> means any promotional or instructional materials provided to Submerchant that use or contain any Brand Marks.</p>
		<p style="text-align: justify;">1.5.	<b>Card</b> means a valid credit, debit, charge, stored value, or payment card issued under license from a Card Brand, including physical, electronic, and virtual devices used to access a Card Brand.</p>
		<p style="text-align: justify;">1.6.	<b>Cardholder</b> means any person authorized to use a Card or the accounts established in connection with a Card.</p>
		<p style="text-align: justify;">1.7.	<b>Cardholder</b> Data means all information that a Cardholder provides in the course of completing a Transaction with Submerchant, including Card numbers and expiration dates, account numbers, and other personal Cardholder information.</p>
		<p style="text-align: justify;">1.8.	<b>Chargeback</b> means any reversal, return, or invalidation of a Transaction (or portion of a Transaction) through a Card Brand.</p>
		<p style="text-align: justify;">1.9.	<b>Force Majeure Event</b> means any delay or failure of SaleQuick to perform its obligations under this Agreement arising from any cause or causes beyond SaleQuick’s reasonable control, including natural disasters, extreme weather, infrastructure failures, civil unrest, public health events, governmental order, and nonperformance of SaleQuick’s service providers.</p>
		<p style="text-align: justify;">1.10.	<b>Law</b> means all applicable federal, state, and local laws, statutes, regulations, rules, ordinances, codes, and court orders, and all applicable regulatory orders, directives, and guidance that govern or affect this Agreement or the subject matter hereof.</p>
		<p style="text-align: justify;">1.11.	<b>Location</b> means each separate location, office, building, or branch operated by Submerchant where or for which Submerchant accepts Card payments, provided that each Location must operate under the same employer identification number or tax identification number as Submerchant.</p>
		<p style="text-align: justify;">1.12.	<b>Member Bank</b> means a bank that is a member of the Card Brands and provides sponsorship services in connection with this Agreement. As of the commencement of this Agreement, Member Bank is Fifth Third Bank of Cincinnati, Ohio. The Member Bank may be changed at any time without prior notice to Submerchant.</p>
		<p style="text-align: justify;">1.13.	<b>PCI DSS</b> means the Payment Card Industry (PCI) Data Security Standard published by the PCI Security Standards Council.</p>
		<p style="text-align: justify;">1.14.	<b>Processor</b> means a payment processor that supports the Payment Services through its contracts with the Card Brands. As of the commencement of this Agreement, Processor is Worldpay by FIS of Jacksonville, Florida. The Processor may be changed at any time without prior notice to Submerchant.</p>
		<p style="text-align: justify;">1.15.	<b>Regulatory Authority</b> means any federal, state, or local government or any agency, board, commission, court, department, or division thereof, having jurisdiction, supervisory authority, or enforcement powers over any party to this Agreement, but which does not include any Card Brand. Such Regulatory Authorities include the U.S. Treasury Financial Crimes Enforcement Network, U.S. Treasury Office of Foreign Assets Control, Board of Governors of the Federal Reserve System (Federal Reserve), Internal Revenue Service (IRS), and Federal Trade Commission.</p>
		<p style="text-align: justify;">1.16.	<b>Rules</b> means the bylaws, operating rules, regulations, policies, and procedures of any applicable Card Brand, including the PCI DSS and any manuals, guides, or bulletins, as in effect from time to time.</p>
		<p style="text-align: justify;">1.17.	<b>SaleQuick Merchant Account</b>. means the SaleQuick account registered to Submerchant that Submerchant uses pursuant to the TOU to access the Payment Services and other services provided by SaleQuick.</p>
		<p style="text-align: justify;">1.18.	<b>Security Requirements</b> means the security requirements under the USA PATRIOT Act and any similar Law and the security requirements of the Card Brands, including where applicable, the PCI DSS, the Visa Cardholder Information Security Program, the Mastercard Site Data Protection Program, and the Visa and Mastercard Data Security Standards.</p>
		<p style="text-align: justify;">1.19.	<b>Third Party Agent or TPA</b> means any entity engaged by Submerchant to perform contracted services on behalf of Submerchant.</p>
		<p style="text-align: justify;">1.20.	<b>Transaction</b> means a Card transaction between Submerchant and a Cardholder processed through a Card Brand using the Payment Services that relates to the sale of Submerchant’s goods or services to the Cardholder.</p>
		<p style="text-align: justify;">1.21.	<b>Transaction Account</b> means the Submerchant-owned bank account that Submerchant designates to receive Transaction Funds for settlement from Processor and Member Bank.</p>
		<p style="text-align: justify;">1.22.	<b>Transaction Funds</b> means the funds processed through the Card Brands and received by Processor and Member Bank for payments made by Cardholders to Submerchant for Transactions.</p>

		<h4>2. THE PAYMENT SERVICES</h4>
		<p style="text-align: justify;"><b>  2.1.	Description.</b></p>
		<p style="text-align: justify;">(a)	Submerchant is a provider of professional, tradecraft, or hospitality services. The Payment Services allow Submerchant to accept Cards for the payment of fees, costs, supplies, and goods associated with such services. </p>
		<p style="text-align: justify;">(b)	SaleQuick will provide Submerchant with Payment Services in accordance with the terms of this Agreement. </p>
		<p style="text-align: justify;">(c)	Submerchant will use the Payment Services for business purposes only and not for any personal, family, or household purposes.</p>
		<p style="text-align: justify;"><b>  2.2.	Underwriting and Required Information.</b></p>
		<p style="text-align: justify;">(a)	After Submerchant completes an application for Payment Services, such Payment Services will not be available to Submerchant unless and until SaleQuick, Processor, and Member Bank confirm that Submerchant is eligible under the Rules and Law to use the Payment Services.</p>
		<p style="text-align: justify;">(b)	Submerchant authorizes SaleQuick to make any investigation of Submerchant’s finances, activities, and operations that SaleQuick reasonably deems necessary to confirm Submerchant’s eligibility for Payment Services. Submerchant agrees to provide SaleQuick with any information required to complete such investigation and authorizes SaleQuick to share such information with Processor and Member Bank as necessary to provide the Payment Services.</p>
		<p style="text-align: justify;">(c)	Submerchant agrees that all information Submerchant provides to SaleQuick is and will be accurate and complete, and Submerchant agrees to keep such information up-to-date. Upon request, Submerchant will provide (i) the current addresses of all Locations, (ii) a list of all assumed business names used by Submerchant, and (iii) a list of all products and services offered by Submerchant.</p>
		<p style="text-align: justify;">(d)	Submerchant authorizes SaleQuick to make any background, identity-verification, credit, and transaction-verification inquiries that SaleQuick reasonably deems necessary and authorizes any credit reporting agency to compile information to answer such inquiries and furnish that information to SaleQuick. Submerchant also authorizes SaleQuick to share the results of such inquiries with Processor and Member Bank as necessary to provide the Payment Services. If applicable, for any background, credit, or other check or report on Submerchant’s owners, officers, directors, or other principals, each in their individual capacities, Submerchant agrees to work with SaleQuick to obtain any necessary authorizations from such individuals.</p>
		<p style="text-align: justify;">(e)	To help the government fight the funding of terrorism and prevent money-laundering, Law may require SaleQuick, Processor, Member Bank, or Card Brands to obtain, verify, and record information that identifies Submerchant, its beneficial owners, officers, and other individuals associated with Submerchant or that have access to the Payment Services. Upon request, Submerchant will provide SaleQuick, Processor, Member Bank, or Card Brands, as applicable, the documentary and other evidence of Submerchant’s identity, those of its beneficial owners, or the identity of any individual to whom Submerchant provides access to the Payment Services, to permit those entities to comply with the Rules and Law. Submerchant agrees that SaleQuick, Processor, Member Bank, and Card Brands may disclose such information as required to comply with their obligations under Law.</p>
		<p style="text-align: justify;">(f)	Submerchant will provide SaleQuick with written notice, with respect to the Submerchant, of any (i) adverse change in financial condition, (ii) planned or anticipated liquidation or substantial change to the basic nature of its business, (iii) transfer or sale of twenty-five percent (25%) or more in value of its ownership, voting stock, beneficial interest, or total assets, or (iv) levy against twenty-five percent (25%) or more in value of its total assets. Submerchant will provide any such notice not more than three (3) days after Submerchant learns of any such event.</p>
		<p style="text-align: justify;"><b>2.3.	Equipment. </b></p>
		<p style="text-align: justify;">In the event Submerchant rents or purchases any equipment from SaleQuick in connection with the Payment Services, Submerchant agrees to abide by the applicable terms and conditions of the separate agreement with SaleQuick executed for such purpose.</p>

		<h4>3. CARD ACCEPTANCE</h4>
		<p style="text-align: justify;">3.1.	Submerchant will honor any valid Card properly tendered by a person asserting to be the Cardholder. Submerchant will only accept Cards for Transactions that are bona fide sales of the Submerchant’s goods or services.</p>
		<p style="text-align: justify;">3.2.	Submerchant will properly disclose to the Cardholder at the time of the Transaction Submerchant’s name, return policy, and any limitations Submerchant may have on accepting returned goods. Submerchant’s refund polices for purchases made with a Card must be at least as favorable as Submerchant’s refund policy for purchases made with any other form of payment. </p>
		<p style="text-align: justify;">3.3.	Submerchant may set a minimum Transaction amount to accept a Card, provided that such minimum does not differentiate among Card issuers or among Card Brands and that such minimum complies with the Federal Reserve’s limits for Transaction minimums. </p>
		<p style="text-align: justify;">3.4.	Submerchant is required to obtain an Authorization for each Transaction and include the Authorization when transmitting each Transaction. Authorizations are not a guarantee of acceptance or payment of a Transaction, do not waive any provision of this Agreement, and do not otherwise validate a fraudulent Transaction or a Transaction involving the use of an expired Card. SaleQuick, Processor, or Member Bank may refuse to authorize any transaction.</p>
		<p style="text-align: justify;">3.5.	All Transactions are subject to audit and verification by SaleQuick, Processor, or Member Bank and may be adjusted for inaccuracies. All credits provided to Submerchant are provisional and subject to Chargebacks and adjustments in accordance with the Rules, irrespective of whether a Transaction is returned or reversed by the Card issuer. </p>
		<p style="text-align: justify;">3.6.	Submerchant will retain a copy of the sales transmittal for each completed Transaction in accordance with the Rules and Law. Upon request by Processor or Member Bank, Submerchant will provide copies of sales transmittals and other Transaction evidence. </p>

		<h4>4. COMPLIANCE WITH THE RULES AND LAW</h4>
		<p style="text-align: justify;">4.1.	Submerchant agrees to comply, and to cause its TPAs to comply, with this Agreement, the Rules, and Law, including anti–money-laundering and economic sanctions Law. In the event of any conflict between the terms of this Agreement and the Rules, the Rules will prevail.</p>
		<p style="text-align: justify;">4.2.	Submerchant agrees to assist SaleQuick, Processor, and Member Bank to monitor Submerchant’s compliance with the Rules and Law. SaleQuick, Processor, or Member Bank, each in its sole discretion, may suspend processing Transactions for a reasonable period of time required to investigate suspicious or unusual activity, and each will have no liability for any Submerchant losses arising from any such suspension. SaleQuick, Processor, or Member Bank, each in its sole discretion, may reverse any Transaction that violates this Agreement, the Rules, or Law, and Submerchant agrees to reimburse SaleQuick, Processor, or Member Bank, as applicable, for any such reversal.</p>
		<p style="text-align: justify;">4.3.	Prohibited Activities. Submerchant must not:</p>
		<p style="text-align: justify;">(a)	Submit to a Card Brand any Transaction that the Submerchant knows or should know violates Law in either the Cardholder’s or Submerchant’s jurisdiction;</p>
		<p style="text-align: justify;">(b)	Submit to a Card Brand any Transaction that the Submerchant knows or should know is fraudulent or not authorized by the Cardholder;</p>
		<p style="text-align: justify;">(c)	Submit to a Card Brand any Transaction that is not the result of a sale between Submerchant and its customer;</p>
		<p style="text-align: justify;">(d)	Submit to a Card Brand any Transaction for the sale of any product or service or the results from any method of selling that is different from the products, services, and methods stated in the Submerchant’s application for Payment Services without the prior written consent of SaleQuick;</p>
		<p style="text-align: justify;">(e)	Submit (or resubmit) to a Card Brand any Transaction that was previously the subject of a Chargeback;</p>
		<p style="text-align: justify;">(f)	Submit to a Card Brand any Transaction that represents the refinancing of a debt, including an existing obligation to a Card Brand, an existing debt to the Submerchant that has been deemed uncollectable, or repayment for a dishonored check, except as expressly permitted under the Rules;</p>
		<p style="text-align: justify;">(g)	Add any tax or surcharge to Transactions, unless Law expressly requires or the Rules expressly permit Submerchant to impose such tax or surcharge (any amounts, if allowed, must be included in the transaction amount and not collected separately);</p>
		<p style="text-align: justify;">(h)	Ask or require a Cardholder to complete a document that, if mailed, would display in plain view any Cardholder Data;</p>
		<p style="text-align: justify;">(i)	Ask or require a Cardholder to waive any dispute rights;</p>
		<p style="text-align: justify;">(j)	Request or use a Card account number for any purpose other than as payment for its goods or services; and</p>
		<p style="text-align: justify;">(k)	Disburse funds to a Cardholder in the form of cash or scrip unless Submerchant is dispensing funds in the form of travelers checks (except if the sole purpose is to allow the Cardholder to make a cash purchase of goods or services from Submerchant) or as part of a Card Brand’s cash-back service, each as defined by, and in accordance with, the Rules.</p>
		<p style="text-align: justify;">4.4.	For any recurring Transactions, Submerchant will obtain and retain any consents and provide any notices, as required by the Rules and Law.</p>
		<p style="text-align: justify;">4.5.	Use of Brand Marks and Other Marks.</p>
		<p style="text-align: justify;">(a)	The Card Brands are the sole and exclusive owners of their respective Brand Marks, and Submerchant’s use of Brand Marks and Brand Materials must comply with the Rules.</p>
		<p style="text-align: justify;">(b)	Processor and Member Bank are the sole and exclusive owners of their respective trademarks, marks, and logos, and Submerchant’s use of such marks must comply with Processor’s and Member Bank’s express policies and written instructions.</p>
		<p style="text-align: justify;">(c)	At any time and without prior notice, Card Brands may require a change in or prohibit Submerchant’s use of Brand Marks and Brand Materials.</p>
		<p style="text-align: justify;">(d)	Submerchant’s right to use Brand Marks and, if applicable, Processor’s and Member Bank’s marks, will cease upon termination of this Agreement, and Submerchant agrees not to contest the ownership of all such marks for any reason.</p>
		<p style="text-align: justify;">4.6.	If Submerchant processes or is anticipated to process greater than $1,000,000 in Transactions with a Card Brand in any twelve (12) month period (or such other processing threshold as may be established by a Card Brand, respectively), you are required by the Rules to execute a separate agreement similar in substance to this Agreement that establishes a direct relationship with Member Bank. Accordingly, by executing this Agreement, Submerchant also executes and agrees to be bound by <b>Processor’s Merchant Services Agreement for Sub-Merchants</b> , available at the preceding hyperlink, which satisfies the requirement for such separate agreement.</p>

		<h4>5. SETTLEMENT AND TRANSACTION DISPUTES</h4>
		<p style="text-align: justify;"><b>5.1.	Transaction Accounts.</b></p>
		<p style="text-align: justify;">(a)	Submerchant will establish and maintain one or more deposit accounts to be the designated Transaction Account to receive Transaction Funds. Submerchant may establish a single Transaction Account for all Locations or a separate Transaction Account for each Location (or any combination thereof). Submerchant will provide SaleQuick with complete information regarding the Transaction Account for each Location. </p>
		<p style="text-align: justify;">(b)	Submerchant authorizes SaleQuick, Processor, and their service providers to initiate ACH credits and debits to each Transaction Account. Such authorization will remain in full force and effect until thirty (30) days after SaleQuick receives written notice from Submerchant of termination of this ACH authorization. SaleQuick and Processor reserve the right to terminate or suspend Payment Services at any time that Submerchant fails to provide an active Transaction Account with an ACH authorization</p>
		<p style="text-align: justify;">(c)	To ensure proper remittance of Transaction Funds, Submerchant is solely responsible for providing SaleQuick with and maintaining accurate contact, payment, and account information for each Transaction Account, including any applicable tax information.</p>
		<p style="text-align: justify;"><b>5.2.	Transaction Funds and Remittance.</b></p>
		<p style="text-align: justify;">(a)	Processor will remit Transaction Funds, less any amounts SaleQuick and Processor are authorized to deduct or withhold under this Agreement, to Submerchant by ACH to the Transaction Account after such Transactions Funds are received by Processor from the Card Brands.</p>
		<p style="text-align: justify;">(b)	Submerchant agrees that the deposit of Transaction Funds to the Transaction Account discharges SaleQuick, Processor, and Member Bank of any settlement obligation to Submerchant and that any dispute regarding the receipt or amount of settlement will be between SaleQuick and Submerchant. Submerchant also agrees that SaleQuick, Processor, and Member Bank have no settlement obligation to Submerchant regarding the proceeds from any Transaction that violates this Agreement, the Rules, or Law.</p>
		<p style="text-align: justify;">(c)	Amounts owed to Submerchant will be calculated based solely on records maintained by SaleQuick. It is Submerchant’s responsibility to promptly and consistently inspect Submerchant’s Transaction and settlement history, and Submerchant must immediately report any possible errors to SaleQuick.</p>
		<p style="text-align: justify;">(d)	If Submerchant believes Processor or SaleQuick has failed to remit Transaction Funds owed to Submerchant, Submerchant must notify SaleQuick in writing within sixty (60) days of the date of such remittance or from the date when Submerchant purports such remittance would have been due, specifying in reasonable detail the amounts Submerchant believes are owed. Submerchant’s failure to so notify SaleQuick will result in Submerchant’s waiver of any claim relating to such disputed remittance.</p>
		<p style="text-align: justify;"><b>5.3.	Reserve Account.</b></p>
		<p style="text-align: justify;">(a)	SaleQuick may, in its sole discretion or at the direction of Processor or Member Bank, require that Submerchant fund an account at Member Bank, in an amount determined by SaleQuick, as security for Submerchant’s current and future obligations under this Agreement. Submerchant authorizes SaleQuick and Processor to initiate ACH debits to the Transaction Account or withhold amounts that SaleQuick and Processor would otherwise pay to the Transaction Account for the purpose of funding, maintaining, or increasing the balance in the reserve account. SaleQuick may, without notice to Submerchant, apply funds in such reserve account against any amounts owed by Submerchant under this Agreement.</p>
		<p style="text-align: justify;">(b)	By executing this Agreement, Submerchant grants to SaleQuick a security interest in the funds held in any reserve account established pursuant to this section, and SaleQuick may exercise its rights with respect to such security interest without notice. Submerchant agrees to execute any documents and to perform any other action required to comply with and perfect the security interest.</p>
		<p style="text-align: justify;">(c)	Submerchant agrees that following termination of this Agreement, any funds remaining in the reserve account will not be returned to Submerchant until 180 days following the later of such termination or Submerchant’s final submission of a Transaction. Submerchant will remain liable for all fees or amounts incurred after any such return of funds.</p>
		<p style="text-align: justify;"><b>5.4.	Transaction Disputes.</b></p>
		<p style="text-align: justify;">(a)	Except for SaleQuick’s limited role in processing payments, SaleQuick is not involved in any underlying sale of goods or services by Submerchant. Submerchant agrees that all disputes between Submerchant and any Cardholder relating to a Transaction will be settled between Submerchant and the Cardholder. SaleQuick bears no responsibility for such disputes.</p>
		<p style="text-align: justify;">(b)	Card Brand inquiries about Transactions may cause Processor or Member Bank to Chargeback such Transactions. Processor and Member Bank will offset the value of such Chargebacks from the Transaction Funds that will be received for settlement to Submerchant. If Submerchant disagrees with a Chargeback, Submerchant may request a chargeback reversal within the applicable Card Brand’s timeline in the Rules.</p>
		<p style="text-align: justify;">(c)	Submerchant is subject to each Card Brand’s acceptance guidelines, monitoring programs, activity reporting requirements, and limits, including those relating to excessive credits, disputes, and chargebacks. Excessive Chargebacks may result in violation of the Rules, breach of this Agreement, and suspension of the Payment Services.</p>
		<p style="text-align: justify;">(d)	SaleQuick, Processor, and Member Bank may revoke, reverse, or offset any credit to Submerchant for a Transaction not made in compliance with this Agreement, the Rules, or Law or where such remittance to Submerchant was made erroneously.</p>

		<h4>6. FEES</h4>
		<p style="text-align: justify;"><b>6.1.	Fees and Other Amounts Owed. Submerchant agrees to pay to SaleQuick:</b></p>
		<p style="text-align: justify;">(a)	All service and processing fees and other charges specified in the Standard Fee Schedule, set forth in this Agreement or in Submerchant’s Sale Quick Merchant Account, as may be amended in accordance with this section;</p>
		<p style="text-align: justify;">(b)	Any adjustments, fees, penalties, or costs incurred by SaleQuick as a result of any dispute related to Transactions;</p>
		<p style="text-align: justify;">(c)	Any liabilities or other amounts SaleQuick incurs as a result of fraudulent use of Submerchant’s terminal for Authorizations, unauthorized use of or access to Cardholder Data on Submerchant’s systems, or any other payment transaction alleged to have been processed through the Payment Service; and</p>
		<p style="text-align: justify;">(d)	Any fees, fines, or penalties imposed by third parties (including Processor, Member Bank, and Card Brands) related to Chargebacks or any returned or cancelled remittance of Transaction Funds.</p>
		<p style="text-align: justify;"><b>6.2.	Submerchant authorizes and directs SaleQuick and Processor to deduct and set off from Transaction Funds the fees and other amounts Submerchant owes under this Agreement, and Submerchant understands that the Transaction Funds Processor remits to Submerchant will be net of these amounts.</b></p>
		<p style="text-align: justify;">(a)	In the event that any set off against Transaction Funds is not sufficient to cover the fees and other amounts owed under this Agreement, Submerchant agrees that SaleQuick or Processor may initiate an ACH debit to any Transaction Account for such amounts.</p>
		<p style="text-align: justify;">(b)	Submerchant agrees to maintain sufficient funds in the Transaction Accounts to satisfy all obligations to SaleQuick, Processor, and Member Bank contemplated by this Agreement. If the fees and other amounts owed under this Agreement, or an ACH debit for such amounts, cause the balance in a Transaction Account to be less than zero ($0), SaleQuick may charge an overdraft fee and require that Submerchant make a wire transfer to the Transaction Accounts within one (1) banking business day of notice.</p>
		<p style="text-align: justify;"><b>6.3.	From time to time, Processor, Member Bank, or Card Brands may change the fees each charges for Transactions and related services and processing. SaleQuick will provide Submerchant with thirty (30) days written prior notice of all such changes, and Submerchant’s submission of a Transaction or continued use of the Payment Services after the effective date of such notice will be deemed acceptance of such change.</b></p>
		<p style="text-align: justify;"><b>6.4.	SaleQuick may in its sole discretion offer an alternative Fee Schedule to Submerchant in writing. If Submerchant accepts such offer in writing, such alternative Fee Schedule replaces the Standard Fee Schedule in this Agreement, and Submerchant’s obligation to pay such alternative fees is the same as described in this section.</b></p>

		<h4>7. AUDITS, DATA, AND SECURITY</h4>
		<p style="text-align: justify;"><b>7.1.	Cooperation. Submerchant agrees to:</b></p>
		<p style="text-align: justify;">(a)	Cooperate in any legal audit, examination, or investigation as may be required by SaleQuick, Processor, Member Bank, Card Brands, or any Regulatory Authority; and</p>
		<p style="text-align: justify;">(b)	Upon request and reasonable prior notice, permit SaleQuick, Processor, or Member Bank (or a duly authorized representative thereof) to conduct an on-site inspection of Submerchant’s premises and examine Submerchant’s books, records, and systems, but only to the extent that each pertains to compliance with this Agreement and the Rules. </p>
		<p style="text-align: justify;"><b>7.2.	As between SaleQuick and Submerchant, all Cardholder Data will be owned by SaleQuick. SaleQuick hereby grants Submerchant for the term of this Agreement a revocable, unassignable license to use, reproduce, electronically distribute, disclose, and display Cardholder Data solely as necessary to (i) provide Submerchant’s products and services, (ii) comply with the Rules and Law, and (iii) assist law enforcement agencies by responding to requests for the disclosure of information in accordance with Law. For purposes of this section, Cardholder Data does not include magnetic stripe, Track-2, CVV2, CVC2, or CID data.</b></p>
		<p style="text-align: justify;"><b>7.3.	Submerchant agrees to implement and maintain secure systems for maintaining, accessing, processing, and transmitting Cardholder Data or Transaction information to SaleQuick, Processor, and Member Bank. Submerchant will ensure all such systems comply with the Security Requirements and will undertake any required self-assessments, audits, and web infrastructure scans. Submerchant agrees to keep secure all media containing Cardholder Data or Transaction information and destroy in a manner that will render the data unreadable all such media that is no longer necessary or appropriate to store. Submerchant agrees to comply with its obligations under Law regarding the confidentiality, use, and disclosure of Cardholder Data.</b></p>
		<p style="text-align: justify;"><b>7.4.	If there is actual or suspected unauthorized access of Cardholder Data or Transaction information in the possession of Submerchant or its TPAs, Submerchant must notify SaleQuick immediately, and in all events no later than forty-eight (48) hours after discovery, and cooperate with SaleQuick, Processor, and Member Bank regarding reasonable requests for information regarding the security breach.</b></p>
		<p style="text-align: justify;"><b>7.5.	Submerchant will not under any circumstances retain or store magnetic stripe, Track-2, CVV2, CVC2, or CID data after Authorization.</b></p>
		<p style="text-align: justify;"><b>7.6.	Submerchant will comply with all Laws, including any and all applicable privacy laws, related to the receipt, collection, compilation, use, storage, processing, sharing, safeguarding, security (both technical and physical), disposal, destruction, disclosure, or transfer of data (including Cardholder Data) on your website, in your systems, or otherwise in your possession or control. Submerchant will maintain industry best practices regarding continuity procedures and systems to ensure security of Cardholder Data and Transaction information in the event of a disruption, disaster, or failure of Submerchant’s data storage system or facility.</b></p>
		<p style="text-align: justify;"><b>7.7.	Confidential Information. The confidentiality of this Agreement and of any information or data shared between SaleQuick and Submerchant other than Cardholder Data will be governed by the confidentiality and intellectual property provisions set forth in the TOU.</b></p>

		<h4>8. USE OF THIRD PARTY AGENTS</h4>
		<p style="text-align: justify;"><b>8.1.	Submerchant may contract with TPAs to perform any or all of Submerchant’s duties and requirements under this Agreement, except for any duty or requirement that by its nature must be performed by Submerchant.</b></p>
		<p style="text-align: justify;"><b>8.2.	Submerchant must provide SaleQuick written prior notice regarding Submerchant’s use of any TPA. Submerchant will be and remain liable for any non-compliance or breach by a TPA of this Agreement, the Rules, or Law.</b></p>

		<h4>9. TERM AND TERMINATION</h4>
		<p style="text-align: justify;"><b>9.1.	The term of this Agreement commences on the Effective Date and continues for one (1) year. Unless terminated as permitted herein, the term of this Agreement will be automatically extended for one (1) year at the expiration of each term.</b></p>
		<p style="text-align: justify;"><b>9.2.	Either SaleQuick or Submerchant may terminate this Agreement at any time on at least thirty (30) days’ written notice unless otherwise expressly allowed in other provisions of this Agreement. If this Agreement is terminated prior to the end of the first one (1) year term, the early termination fee in Section 9.4 may apply.</b></p>
		<p style="text-align: justify;"><b>9.3.	SaleQuick may immediately terminate this Agreement or cease providing the Payment Services, without prior notice, if:</b></p>
		<p style="text-align: justify;">(a)	Submerchant fails to pay any amount to SaleQuick when due or fails to maintain a valid Transaction Account;</p>
		<p style="text-align: justify;">(b)	In SaleQuick’s reasonable opinion, the provision of Payment Services to Submerchant is a violation of the Rules or Law;</p>
		<p style="text-align: justify;">(c)	In SaleQuick’s reasonable opinion, Submerchant has violated or is likely to violate the Rules or Law;</p>
		<p style="text-align: justify;">(d)	SaleQuick is required to do so by Processor, Member Bank, any Card Brand, or any Regulatory Authority;</p>
		<p style="text-align: justify;">(e)	Submerchant is the subject of any bankruptcy or insolvency or makes an assignment for the benefit of its creditors; or</p>
		<p style="text-align: justify;">(f)	Submerchant does not submit any Transactions or does not otherwise use the Payment Services for thirty (30) days.</p>
		<p style="text-align: justify;">(g)	SaleQuick’s agreement with Processor or Member Bank terminates;</p>
		<p style="text-align: justify;">(h)	SaleQuick is deregistered by any Card Brand;</p>
		<p style="text-align: justify;">(i)	Member Bank ceases to be a member of the Card Brands or to have the required licenses;</p>
		<p style="text-align: justify;"><b>9.4.	Early Termination Fee. Within the first one (1) year term only, if Submerchant terminates this Agreement for any reason or if SaleQuick terminates this Agreement pursuant to any of section 9.3(a)–(f), Submerchant will be subject to and agrees to pay an early termination fee of three hundred dollars ($300). Such fee will not be prorated and will be due and payable upon termination. After the first one (1) year term, there will be no termination fee.</b></p>
		<p style="text-align: justify;"><b>9.5.	If this Agreement is terminated for any reason, Submerchant’s obligations regarding any Transactions accepted for processing will survive termination, and any amounts owed by Submerchant to SaleQuick will become immediately due and payable. Submerchant authorizes SaleQuick to debit such amounts from any Transaction Account, and if the funds in such account are insufficient, Submerchant agrees to immediately pay any remaining amounts owed.</b></p>

		<h4>10. REPRESENTATIONS AND WARRANTIES</h4>
		<p style="text-align: justify;"><b>10.1.	Submerchant represents the following:</b></p>
		<p style="text-align: justify;">(a)	Submerchant and the authorized signatory executing this Agreement have the full power and authority to execute, deliver, and perform this Agreement;</p>
		<p style="text-align: justify;">(b)	This Agreement is binding and enforceable against Submerchant, and no provision requiring Submerchant’s performance is in conflict with its obligations under any agreement to which Submerchant is a party; and</p>
		<p style="text-align: justify;">(c)	Submerchant has never entered into a payment processing agreement with a third party that has been terminated by that third party.</p>
		<p style="text-align: justify;"><b>10.2.	Submerchant warrants during the term of this Agreement the following:</b></p>
		<p style="text-align: justify;">(a)	Submerchant is duly organized, authorized, and in good standing under the laws of the state, region, or country of its organization and is duly authorized to do business in all other states, regions, or countries in which Submerchant operates; and</p>
		<p style="text-align: justify;">(b)	Submerchant has not been placed in the Mastercard MATCH system, the Combined Terminated Merchant File, or any similar Card Brand system for tracking high risk merchants</p>

		<h4>11. INDEMNIFICATION AND LIMITATION OF LIABILITY</h4>
		<p style="text-align: justify;"><b>11.1.	Submerchant agrees to indemnify, defend, and hold SaleQuick and its directors, officers, employees, affiliates, and agents harmless from and against any and all proceedings, losses, costs, expenses, claims, demands, damages, and liabilities (including attorneys’ fees and costs, and collections costs) resulting from or otherwise arising out of (i) Submerchant’s use of the Payment Services, (ii) acts or omissions of Submerchant’s directors, officers, employees, affiliates, and agents in connection with the Payment Services, (iii) any infiltration, hack, breach, or access violation of the processing system resulting from or in any way related to Submerchant’s access to the Payment Services, (iv) Submerchant’s breach of this Agreement, and (v) Submerchant’s violation of the Rules or Law. This indemnification will survive the termination of this Agreement.</b></p>
		<p style="text-align: justify;"><b>11.2.	Submerchant agrees to provide SaleQuick with written notice of any alleged breach by SaleQuick of this Agreement, which notice will specifically detail such alleged breach, within thirty (30) days of the date on which the alleged breach first occurred. Failure to so provide notice will be deemed an acceptance by Submerchant and a waiver of any and all rights to dispute such breach.</b></p>
		<p style="text-align: justify;"><b>11.3.	SaleQuick’s cumulative liability to Submerchant is limited to direct damages and in all events will not exceed in the aggregate the amount of fees or compensation actually received by SaleQuick for the Transactions processed through the Payment Services during the six (6) month period immediately preceding the event that gives rise to the claim for liability.</b></p>
		<p style="text-align: justify;"><b>11.4.	The limitation of liability in Section 11.3 will not apply to claims against SaleQuick for failure to remit Transaction Funds in accordance with Section 6.2, in which case SaleQuick’s liability for such direct claim by Submerchant is limited to the amount of any Transaction Funds that SaleQuick failed to transfer to Submerchant, subject to Section 6.2(d).</b></p>

		<h4>12. DISPUTE RESOLUTION</h4>
		<p style="text-align: justify;"><b>12.1.	Arbitration. In the event SaleQuick and Submerchant are unable to resolve any dispute between them arising out of or concerning this Agreement or the Payment Services, whether in contract, tort, or otherwise at law or in equity for damages or any other relief, then such dispute will be resolved exclusively through final and binding arbitration pursuant to the Federal Arbitration Act, conducted by a single neutral arbitrator and administered under the Commercial Arbitration Rules of the American Arbitration Association. The exclusive site of such arbitration is Montgomery County, Texas. The arbitrator’s award is final, and judgment may be entered upon it in any court having jurisdiction. The prevailing party will be entitled to recover its costs and reasonable attorneys’ fees. The entire dispute, including the scope and enforceability of this arbitration provision, will be determined by the arbitrator. This arbitration provision will survive any termination of this Agreement. Notwithstanding the foregoing, SaleQuick may bring a claim for injunctive relief against Submerchant for any violation of this Agreement in any court of competent jurisdiction.</b></p>
		<p style="text-align: justify;"><b>12.2.	Choice of law, jurisdiction, and venue. The laws of the State of Texas govern this Agreement in all respects. For any dispute under this Agreement that is determined to be outside the scope of the arbitration provision, the state courts of Texas located in Montgomery County, Texas, and the United States Court for the Southern District of Texas located in Houston, Texas, will have exclusive jurisdiction and will be the exclusive venue.</b></p>
		<p style="text-align: justify;"><b>12.3.	No Class Action. To the fullest extent permitted by Law, Submerchant waives any and all rights to any class action litigation or proceeding with respect to any dispute arising under or in connection with this Agreement.</b></p>
		<p style="text-align: justify;"><b>12.4.	Severability and Waiver. If any term or provision of this Agreement or any application thereof is determined to be invalid or unenforceable, the remainder of this Agreement and any other application of such term or provision will remain in full effect. A delay or failure to enforce any provision or exercise any right under this Agreement by a SaleQuick or Submerchant will not be construed as a waiver or estoppel of such provision or right and will not affect or curtail such party’s ability to enforce such provision or exercise such right in the future. All waivers must be in writing and signed by the waiving party.</b></p>

		<h4>13. GENERAL PROVISIONS</h4>
		<p style="text-align: justify;"><b>13.1.	Interpretation.</b></p>
		<p style="text-align: justify;">(a)	The words “herein,” “hereof,” “hereunder,” and other words of similar import refer to the Agreement as a whole and not to any particular section or other subdivision.</p>
		<p style="text-align: justify;">(b)	All variations of the word “include” will be deemed to be followed by the words “without limitation,” unless otherwise specified.</p>
		<p style="text-align: justify;">(c)	The various headings contained herein are for reference purpose only and do not limit or otherwise affect any of the provisions hereof.</p>
		<p style="text-align: justify;">(d)	It is the intention of the parties to this Agreement that no provision be construed more strictly with regard to one party than with regard to the other.</p>
		<p style="text-align: justify;"><b>13.2.	Required and Other Amendments. SaleQuick may at any time amend this Agreement, including any Fee Schedule, upon notice to Submerchant, provided (i) such amendment is required or caused by a change in the Rules or Law, and (ii) such amendment modifies this Agreement only to the extent necessary to comply with such change in the Rules or Law. SaleQuick will use reasonable best efforts to provide such notice at least thirty (30) days prior to implementation of such required amendment. Other amendments will be made only as agreed in writing by the parties to this Agreement.</b></p>
		<p style="text-align: justify;"><b>13.3.	Survival. Any right, obligation, or provision under this Agreement that, by its description or nature, should survive termination of this Agreement, will survive the termination of this Agreement, including the terms set forth in Sections 5.2, 5.3, 6.1, 6.2, 7.3, 9.5, 11.1, 11.3, and 12.</b></p>
		<p style="text-align: justify;"><b>13.4.	Electronic Signature, Delivery, and Notices.</b></p>
		<p style="text-align: justify;">(a)	Submerchant agrees that for all purposes under this Agreement, electronic consent has the same legal effect as a physical signature.</p>
		<p style="text-align: justify;">(b)	Submerchant consents to electronic delivery of documents and notices under and related to the Payment Services, including by email or through the SaleQuick Merchant Account. Submerchant agrees that such electronic delivery satisfies any requirement that a document or notice be in writing.</p>
		<p style="text-align: justify;">(c)	Submerchant agrees to provide and keep current the information that SaleQuick needs to communicate with Submerchant electronically, including the email address on file in Submerchant’s SaleQuick Merchant Account. Submerchant agrees that if any notice sent to Submerchant is not received because Submerchant’s contact information on file with SaleQuick is incorrect or out of date, Submerchant will be deemed to have received the notice.</p>
		<p style="text-align: justify;">(d)	Except as otherwise provided herein, all notices under this Agreement will be in writing and will be delivered by hand, nationally recognized courier (signature required), registered or certified mail (return receipt requested), or email to the receiving party’s address listed below. Notice will be deemed given when delivered by hand to an officer of the party to whom the notice is addressed, on the date of actual receipt when delivered by courier or mail, or within twenty-four (24) of transmittal when delivered by email. </p>
		<p style="text-align: justify;">(e)	SaleQuick Address for Notices.</p>
		<address>Milstead Technologies, LLC <br>2416 North Frazier St. <br>Conroe, Texas 77303 </address>
		<p style="text-align: justify;"><b>13.5.	Force Majeure. SaleQuick will not be deemed to be in breach of its obligations under this Agreement or liable for any delay, loss, failure, or interruption of performance under this Agreement to the extent resulting from a Force Majeure Event. Upon such an occurrence, performance by SaleQuick will be excused until the cause Force Majeure Event has been removed or resolved and SaleQuick has had a reasonable time to recover and again provide the Payment Services.</b></p>
		<p style="text-align: justify;"><b>13.6.	Taxes. To the extent Submerchant is not exempt, SaleQuick, Processor, and Member Bank are required to report to the IRS Submerchant’s annual gross processing volume. SaleQuick or Processor will provide a form 1099-K, as required by Law. SaleQuick or Processor may, on behalf of the IRS, collect from Submerchant federal backup withholding upon Transaction settlement if Submerchant does not supply its legal name or tax identification number or if it fails to respond to a request from SaleQuick to verify the same.</b></p>
		<p style="text-align: justify;"><b>13.7.	Independent Contractor. Each SaleQuick and Submerchant is an independent contractor in the performance of its obligations under this Agreement, and neither is an employee or agent of the other party.</b></p>

		<h4>14. MEMBER BANK DISCLOSURES</h4>
		<p style="text-align: justify;"><b>14.1.	Member Bank Contact Information. Fifth Third Bank, N.A. • 38 Fountain Square Plaza • Cincinnati, Ohio 45263 • 513.579.5203.</b></p>
		<p style="text-align: justify;"><b>14.2.	SaleQuick is an agent of Member Bank for the limited purpose of exercising Member Bank’s authority under the Rules to enter in agreements with merchants.</b></p>
		<p style="text-align: justify;"><b>14.3.	Merchant Resources. As of the commencement of this Agreement, Rules may be downloaded at:</b></p>
		<p style="text-align: justify;">(a)	Mastercard: http://www.mastercard.com/us/merchant/support/rules.html.</p>
		<p style="text-align: justify;">(b)	Visa: http://usa.visa.com/merchants/operations/op_regulations.html.</p>

		<h4>15. STANDARD FEE SCHEDULE</h4>
		<table style="width:90%;border-collapse: collapse;margin:auto;">
		    <tbody>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">Processing Fees</th>
		            <th style="text-align: left;border: 1px solid #000;"></th>
		        </tr>
		        <tr>
		            <td style="border: 1px solid #000;">Card Present</td>
		            <td style="border: 1px solid #000;">2.65%</td>
		        </tr>
		        <tr>
		            <td style="border: 1px solid #000;">Card Not Present</td>
		            <td style="border: 1px solid #000;">2.90%</td>
		        </tr>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">Authorization Fee</th>
		            <th style="text-align: left;border: 1px solid #000;"></th>
		        </tr>
		        <tr>
		            <td style="border: 1px solid #000;">Card Present</td>
		            <td style="border: 1px solid #000;">$0.10</td>
		        </tr>
		        <tr>
		            <td style="border: 1px solid #000;">Card Not Present</td>
		            <td style="border: 1px solid #000;">$0.30</td>
		        </tr>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">Chargeback Fee (per incident)</th>
		            <td style="border: 1px solid #000;">$25.00</td>
		        </tr>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">Annual Maintenance Fee</th>
		            <td style="border: 1px solid #000;">$100.00</td>
		        </tr>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">PCI Non-Compliance (per month)</th>
		            <td style="border: 1px solid #000;">$25.00</td>
		        </tr>
		        <tr>
		            <th style="text-align: left;border: 1px solid #000;">Gateway Access (per month)</th>
		            <td style="border: 1px solid #000;">$15.00</td>
		        </tr>
		    </tbody>
		</table>

		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>

		<h1 style="text-align: center;">PRIVACY POLICY</h1>
		<p style="text-align:justify;">Protecting your private information is our priority. This Statement of Privacy applies to <a href="https://salequick.com/">salequick.com</a> and Milstead Technologies, LLC and governs data collection and usage. For the purposes of this Privacy Policy, unless otherwise noted, all references to Milstead Technologies, LLC include <a href="https://salequick.com/">salequick.com</a> and SaleQuick. The Milstead Technologies, LLC website is a Payment Technology site. By using the Milstead Technologies, LLC website, you consent to the data practices described in this statement. </p>

		<h4 style="text-transform: uppercase;">Collection of your Personal Information</h4>
		<p style="text-align:justify;">In order to better provide you with products and services offered on our Site, Milstead Technologies, LLC may collect personally identifiable information, such as your: </p>
		<ul>
		    <li>First and Last Name </li>
		    <li>Mailing Address </li>
		    <li>E-mail Address </li>
		    <li>Phone Number </li>
		    <li>Employer </li>
		    <li>Job Title </li>
		</ul>
		<p style="text-align:justify;">If you purchase Milstead Technologies, LLC’s products and services, we collect billing and credit card information. This information is used to complete the purchase transaction. </p>
		<p style="text-align:justify;">Milstead Technologies, LLC may also collect anonymous demographic information, which is not unique to you, such as your: </p>
		<ul>
		    <li>Age </li>
		    <li>Gender </li>
		    <li>Household Income </li>
		</ul>
		<p style="text-align:justify;">
		    We do not collect any personal information about you unless you voluntarily provide it to us. However, you may be required to provide certain personal information to us when you elect to use certain products or services available on the Site. 
		</p>
		<p style="text-align:justify;">These may include:</p>
		<ul>
		    <li>Registering for an account on our Site</li>
		    <li>Entering a sweepstakes or contest sponsored by us or one of our partners</li>
		    <li>Signing up for special offers from selected third parties </li>
		    <li>Sending us an email message</li>
		    <li>Submitting your credit card or other payment information when ordering and purchasing products and services on our Site. To wit, we will use your information for, but not limited to, communicating with you in relation to services and/or products you have requested from us. We also may gather additional personal or non-personal information in the future</li>
		</ul>

		<h4 style="text-transform: uppercase;">Use of your Personal Information</h4>
		<p style="text-align:justify;">Milstead Technologies, LLC collects and uses your personal information to operate its website(s) and deliver the services you have requested. </p>
		<p style="text-align:justify;">Milstead Technologies, LLC may also use your personally identifiable information to inform you of other products or services available from Milstead Technologies, LLC and its affiliates. </p>

		<h4 style="text-transform: uppercase;">Sharing Information with Third Parties</h4>
		<p style="text-align:justify;">Milstead Technologies, LLC does not sell, rent or lease its customer lists to third parties.  </p>
		<p style="text-align:justify;">Milstead Technologies, LLC may share data with trusted partners to help perform statistical analysis, send you email or postal mail, provide customer support, or arrange for deliveries. All such third parties are prohibited from using your personal information except to provide these services to Milstead Technologies, LLC, and they are required to maintain the confidentiality of your information. </p>
		<p style="text-align:justify;">Milstead Technologies, LLC may disclose your personal information, without notice, if required to do so by law or in the good faith belief that such action is necessary to: 
		</p>
		<ul>
		    <li>Conform to the edicts of the law or comply with legal process served on Milstead Technologies, LLC or the site</li>
		    <li>Protect and defend the rights or property of Milstead Technologies, LLC; and/or</li>
		    <li>Act under exigent circumstances to protect the personal safety of users of Milstead Technologies, LLC, or the public.</li>
		</ul>

		<h4 style="text-transform: uppercase;">Automatically Collected Information</h4>
		<p style="text-align:justify;">Information about your computer hardware and software may be automatically collected by Milstead Technologies, LLC. This information can include: your IP address, browser type, domain names, access times and referring website addresses. This information is used for the operation of the service, to maintain quality of the service, and to provide general statistics regarding use of the Milstead Technologies, LLC website. </p>

		<h4 style="text-transform: uppercase;">Use of Cookies</h4>
		<p style="text-align:justify;">The Milstead Technologies, LLC website may use "cookies" to help you personalize your online experience. A cookie is a text file that is placed on your hard disk by a web page server. Cookies cannot be used to run programs or deliver viruses to your computer. Cookies are uniquely assigned to you, and can only be read by a web server in the domain that issued the cookie to you. </p>
		<p style="text-align:justify;">One of the primary purposes of cookies is to provide a convenience feature to save you time. The purpose of a cookie is to tell the Web server that you have returned to a specific page. For example, if you personalize Milstead Technologies, LLC pages, or register with Milstead Technologies, LLC site or services, a cookie helps Milstead Technologies, LLC to recall your specific information on subsequent visits. This simplifies the process of recording your personal information, such as billing addresses, shipping addresses, and so on. When you return to the same Milstead Technologies, LLC website, the information you previously provided can be retrieved, so you can easily use the Milstead Technologies, LLC features that you customized. </p>
		<p style="text-align:justify;">You have the ability to accept or decline cookies. Most Web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. If you choose to decline cookies, you may not be able to fully experience the interactive features of the Milstead Technologies, LLC services or websites you visit. </p>

		<h4 style="text-transform: uppercase;">Security of your Personal Information</h4>
		<p style="text-align:justify;">Milstead Technologies, LLC secures your personal information from unauthorized access, use, or disclosure. Milstead Technologies, LLC uses the following methods for this purpose: </p>
		<ul>
		    <li>SSL Protocol </li>
		</ul>
		<p style="text-align:justify;">When personal information (such as a credit card number) is transmitted to other websites, it is protected through the use of encryption, such as the Secure Sockets Layer (SSL) protocol. </p>
		<p style="text-align:justify;">We strive to take appropriate security measures to protect against unauthorized access to or alteration of your personal information. Unfortunately, no data transmission over the Internet or any wireless network can be guaranteed to be 100% secure. As a result, while we strive to protect your personal information, you acknowledge that: 
		</p>
		<ul>
		    <li>There are security and privacy limitations inherent to the Internet which are beyond our control</li>
		    <li>Security, integrity, and privacy of any and all information and data exchanged between you and us through this Site cannot be guaranteed</li>
		</ul>

		<h4 style="text-transform: uppercase;">Children Under Thirteen</h4>
		<p style="text-align:justify;">Milstead Technologies, LLC does not knowingly collect personally identifiable information from children under the age of thirteen. If you are under the age of thirteen, you must ask your parent or guardian for permission to use this website. </p>

		<h4 style="text-transform: uppercase;">E-Mail Communications</h4>
		<p style="text-align:justify;">From time to time, Milstead Technologies, LLC may contact you via email for the purpose of providing announcements, promotional offers, alerts, confirmations, surveys, and/or other general communication. </p>

		<h4 style="text-transform: uppercase;">External Data Storage Sites</h4>
		<p style="text-align:justify;">We may store your data on servers provided by third party hosting vendors with whom we have contracted. </p>

		<h4 style="text-transform: uppercase;">Changes to this Statement</h4>
		<p style="text-align:justify;">Milstead Technologies, LLC reserves the right to change this Privacy Policy from time to time. We will notify you about significant changes in the way we treat personal information by sending a notice to the primary email address specified in your account, by placing a prominent notice on our site, and/or by updating any privacy information on this page. Your continued use of the Site and/or Services available through this Site after such modifications will constitute your: </p>
		<ul>
		    <li>Acknowledgment of the modified Privacy Policy</li>
		    <li>Agreement to abide and be bound by that Policy</li>
		</ul>

		<p></p>
		<p></p>
		<p></p>
		<p></p>
		<p></p>
		<p></p>
		<p></p>
		<p></p>
		<div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>

		<h1 style="text-align: center;">TERMS AND CONDITIONS</h1>
		<p style="text-align: justify;">Welcome to <a href="https://salequick.com/">salequick.com</a>. The <a href="https://salequick.com/">salequick.com</a> website (the "Site") is comprised of various web pages operated by Milstead Technologies, LLC. <a href="https://salequick.com/">salequick.com</a> is offered to you conditioned on your acceptance without modification of the terms, conditions, and notices contained herein (the "Terms"). Your use of <a href="https://salequick.com/">salequick.com</a> constitutes your agreement to all such Terms. Please read these terms carefully, and keep a copy of them for your reference. </p>
		<p style="text-align: justify;"><a href="https://salequick.com/">SaleQuick.com</a> is a Payment Technology Site.</p>
		<p style="text-align: justify;">Payment Processing Software </p>

		<h4 style="text-transform: uppercase;">Refund Policy</h4>
		<p style="text-align: justify;">Neither SaleQuick (Milstead Technologies, LLC) nor the merchant will provide refunds after the product or services are completed. This was acknowledged by the consumer prior to purchasing any product or service from the merchant. Please make sure that you carefully understand all charges the merchant is charging. Please understand each merchant has different warranty information about their products and services.</p>
		<p style="text-align: justify;">If there are any questions please contact the merchant.   </p>

		<h4 style="text-transform: uppercase;">Privacy</h4>
		<p style="text-align: justify;">Your use of <a href="https://salequick.com/">salequick.com</a> is subject to Milstead Technologies, LLC’s Privacy Policy. Please review our Privacy Policy, which also governs the Site and informs users of our data collection practices</p>

		<h4 style="text-transform: uppercase;">Electronic Communication</h4>
		<p style="text-align: justify;">Visiting <a href="https://salequick.com/">salequick.com</a> or sending emails to Milstead Technologies, LLC constitutes electronic communications. You consent to receive electronic communications and you agree that all agreements, notices, disclosures and other communications that we (Milstead Technologies, LLC) provide to you electronically, via email and on the Site, satisfy any legal requirement that such communications be in writing. </p>

		<h4 style="text-transform: uppercase;">Your Account</h4>
		<p style="text-align: justify;">If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. You may not assign or otherwise transfer your account to any other person or entity. You acknowledge that Milstead Technologies, LLC is not responsible for a third party access to your account that results from theft or misappropriation of your account. Milstead Technologies, LLC and its associates reserve the right to refuse or cancel service, terminate accounts, or remove or edit content in our sole discretion. </p>

		<h4 style="text-transform: uppercase;">Children Under Thirteen</h4>
		<p style="text-align: justify;">Milstead Technologies, LLC does not knowingly collect, either online or offline, personal information from persons under the age of thirteen. If you are under 18, you may use <a href="https://salequick.com/">salequick.com</a> only with permission of a parent or guardian.
		</p>

		<h4 style="text-transform: uppercase;">Links to Third Party Sites/Third Party Services</h4>
		<p style="text-align: justify;"><a href="https://salequick.com/">salequick.com</a> may contain links to other websites ("Linked Sites"). The Linked Sites are not under the control of Milstead Technologies, LLC and Milstead Technologies, LLC is not responsible for the contents of any Linked Site, including without limitation any link contained in a Linked Site, or any changes or updates to a Linked Site. Milstead Technologies, LLC is providing these links to you only as a convenience, and the inclusion of any link does not imply endorsement by Milstead Technologies, LLC of the site or any association with its operators. </p>
		<p style="text-align: justify;">Certain services made available via <a href="https://salequick.com/">salequick.com</a> are delivered by third party sites and organizations. By using any product, service or functionality originating from the <a href="https://salequick.com/">salequick.com</a> domain, you hereby acknowledge and consent that Milstead Technologies, LLC may share such information and data with any third party with whom Milstead Technologies, LLC has a contractual relationship to provide the requested product, service or functionality on behalf of <a href="https://salequick.com/">salequick.com</a> users and customers. </p>

		<h4 style="text-transform: uppercase;">No Unlawful or Prohibited Use/Intellectual Property</h4>
		<p style="text-align: justify;">You are granted a non-exclusive, non-transferable, revocable license to access and use <a href="https://salequick.com/">salequick.com</a> strictly in accordance with these terms of use. As a condition of your use of the Site, you warrant to Milstead Technologies, LLC that you will not use the Site for any purpose that is unlawful or prohibited by these Terms. You may not use the Site in any manner which could damage, disable, overburden, or impair the Site or interfere with any other party’s use and enjoyment of the Site. You may not obtain or attempt to obtain any materials or information through any means not intentionally made available or provided for through the Site. </p>
		<p style="text-align: justify;">All content included as part of the Service, such as text, graphics, logos, images, as well as the compilation thereof, and any software used on the Site, is the property of Milstead Technologies, LLC or its suppliers and protected by copyright and other laws that protect intellectual property and proprietary rights. You agree to observe and abide by all copyright and other proprietary notices, legends or other restrictions contained in any such content and will not make any changes thereto.</p>
		<p style="text-align: justify;">You will not modify, publish, transmit, reverse engineer, participate in the transfer or sale, create derivative works, or in any way exploit any of the content, in whole or in part, found on the Site. Milstead Technologies, LLC content is not for resale. Your use of the Site does not entitle you to make any unauthorized use of any protected content, and in particular, you will not delete or alter any proprietary rights or attribution notices in any content. You will use protected content solely for your personal use, and will make no other use of the content without the express written permission of Milstead Technologies, LLC and the copyright owner. You agree that you do not acquire any ownership rights in any protected content. We do not grant you any licenses, express or implied, to the intellectual property of Milstead Technologies, LLC or our licensors except as expressly authorized by these Terms. </p>

		<h4 style="text-transform: uppercase;">International Users</h4>
		<p style="text-align: justify;">The Service is controlled, operated and administered by Milstead Technologies, LLC from our offices within the USA. If you access the Service from a location outside the USA, you are responsible for compliance with all local laws. You agree that you will not use the Milstead Technologies, LLC Content accessed through <a href="https://salequick.com/">salequick.com</a> in any country or in any manner prohibited by any applicable laws, restrictions or regulations. </p>

		<h4 style="text-transform: uppercase;">Indemnification</h4>
		<p style="text-align: justify;">You agree to indemnify, defend and hold harmless Milstead Technologies, LLC, its officers, directors, employees, agents and third parties, for any losses, costs, liabilities and expenses (including reasonable attorney’s fees) relating to or arising out of your use of or inability to use the Site or services, any user postings made by you, your violation of any terms of this Agreement or your violation of any rights of a third party, or your violation of any applicable laws, rules or regulations. Milstead Technologies, LLC reserves the right, at its own cost, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which event you will fully cooperate with Milstead Technologies, LLC in asserting any available defenses. </p>

		<h4 style="text-transform: uppercase;">Arbitration</h4>
		<p style="text-align: justify;">In the event the parties are not able to resolve any dispute between them arising out of or concerning these Terms and Conditions, or any provisions hereof, whether in contract, tort, or otherwise at law or in equity for damages or any other relief, then such dispute shall be resolved only by final and binding arbitration pursuant to the Federal Arbitration Act, conducted by a single neutral arbitrator and administered by the American Arbitration Association, or a similar arbitration service selected by the parties, in a location mutually agreed upon by the parties. The arbitrator’s award shall be final, and judgment may be entered upon it in any court having jurisdiction. In the event that any legal or equitable action, proceeding or arbitration arises out of or concerns these Terms and Conditions, the prevailing party shall be entitled to recover its costs and reasonable attorney’s fees. The parties agree to arbitrate all disputes and claims in regards to these Terms and Conditions or any disputes arising as a result of these Terms and Conditions, whether directly or indirectly, including Tort claims that are a result of these Terms and Conditions. The parties agree that the Federal Arbitration Act governs the interpretation and enforcement of this provision. The entire dispute, including the scope and enforceability of this arbitration provision shall be determined by the Arbitrator. This arbitration provision shall survive the termination of these Terms and Conditions.</p>

		<h4 style="text-transform: uppercase;">Liability Disclaimer</h4>
		<p style="text-align: justify;"><b>The information, software, products, and services included in or available through the site may include inaccuracies or typographical errors. changes are periodically added to the information herein. Milstead Technologies, LLC and/or its suppliers may make improvements and/or changes in the site at any time.</b></p>
		<p style="text-align: justify;"><b>Milstead Technologies, LLC and/or its suppliers make no representations about the suitability, reliability, availability, timeliness, and accuracy of the information, software, products, services and related graphics contained on the site for any purpose. To the maximum extent permitted by applicable law, all such information, software, products, services and related graphics are provided "as is" without warranty or condition of any kind. Milstead Technologies, LLC and/or its suppliers hereby disclaim all warranties and conditions with regard to this information, software, products, services and related graphics, including all implied warranties or conditions of merchantability, fitness for a particular purpose, title and non-infringement.</b></p>
		<p style="text-align: justify;"><b>To the maximum extent permitted by applicable law, in no event shall Milstead Technologies, LLC and/or its suppliers be liable for any direct, indirect, punitive, incidental, special, consequential damages or any damages whatsoever including, without limitation, damages for loss of use, data or profits, arising out of or in any way connected with the use or performance of the site, with the delay or inability to use the site or related services, the provision of or failure to provide services, or for any information, software, products, services and related graphics obtained through the site, or otherwise arising out of the use of the site, whether based on contract, tort, negligence, strict liability or otherwise, even if Milstead Technologies, LLC or any of its suppliers has been advised of the possibility of damages. Because some states/jurisdictions do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation maynot apply to you. If you are dissatisfied with any portion of the site, or with any of these terms of use, your sole and exclusive remedy is to discontinue using the site.</b></p>

		<h4 style="text-transform: uppercase;">Termination/Access Restriction</h4>
		<p style="text-align: justify;">Milstead Technologies, LLC reserves the right, in its sole discretion, to terminate your access to the Site and the related services or any portion thereof at any time, without notice. To the maximum extent permitted by law, this agreement is governed by the laws of the State of Texas and you hereby consent to the exclusive jurisdiction and venue of courts in Texas in all disputes arising out of or relating to the use of the Site. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these Terms, including, without limitation, this section. </p>
		<p style="text-align: justify;">You agree that no joint venture, partnership, employment, or agency relationship exists between you and Milstead Technologies, LLC as a result of this agreement or use of the Site. Milstead Technologies, LLC’s performance of this agreement is subject to existing laws and legal process, and nothing contained in this agreement is in derogation of Milstead Technologies, LLC’s right to comply with governmental, court and law enforcement requests or requirements relating to your use of the Site or information provided to or gathered by Milstead Technologies, LLC with respect to such use. If any part of this agreement is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision will be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of the agreement shall continue in effect. </p>
		<p style="text-align: justify;">Unless otherwise specified herein, this agreement constitutes the entire agreement between the user and Milstead Technologies, LLC with respect to the Site and it supersedes all prior or contemporaneous communications and proposals, whether electronic, oral or written, between the user and Milstead Technologies, LLC with respect to the Site. A printed version of this agreement and of any notice given in electronic form shall be admissible in judicial or administrative proceedings based upon or relating to this agreement to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form. It is the express wish to the parties that this agreement and all related documents be written in English. </p>

		<h4 style="text-transform: uppercase;">Change to Terms</span></h4>
		<p style="text-align: justify;">Milstead Technologies, LLC reserves the right, in its sole discretion, to change the Terms under which <a href="https://salequick.com/">salequick.com</a> is offered. The most current version of the Terms will supersede all previous versions. Milstead Technologies, LLC encourages you to periodically review the Terms to stay informed of our updates. </p>

		<h4 style="text-transform: uppercase;">Contact Us</span></h4>
		<p style="text-align: justify;">Milstead Technologies, LLC welcomes your questions or comments regarding the Terms: </p>
		<address>Milstead Technologies, LLC <br>2416 North Frazier St. <br>Conroe, Texas 77303 </address>
		<p ><b>Email Address: </b> support@salequick.com </p>
		<p ><b>Telephone number: </b> 8778753111 </p>
		<p ><b>Effective as of </b> November 26, 2018 </p>

		<div style="margin-bottom:100px;">
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>
		<div style="margin-bottom:100px;">
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>

		<h1 style="text-transform: uppercase;">Merchant Agreement Details ('.$merchant->business_dba_name.')</h1>
		<table cellpadding="2" style="width: 100%;">
			<tr>
				<th bgcolor="#cccccc" style="border:1px solid #000;width: 40%;font-weight: 600;text-align: left;">Merchant Email</th>
				<td style="border:1px solid #000;width: 60%;text-align: left;">'.$merchant->email.'</td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" style="border:1px solid #000;width: 40%;font-weight: 600;text-align: left;">IP Address</th>
				<td style="border:1px solid #000;width: 60%;text-align: left;">'.$agreement_mail->ip_address.'</td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" style="border:1px solid #000;width: 40%;font-weight: 600;text-align: left;">Browser</th>
				<td style="border:1px solid #000;width: 60%;text-align: left;">'.$agreement_mail->browser.'</td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" style="border:1px solid #000;width: 40%;font-weight: 600;text-align: left;">Lat/Long</th>
				<td style="border:1px solid #000;width: 60%;text-align: left;">'.$agreement_mail->latitude.'/'.$agreement_mail->longitude.'</td>
			</tr>
			<tr>
				<th bgcolor="#cccccc" style="border:1px solid #000;width: 40%;font-weight: 600;text-align: left;">Signed/Agreed At</th>
				<td style="border:1px solid #000;width: 60%;text-align: left;">'.$agreement_mail->agreement_accepted_at.'</td>
			</tr>
		</table>';

		ob_end_clean();
		$obj_pdf->writeHTML($pdf_html, true, false, true, false, '');
		// $obj_pdf->writeHTML($html_Check, true, false, true, false, '');
		// $obj_pdf->writeHTML($html_Online, true, false, true, false, '');
		// $obj_pdf->writeHTML($html_Card, true, false, true, false, '');
		// $obj_pdf->writeHTML($html_Split, true, false, true, false, '');
		// $obj_pdf->writeHTML($html_Refund, true, false, true, false, '');
		// $obj_pdf->setDestination('Transaction Report', 0, '');
		// $obj_pdf->Bookmark('Transaction Report', 0, 0, '', 'BI', array(128,0,0), -1, '#Transaction Report');
		// $obj_pdf->Cell(0, 10, 'Transaction Report', 0, 1, 'L');
		$obj_pdf->Output();
	}

}