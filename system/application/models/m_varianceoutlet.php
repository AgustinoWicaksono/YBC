<?php
class M_varianceoutlet extends Model {

	function M_varianceoutlet() {
		parent::Model();
		$this->load->model('m_general');
		$this->load->library('l_general');
	}

	// start of browse

	function varianceoutlet_get_period_selection() {
      $plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->select('S_PERIODE, E_PERIODE');
      $this->db->from('rpt_variance');
      $this->db->where('OUTLET',$plant);
      $this->db->group_by(array("S_PERIODE", "E_PERIODE"));
      $this->db->order_by("E_PERIODE", "desc");
      $this->db->limit(10);
      $query = $this->db->get();
      if($query->num_rows() > 0) {
         return $query->result_array();
      } else {
         return FALSE;
      }
    }

	function varianceoutlet_select_matr($date_from,$date_to) {
        $plant = $this->session->userdata['ADMIN']['plant'];
		$swbQuery = "
          	SELECT MATERIAL AS 'Kode Barang',
                    COALESCE((SELECT MAKTX FROM m_item WHERE MATNR = MATERIAL LIMIT 1),SPACE(1)) AS 'Nama Barang',

                     rpt_variance.UOM AS 'UoM',

                    (COALESCE((SELECT SUM(quantity)
                    FROM t_stockoutlet_detail_bom
                    WHERE material_no = MATERIAL
                    AND id_stockoutlet_header =
                    (SELECT MAX(id_stockoutlet_header) FROM t_stockoutlet_header
                     WHERE posting_date < '$date_from'
                     AND plant = OUTLET
                     AND STATUS = 2)),0) +
                    COALESCE((SELECT SUM(quantity)
                    FROM t_stockoutlet_detail
                    WHERE material_no = MATERIAL
                    AND id_stockoutlet_header =
                    (SELECT MAX(id_stockoutlet_header) FROM t_stockoutlet_header
                     WHERE posting_date < '$date_from'
                     AND plant = OUTLET
                     AND STATUS = 2)),0)) /
                     CASE UOM WHEN 'KG' THEN 1000 WHEN 'L' THEN 1000 ELSE 1 END
          			AS 'Stock Awal',

          		      COALESCE((SELECT SUM(gr_quantity)
                       FROM t_grpo_detail
          		       INNER JOIN t_grpo_header ON t_grpo_header.id_grpo_header =
          		       t_grpo_detail.id_grpo_header
          		       WHERE material_no = MATERIAL AND posting_date >= '$date_from' AND posting_date <= '$date_to'
          		       AND plant = OUTLET
          		       AND status = 2 AND COALESCE(ok_cancel,0) = 0),0)
          			AS 'In Supplier',

          		      COALESCE((SELECT SUM(DLV_QTY) FROM Z_MM_BAPI_PRVSDOVSGR
          		       WHERE Z_MM_BAPI_PRVSDOVSGR.MATERIAL = rpt_variance.MATERIAL
                       AND Z_MM_BAPI_PRVSDOVSGR.PERIODE >= S_PERIODE
                       AND Z_MM_BAPI_PRVSDOVSGR.PERIODE <= E_PERIODE
          		       AND Z_MM_BAPI_PRVSDOVSGR.OUTLET = rpt_variance.OUTLET),0)
          			AS 'In CK',

          		       COALESCE((SELECT SUM(gr_quantity) FROM t_grsto_detail
          		       INNER JOIN t_grsto_header ON t_grsto_header.id_grsto_header =
          		       t_grsto_detail.id_grsto_header
          		       WHERE material_no = MATERIAL AND posting_date >= '$date_from' AND posting_date <= '$date_to'
          		       AND plant = OUTLET
          		       AND status = 2 AND COALESCE(ok_cancel,0) = 0),0) /
                       CASE UOM WHEN 'KG' THEN 1000 WHEN 'L' THEN 1000 ELSE 1 END
          			AS 'Transfer In Outlet',

          		      COALESCE((SELECT SUM(gr_quantity) FROM t_gisto_detail
          		       INNER JOIN t_gisto_header ON t_gisto_header.id_gisto_header =
          		       t_gisto_detail.id_gisto_header
          		       WHERE material_no = MATERIAL AND posting_date >= '$date_from' AND posting_date <= '$date_to'
          		       AND plant = OUTLET
          		       AND status = 2 AND COALESCE(ok_cancel,0) = 0),0) /
                       CASE UOM WHEN 'KG' THEN 1000 WHEN 'L' THEN 1000 ELSE 1 END
          			AS 'Transfer Out Outlet',

                    rpt_variance.RETUR AS 'Retur',

                      (COALESCE((SELECT SUM(quantity)
                    FROM t_waste_detail_bom
                    WHERE material_no = MATERIAL
                    AND id_waste_header IN
                    (SELECT id_waste_header FROM t_waste_header
                     WHERE posting_date >= '$date_from' AND posting_date <= '$date_to'
                     AND plant = OUTLET
                     AND t_waste_header.id_waste_header = t_waste_detail_bom.id_waste_header
                     AND STATUS = 2)),0) +
                    COALESCE((SELECT SUM(quantity)
                    FROM t_waste_detail
                    WHERE material_no = MATERIAL
                    AND id_waste_header IN
                    (SELECT id_waste_header FROM t_waste_header
                     WHERE posting_date >= '$date_from' AND posting_date <= '$date_to'
                     AND plant = OUTLET
                     AND t_waste_header.id_waste_header = t_waste_detail.id_waste_header
                     AND STATUS = 2)),0))  /
                     CASE UOM WHEN 'KG' THEN 1000 WHEN 'L' THEN 1000 ELSE 1 END
          			AS 'Waste',

                      (COALESCE((SELECT SUM(quantity)
                    FROM t_stockoutlet_detail_bom
                    WHERE material_no = MATERIAL
                    AND id_stockoutlet_header =
                    (SELECT MAX(id_stockoutlet_header) FROM t_stockoutlet_header
                     WHERE posting_date >= '$date_from' AND posting_date <= '$date_to'
                     AND plant = OUTLET
                     AND STATUS = 2)),0) +
                    COALESCE((SELECT SUM(quantity)
                    FROM t_stockoutlet_detail
                    WHERE material_no = MATERIAL
                    AND id_stockoutlet_header =
                    (SELECT MAX(id_stockoutlet_header) FROM t_stockoutlet_header
                     WHERE posting_date >= '$date_from' AND posting_date <= '$date_to'
                     AND plant = OUTLET
                     AND STATUS = 2)),0))  /
                     CASE UOM WHEN 'KG' THEN 1000 WHEN 'L' THEN 1000 ELSE 1 END
          			AS 'Stock Akhir',

                     rpt_variance.ACTUAL AS 'Actual Usage',

                     rpt_variance.STANDART AS 'Standart',

                    rpt_variance.VARIANCE AS 'Variant'

          	FROM rpt_variance
            WHERE OUTLET = '$plant'
            AND (MATERIAL IN
            (SELECT m_item.MATNR FROM m_item
             WHERE m_item.MATNR = MATERIAL
             AND MTART NOT IN ('ZFG3','ZFG7','ZFG9')) OR LEFT(OUTLET,1) != 'B')
            AND S_PERIODE = '$date_from'
            AND E_PERIODE = '$date_to'; ";
			
			// echo $swbQuery.'<hr />';
		$query = $this->db->query($swbQuery);

		if($query->num_rows() > 0) {
            return $query->result_array();
        } else {
          return FALSE;
        }
	}
}
?>