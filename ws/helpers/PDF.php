<?php
require_once __DIR__ . '/FPDF.php';
require_once __DIR__ . '/../helpers/Utils.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Helvetica', 'B', 16);
        $this->Cell(0, 10, 'Loan Details', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function LoanDetails($data) {
        // Contract Section
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 10, 'Contract Information', 0, 1);
        $this->SetFont('Helvetica', '', 10);

        $this->Cell(50, 8, 'Loan ID:', 0, 0);
        $this->Cell(0, 8, $data['loan_id'], 0, 1);
        $this->Cell(50, 8, 'Contract ID:', 0, 0);
        $this->Cell(0, 8, $data['contract']['id'], 0, 1);
        $this->Cell(50, 8, 'UUID:', 0, 0);
        $this->Cell(0, 8, $data['contract']['uuid'], 0, 1);
        $this->Cell(50, 8, 'Repayment Type:', 0, 0);
        $this->Cell(0, 8, $data['contract']['repaymentType'], 0, 1);
        $this->Cell(50, 8, 'Revenue Rate:', 0, 0);
        $this->Cell(0, 8, $data['contract']['revenueRate'] . '%', 0, 1);
        $this->Cell(50, 8, 'Insurance Rate:', 0, 0);
        $this->Cell(0, 8, $data['contract']['insuranceRate'] . '%', 0, 1);
        $this->Cell(50, 8, 'Duration:', 0, 0);
        $this->Cell(0, 8, $data['contract']['duration'] . ' months', 0, 1);
        $this->Cell(50, 8, 'Loan Amount:', 0, 0);
        $this->Cell(0, 8, $data['contract']['amount'] . ' EUR', 0, 1);
        $this->Cell(50, 8, 'Due Date:', 0, 0);
        $this->Cell(0, 8, $data['contract']['dueDate'], 0, 1);
        $this->Cell(50, 8, 'Client:', 0, 0);
        $this->Cell(0, 8, $data['contract']['client'], 0, 1);
        $this->Cell(50, 8, 'Loan Type:', 0, 0);
        $this->Cell(0, 8, $data['contract']['loanType'], 0, 1);
        $this->Ln(5);

        // Status Section
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 10, 'Status', 0, 1);
        $this->SetFont('Helvetica', '', 10);
        $this->Cell(50, 8, 'Current Status:', 0, 0);
        $this->Cell(0, 8, $data['status']['libelle'] ?? 'N/A', 0, 1);
        $this->Cell(50, 8, 'Status Date:', 0, 0);
        $this->Cell(0, 8, $data['status']['date'] ?? 'N/A', 0, 1);
        $this->Ln(5);

        // Repayment History Table
        $this->SetFont('Helvetica', 'B', 12);
        $this->Cell(0, 10, 'Repayment History', 0, 1);
        $this->SetFont('Helvetica', 'B', 10);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(20, 8, 'Period', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Date', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Total Due', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Interest', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Capital Repaid', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Capital Remaining', 1, 1, 'C', true);

        $this->SetFont('Helvetica', '', 10);
        foreach ($data['repayments'] as $repayment) {
            $this->Cell(20, 8, $repayment['index_period'], 1, 0, 'C');
            $this->Cell(30, 8, $repayment['date_retour'] ?? 'N/A', 1, 0, 'C');
            $this->Cell(30, 8, number_format($repayment['total_due'], 2) . ' EUR', 1, 0, 'C');
            $this->Cell(30, 8, number_format($repayment['interet'], 2) . ' EUR', 1, 0, 'C');
            $this->Cell(30, 8, number_format($repayment['capital_rembourse'], 2) . ' EUR', 1, 0, 'C');
            $this->Cell(30, 8, number_format($repayment['capital_restant'], 2) . ' EUR', 1, 1, 'C');
        }
    }
}
?>