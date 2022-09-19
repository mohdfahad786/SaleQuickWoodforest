<?php

require_once 'connect.php';

$response = array();

$user = array();

$date_c = $_GET['start'];

$date_cc = $_GET['end'];

$merchnat = $_GET['merchant'];

$employee = $_GET['employee'];

if ($_GET['employee'] == 'all') {

	$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  (status='confirm' OR status='Chargeback_Confirm') ) as Amount , ( SELECT SUM(amount) as PAmount from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' )  ) as Tax , (SELECT SUM(tax) as PTax from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  status='confirm' ) as PFee ,  ( SELECT SUM(refund.amount) as RAmount from refund INNER JOIN pos  ON refund.invoice_no=pos.invoice_no  where  refund.date_c >= ? and refund.date_c <= ? and   pos.merchant_id= ? and  pos.status='Chargeback_Confirm' ) as RAmount ,  ( SELECT SUM(refund.amount) as CRAmount from refund INNER JOIN customer_payment_request  ON refund.invoice_no=customer_payment_request.invoice_no  where  refund.date_c >= ? and refund.date_c <= ? and   customer_payment_request.merchant_id= ? and  customer_payment_request.status='Chargeback_Confirm' ) as CRAmount, (select sum(CASE
   when r.amount is null OR r.amount='' then p.amount
   else  r.amount
   end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') AS CREFUND, (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') as POSREFUND,( SELECT SUM(tip_amount) as TipAmount from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? ) as TipAmount ,  ( SELECT SUM(tip_amount) as CTipAmount from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? ) as CTipAmount");

	$stmt->bind_param("ssssssssssssssssssssssssssssssssssss", $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat);

} elseif ($_GET['employee'] == 'merchent') {

	$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  (status='confirm' OR status='Chargeback_Confirm' )  ) as Amount , ( SELECT SUM(amount) as PAmount from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm') ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as Tax , (SELECT SUM(tax) as PTax from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' )  ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ? and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? and  status='confirm' ) as PFee ,  ( SELECT SUM(refund.amount) as RAmount from refund  INNER JOIN pos ON  refund.invoice_no=pos.invoice_no  where  refund.date_c >= ? and refund.date_c <= ? and   pos.merchant_id= ? and  pos.status='Chargeback_Confirm' ) as RAmount ,  ( SELECT SUM(refund.amount) as CRAmount from  refund INNER JOIN customer_payment_request ON refund.invoice_no=customer_payment_request.invoice_no  where  refund.date_c >= ? and refund.date_c <= ? and   customer_payment_request.merchant_id= ? and  customer_payment_request.status='Chargeback_Confirm' ) as CRAmount, (select sum(CASE
   when r.amount is null OR r.amount='' then p.amount
   else  r.amount
   end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') AS CREFUND, (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') as POSREFUND,( SELECT SUM(tip_amount) as TipAmount from pos where  date_c >= ? and date_c <= ? and   merchant_id= ? ) as TipAmount ,  ( SELECT SUM(tip_amount) as CTipAmount from customer_payment_request where  date_c >= ? and date_c <= ? and   merchant_id= ?  ) as CTipAmount");

	$stmt->bind_param("sssssssssssssssssssssssssssssssssss", $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat);

} else {

	$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where  date_c >= ? and date_c <= ? and   sub_merchant_id = ? and merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as Amount , ( SELECT SUM(amount) as PAmount from pos where  date_c >= ? and date_c <= ? and sub_merchant_id = ? and  merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as PAmount, (SELECT SUM(tax) as Tax from customer_payment_request where  date_c > ? and date_c <= ? and  sub_merchant_id = ? and  merchant_id= ? and  ( status='confirm' OR status='Chargeback_Confirm' ) ) as Tax , (SELECT SUM(tax) as PTax from pos where  date_c >= ? and date_c <= ? and sub_merchant_id = ? and  merchant_id= ? and ( status='confirm' OR status='Chargeback_Confirm' ) ) as PTax, (SELECT SUM(fee) as Fee from customer_payment_request where  date_c >= ? and date_c <= ? and sub_merchant_id = ? and   merchant_id= ? and  status='confirm' ) as Fee, (SELECT SUM(fee) as PFee from pos where  date_c >= ? and date_c <= ? and  sub_merchant_id = ? and  merchant_id= ? and  status='confirm' ) as PFee ,  ( SELECT SUM(refund.amount) as RAmount from refund  Inner join  pos  on refund.invoice_no=pos.invoice_no where  refund.date_c >= ? and refund.date_c <= ? and  pos.sub_merchant_id = ? and  pos.merchant_id= ? and  pos.status='Chargeback_Confirm' ) as RAmount ,  ( SELECT SUM(refund.amount) as CRAmount from refund  Inner Join  customer_payment_request  on refund.invoice_no=customer_payment_request.invoice_no where  refund.date_c >= ? and refund.date_c <= ? and  customer_payment_request.sub_merchant_id = ? and  customer_payment_request.merchant_id= ? and  customer_payment_request.status='Chargeback_Confirm' ) as CRAmount, (select sum(CASE
   when r.amount is null OR r.amount='' then p.amount
   else  r.amount
   end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') AS CREFUND, (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and p.merchant_id=?  and p.status='Chargeback_Confirm') as POSREFUND,( SELECT SUM(tip_amount) as TipAmount from pos where  date_c >= ? and date_c <= ? and  sub_merchant_id = ? and  merchant_id= ? ) as TipAmount ,  ( SELECT SUM(tip_amount) as CTipAmount from customer_payment_request where  date_c >= ? and date_c <= ? and  sub_merchant_id = ? and  merchant_id= ?  ) as TipAmount");

	$stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssss", $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $employee, $merchnat, $date_c, $date_cc, $employee, $merchnat);

}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

	$stmt->bind_result($Amount, $PAmount, $Tax, $PTax, $Fee, $PFee, $RAmount, $CRAmount, $CREFUND, $POSREFUND, $TipAmount, $CTipAmount);

	while ($stmt->fetch()) {

		$TotalTip = (float) ($TipAmount == Null ? 0.00 : $TipAmount) + (float) ($CTipAmount == Null ? 0.00 : $CTipAmount);
		$temp1 = array(

			'label' => 'Amount',

			'SaleAmount' => $Amount + $PAmount - ($Tax + $PTax) - ($TotalTip),

			'RefundAmount' => $CRAmount + $POSREFUND, //  Fee

			'NetAmount' => $Amount + $PAmount - ($Tax + $PTax) - ($CRAmount + $POSREFUND) - ($TotalTip), // ($Tax + $PTax),   // NET

			'PosTipAmount' => $TipAmount == Null ? '0.00' : $TipAmount,

			'TipAmount' => $CTipAmount == Null ? '0.00' : $CTipAmount,

			'TotalTip' => $TotalTip,
		);

		$temp2 = array('label' => 'Tax', 'SaleAmount' => $Tax + $PTax, 'RefundAmount' => '0.00', 'NetAmount' => $Tax + $PTax);

		$temp3 = array('label' => 'Fee', 'SaleAmount' => $Fee + $PFee, 'RefundAmount' => '0.00', 'NetAmount' => $Fee + $PFee);

		$temp4 = array('label' => 'Tip', 'SaleAmount' => $TotalTip, 'RefundAmount' => '0.00', 'NetAmount' => $TotalTip);

		array_push($user, $temp1, $temp2, $temp3, $temp4);

	}

} else {

	$user = array();

	$temp = array(

		'date' => $date_c,

		'SaleAmount' => "0",

		'RefundAmount' => "0",

		'cost' => "0",

		'conversions' => "0",

		'NetAmount' => "0",

		'revenue' => "0",

		'linkcost' => "0",

	);

	array_push($user, $temp);

}

$response = $user;

echo json_encode($response);

?>

