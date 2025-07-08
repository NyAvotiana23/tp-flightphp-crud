<?php

require_once 'BaseModel.php';

class PretClient extends BaseModel {
    public function __construct() {
        parent::__construct('EF_prets_clients');
    }

    public function getMonthlyInterestSum($startDate, $endDate) {
        $sql = "
            SELECT
                DATE_FORMAT(date_remboursement, '%Y-%m') AS month,
                SUM(montant_interet) AS total_interest
            FROM
                EF_remboursements_prets
            WHERE
                date_remboursement BETWEEN ? AND ?
            GROUP BY
                month
            ORDER BY
                month ASC
        ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$startDate, $endDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching monthly interest sum: " . $e->getMessage());
            return [];
        }
    }


}
