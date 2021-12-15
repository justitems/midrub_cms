<?php

// Get invoice's data
$invoice = md_the_invoice_by_id($this->input->get('invoice', true));

// Verify if invoice exists
if ($invoice) {
    echo $invoice[0]['invoice_text'];
} else {
    show_404();
}