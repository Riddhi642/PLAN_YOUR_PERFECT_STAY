<?php
session_start();
include('../include/db.php');
require_once('../vendor/autoload.php');

// Get booking ID
$booking_id = $_GET['booking_id'] ?? 0;
$booking_id = (int)$booking_id;

// Fetch booking data
$booking = $conn->query("
    SELECT b.*, p.title, p.price, u.name, u.email, u.phone
    FROM bookings b
    JOIN properties p ON b.property_id=p.id
    JOIN users u ON b.user_id=u.id
    WHERE b.id=$booking_id
")->fetch_assoc();

if (!$booking) die("Booking not found");

// Calculate days
$check_in = new DateTime($booking['check_in']);
$check_out = new DateTime($booking['check_out']);
$days = $check_out->diff($check_in)->days;
if ($days == 0) $days = 1;

$total = $booking['price'] * $days;

// Create PDF
$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

// Use Unicode font (₹ fix)
$pdf->SetFont('dejavusans','',11);

// ===== HEADER =====
$pdf->SetFillColor(63,81,181);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('dejavusans','B',16);
$pdf->Cell(0,15,'Plan Your Perfect Stay - Invoice',0,1,'C',1);

$pdf->Ln(5);

// Reset text color
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('dejavusans','',11);

// ===== CUSTOMER + PROPERTY SIDE BY SIDE =====
$html = "
<style>
table { border-collapse: collapse; }
td { padding:6px; border:1px solid #ddd; }
th { background-color:#f5f5f5; padding:6px; border:1px solid #ddd; text-align:left;}
</style>

<table width='100%'>
<tr>
    <td width='50%'>
        <h3 style='color:#3f51b5;'>Customer Details</h3>
        <table width='100%'>
            <tr><td width='40%'><b>Booking ID</b></td><td>{$booking['id']}</td></tr>
            <tr><td><b>Name</b></td><td>{$booking['name']}</td></tr>
            <tr><td><b>Email</b></td><td>{$booking['email']}</td></tr>
            <tr><td><b>Phone</b></td><td>{$booking['phone']}</td></tr>
        </table>
    </td>

    <td width='50%'>
        <h3 style='color:#3f51b5;'>Property Details</h3>
        <table width='100%'>
            <tr><td width='40%'><b>Property</b></td><td>{$booking['title']}</td></tr>
            <tr><td><b>Check-in</b></td><td>{$booking['check_in']}</td></tr>
            <tr><td><b>Check-out</b></td><td>{$booking['check_out']}</td></tr>
            <tr><td><b>Total Days</b></td><td>{$days}</td></tr>
        </table>
    </td>
</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(8);

// ===== BILL TABLE =====
$html = "
<table width='100%'>
<tr>
    <th>Days</th>
    <th>Price / Day</th>
    <th>Total</th>
</tr>
<tr>
    <td align='center'>{$days}</td>
    <td align='center'>₹ ".number_format($booking['price'],2)."</td>
    <td align='center'>₹ ".number_format($total,2)."</td>
</tr>
</table>
";

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(10);

// ===== GRAND TOTAL =====
$pdf->SetFont('dejavusans','B',13);
$pdf->Cell(0,10,"Grand Total: ₹ ".number_format($total,2),0,1,'R');

$pdf->Ln(8);

// ===== FOOTER =====
$pdf->SetFont('dejavusans','I',11);
$pdf->Cell(0,10,'Thank you for booking with us!',0,1,'C');

// Output PDF
$pdf->Output("Invoice_{$booking['id']}.pdf", 'I');
?>