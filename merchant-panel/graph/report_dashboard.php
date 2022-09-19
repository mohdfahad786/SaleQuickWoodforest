
<?php

require_once 'connect.php';

$response = array();

$user = array();

$date_c = $_GET['start'];

$date_cc = $_GET['end'];

$merchnat = $_GET['merchant'];

$employee = $_GET['employee'];
if ($_GET['employee'] == 'all') {

	$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where   date_c >= ? and date_c <= ?    and  status='confirm' ) as Amount ,
( SELECT SUM(amount) as PAmount from pos where   date_c >= ? and date_c <= ?    and  status='confirm' ) as PAmount,
(SELECT SUM(tax) as Tax from customer_payment_request where   date_c >= ? and date_c <= ?    and  status='confirm' ) as Tax ,
(SELECT SUM(tax) as PTax from pos where   date_c >= ? and date_c <= ?    and  status='confirm' ) as PTax,
(SELECT SUM(tip_amount) as tip from customer_payment_request where   date_c >= ? and date_c <= ?   and  status='confirm' ) as Tip ,
(SELECT SUM(tip_amount) as PTip from pos where   date_c >= ? and date_c <= ?   and  status='confirm' ) as PTip,
(SELECT SUM(tip_amount) as RTip from customer_payment_request where   date_c >= ? and date_c <= ?   and  status='Chargeback_Confirm' ) as RTip,
(SELECT SUM(tip_amount) as RPTip from pos where   date_c >= ? and date_c <= ?   and  status='Chargeback_Confirm' ) as RPTip,
(SELECT SUM(fee) as Fee from customer_payment_request where   date_c >= ? and date_c <= ?    and  status='confirm' ) as Fee,
(SELECT SUM(fee) as PFee from pos where   date_c >= ? and date_c <= ?    and  status='confirm' ) as PFee ,
( select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and  p.status='Chargeback_Confirm' ) As RAmountPOS,
  (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and  p.status='Chargeback_Confirm' ) As RAmountCPR");

	$stmt->bind_param("ssssssssssssssssssssssss", $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc, $date_c, $date_cc);

} elseif ($_GET['employee'] == 'merchent') {

	$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where  date_c > ? and date_c < ?    and  status='confirm' ) as Amount ,
( SELECT SUM(amount) as PAmount from pos where  date_c > ? and date_c < ?    and  status='confirm' ) as PAmount,
(SELECT SUM(tax) as Tax from customer_payment_request where   date_c >= ? and date_c <= ?    and  status='confirm' ) as Tax ,
(SELECT SUM(tax) as PTax from pos where   date_c >= ? and date_c <= ?    and  status='confirm' ) as PTax,
(SELECT SUM(tip_amount) as tip from customer_payment_request where   date_c >= ? and date_c <= ?  and merchant_id= ?  and  status='confirm' ) as Tip ,
(SELECT SUM(tip_amount) as PTip from pos where   date_c >= ? and date_c <= ? and merchant_id= ?   and  status='confirm' ) as PTip,
(SELECT SUM(tip_amount) as RTip from customer_payment_request where   date_c >= ? and date_c <= ? and merchant_id= ?   and  status='Chargeback_Confirm' ) as RTip,
(SELECT SUM(tip_amount) as RPTip from pos where   date_c >= ? and date_c <= ?  and merchant_id= ?  and  status='Chargeback_Confirm' ) as RPTip,
(SELECT SUM(fee) as Fee from customer_payment_request where   date_c >= ? and date_c <= ?    and  status='confirm' ) as Fee,
(SELECT SUM(fee) as PFee from pos where   date_c >= ? and date_c <= ?   and  status='confirm' ) as PFee ,
(select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and  p.status='Chargeback_Confirm' and r.merchant_id= ?) As RAmountPOS,
  (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and  p.status='Chargeback_Confirm' and r.merchant_id= ?) As RAmountCPR");

// ( SELECT SUM(amount) as RAmount from refund where   date_c >= ? and date_c <= ?    and  status='confirm' ) as RAmount");

	$stmt->bind_param("sssssssssssssssssssssssssssssssssssss", $date_c, $date_cc, $employee, $date_c, $date_cc, $employee, $date_c, $date_cc, $employee, $date_c, $date_cc, $employee, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat, $date_c, $date_cc, $merchnat);
} else {

$stmt = $conn->prepare(" SELECT ( SELECT SUM(amount) as Amount from customer_payment_request where   date_c >= ? and date_c <= ? and merchant_id= ?   and  status='confirm' ) as Amount ,
( SELECT SUM(amount) as PAmount from pos where   date_c >= ? and date_c <= ?   and merchant_id= ? and  status='confirm' ) as PAmount,
(SELECT SUM(tax) as Tax from customer_payment_request where   date_c >= ? and date_c <= ?   and merchant_id= ?  and  status='confirm' ) as Tax ,
(SELECT SUM(tax) as PTax from pos where   date_c >= ? and date_c <= ?   and merchant_id= ?  and  status='confirm' ) as PTax,
(SELECT SUM(tip_amount) as tip from customer_payment_request where   date_c >= ? and date_c <= ? and merchant_id= ?  and  status='confirm' ) as Tip ,
(SELECT SUM(tip_amount) as PTip from pos where   date_c >= ? and date_c <= ?  and merchant_id= ? and  status='confirm' ) as PTip,
(SELECT SUM(tip_amount) as RTip from customer_payment_request where   date_c >= ? and date_c <= ?  and merchant_id= ? and  status='Chargeback_Confirm' ) as RTip,
(SELECT SUM(tip_amount) as RPTip from pos where   date_c >= ? and date_c <= ?  and merchant_id= ? and  status='Chargeback_Confirm' ) as RPTip,
(SELECT SUM(fee) as Fee from customer_payment_request where   date_c >= ? and date_c <= ?   and merchant_id= ?   and  status='confirm' ) as Fee,
(SELECT SUM(fee) as PFee from pos where   date_c >= ? and date_c <= ?    and merchant_id= ? and   status='confirm' ) as PFee ,
( select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from pos p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and r.merchant_id= ? and  p.status='Chargeback_Confirm' ) As RAmountPOS,
  (select sum(CASE
  when r.amount is null OR r.amount='' then p.amount
  else  r.amount
  end) as rAmu from customer_payment_request p join refund r on p.invoice_no=r.invoice_no where  r.date_c>=? and r.date_c <= ? and r.merchant_id= ? and  p.status='Chargeback_Confirm' ) As RAmountCPR");

	$stmt->bind_param("ssssssssssssssssssssssssssssssssssss", $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee, $date_c, $date_cc,$employee);
}

$stmt->execute();

$row = $stmt->store_result();

if ($stmt->num_rows > 0) {

	$stmt->bind_result($Amount, $PAmount, $Tax, $PTax, $Tip, $PTip, $RTip, $RPTip, $Fee, $PFee, $RAmountPOS, $RAmountCPR);

	while ($stmt->fetch()) {

		$temp1 = array(
			'label' => 'Amount',
			'people' => $Amount + $PAmount,
			'clicks' => ($RAmountPOS + $RAmountCPR),
			'converted_people' => ($Amount + $PAmount) - ($RAmountPOS + $RAmountCPR),

		);

		$temp2 = array(

			'label' => 'Tax',
			'people' => $Tax + $PTax,
			'clicks' => '0',
			'converted_people' => $Tax + $PTax,

		);

		$temp3 = array(

			'label' => 'Fee',
			'people' => $Fee + $PFee,
			'clicks' => '0',
			'converted_people' => $Fee + $PFee,

		);
		$temp4 = array(

			'label' => 'Tip',
			'people' => $Tip + $PTip,
			'clicks' => $RTip + $RPTip,
			'converted_people' => ($Tip + $PTip) - ($RTip + $RPTip),

		);
		array_push($user, $temp1, $temp2, $temp3, $temp4);
	}

} else {

	$user = array();

	$temp = array(
		'date' => $date_c,
		'people' => "0",
		'clicks' => "0",
		'cost' => "0",
		'conversions' => "0",
		'converted_people' => "0",
		'revenue' => "0",
		'linkcost' => "0",

	);
	array_push($user, $temp);

}

$response = $user;

echo json_encode($response);

?>

