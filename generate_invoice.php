<?php
require_once('tcpdf/tcpdf.php');
@include 'config.php';

if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];

    // Fetch order details from the database
    $select_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id'") or die('query failed');
    $fetch_order = mysqli_fetch_assoc($select_order);

    // Fetch order items from the database
    $select_order_items = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id'") or die('query failed');

    // Create a new PDF instance
    $pdf = new TCPDF(); 

    
       
    // Set document properties
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Invoice');
    $pdf->SetSubject('Invoice');
    $pdf->SetKeywords('Invoice, TCPDF, PHP');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Set styles for header and footer
    $pdf->SetHeaderData('', 0, 'The Siya Fashion - Invoice'); // Fixed the syntax error
    $pdf->setHeaderFont(array('helvetica', '', 12));
    $pdf->setFooterFont(array('helvetica', '', 10));

    // Set border for the entire page
    $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));
    $pdf->Rect(10, 10, 190, 277); // You can adjust these values as needed

    // Add content to the PDF with inline styles
    $html = '
        <style>
            h1, h3 {
                text-align: center;
                color: #333;
                margin-bottom: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #333;
                padding: 8px;
                text-align: left;
            }
            strong {
                color: #555;
            }
        </style>
        <h1>The Siya Fashion</h1>
        <h3>Invoice</h3>

        <p><strong>Order ID:</strong> ' . $fetch_order['id'] . '</p>
        <p><strong>Name:</strong> ' . $fetch_order['name'] . '</p>
        <p><strong>Email:</strong> ' . $fetch_order['email'] . '</p>
        <p><strong>Address:</strong> ' . $fetch_order['address'] . '</p>
        <!-- Add more details as needed -->

        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
            </tr>';

    // Loop through order items and add to the table
    while($order_item = mysqli_fetch_assoc($select_order_items)){
        $html .= '
            <tr>
                <td>' . $order_item['total_products'] . '</td>
                <td>Rs. ' . $order_item['total_price'] . '</td>
            </tr>';
    }

    $html .= '
        </table>

        <p><strong>Total Price:</strong> Rs. ' . $fetch_order['total_price'] . '</p>
    ';

    // Output the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Save or output the PDF
    $pdf->Output('invoice_' . $fetch_order['id'] . '.pdf', 'D');
}
?>
