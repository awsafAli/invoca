<?php
class DataEditor {
    private $db;

    public function __construct($db) {
        $this->db = new Database();
    }

    public function updateData($data, $id) {
        $query = "UPDATE tb_trend SET 
                    ADJ_LKPS = :ADJ_LKPS, 
                    SEG_LKPS = :SEG_LKPS, 
                    BS_PL_LKPS_TOTAL = :BS_PL_LKPS_TOTAL, 
                    AS_OF_DATE = :AS_OF_DATE, 
                    GL_ACCOUNT_ID = :GL_ACCOUNT_ID, 
                    Account_Description = :Account_Description, 
                    Opening_Balance = :Opening_Balance, 
                    Debit = :Debit, 
                    Credit = :Credit, 
                    Ending_Balance = :Ending_Balance, 
                    Adjustments = :Adjustments, 
                    Revised_Balance = :Revised_Balance, 
                    REP_LINE_DESC1 = :REP_LINE_DESC1, 
                    REP_LINE_DESC2 = :REP_LINE_DESC2, 
                    REP_LINE_DESC3 = :REP_LINE_DESC3, 
                    REP_LINE_DESC4 = :REP_LINE_DESC4, 
                    SEGMENT = :SEGMENT 
                  WHERE id = :id";
        return $this->db->query($query, array_merge($data, ['id' => $id]));
    }

    public function deleteData($id) {
        $query = "DELETE FROM tb_trend WHERE id = :id";
        return $this->db->query($query, ['id' => $id]);
    }
}
?>
