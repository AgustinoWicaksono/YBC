<?php
class M_uploadrptvariance extends Model {

	function M_uploadrptvariance() {
		parent::Model();
		$this->load->model('m_general');
		$this->load->library('l_general');
	}

	// start of browse

	function sap_rpt_variance($s_period,$e_period) {
         $kd_plant = $this->session->userdata['ADMIN']['plant'];
         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("Z_PP_BAPI_VARIANCE");
         $this->m_saprfc->importParameter(array ("E_PERIODE",
                                             "OUTLET",
                                             "S_PERIODE"),
                                      array ($e_period,
                                             $kd_plant,
                                             $s_period)
                                      );

         $this->m_saprfc->setInitTable("VARIANCE");
         $this->m_saprfc->executeSAP();
         $REPORT_DATA = $this->m_saprfc->fetch_rows("VARIANCE");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($REPORT_DATA) > 0) {
          return $REPORT_DATA;
        } else {
          return FALSE;
        }

	}

	function uploadrptvariance_delete($outlet,$date_from,$date_to) {
    	$this->db->where('OUTLET', $outlet);
    	$this->db->where('S_PERIODE',$date_from);
    	$this->db->where('E_PERIODE',$date_to);
    	$this->db->delete('rpt_variance');
	}

	function uploadrptvariance_upload($date_from,$date_to) {
      $plant = $this->session->userdata['ADMIN']['plant'];
      $this->uploadrptvariance_delete($plant,$date_from,$date_to);
	  $datas = $this->sap_rpt_variance($date_from,$date_to);
      foreach ($datas as $data) {
        if(is_numeric($data['MATERIAL'])) {
           $data['MATERIAL'] = str_repeat('0',12).trim($data['MATERIAL']);
        }
       if($this->l_general->rightstr($data['VARIANCE'],1)=='-') {
           $data['VARIANCE'] = -$data['VARIANCE'];
        }
        if($this->db->insert('rpt_variance',$data)==FALSE) {
          $this->uploadrptvariance_delete($plant,$date_from,$date_to);
		  return FALSE;
        }
      }
      return TRUE;
      /*
      $query = $this->db->query("
            UPDATE rpt_variance
            SET NAMA_BARANG = (SELECT MAKTX FROM m_item WHERE MATNR = MATERIAL LIMIT 1),
                UOM = (SELECT UNIT FROM m_item WHERE MATNR = MATERIAL LIMIT 1),
          		STOCK_AWAL = COALESCE((SELECT quantity FROM t_stockoutlet_detail_bom
          		       INNER JOIN t_stockoutlet_header ON t_stockoutlet_header.id_stockoutlet_header =
          		       t_stockoutlet_detail_bom.id_stockoutlet_header
          		       WHERE material_no = MATERIAL AND posting_date < S_PERIODE
          		       AND plant = OUTLET ORDER BY posting_date DESC LIMIT 1 ),0)+
          		      COALESCE((SELECT quantity FROM t_stockoutlet_detail
          		       INNER JOIN t_stockoutlet_header ON t_stockoutlet_header.id_stockoutlet_header =
          		       t_stockoutlet_detail.id_stockoutlet_header
          		       WHERE material_no = MATERIAL AND posting_date < S_PERIODE
          		       AND plant = OUTLET ORDER BY posting_date DESC LIMIT 1 ),0),

          		IN_SUPPLIER = COALESCE((SELECT SUM(gr_quantity) FROM t_grpo_detail
          		       INNER JOIN t_grpo_header ON t_grpo_header.id_grpo_header =
          		       t_grpo_detail.id_grpo_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET
          		       AND status = 2 AND ok_cancel = 0),0),

          		IN_CK = COALESCE((SELECT SUM(DLV_QTY) FROM Z_MM_BAPI_PRVSDOVSGR
          		       WHERE MATERIAL = MATERIAL AND PERIODE >= S_PERIODE AND PERIODE <= E_PERIODE
          		       AND OUTLET = OUTLET),0),

          		TRANSFER_IN = COALESCE((SELECT SUM(gr_quantity) FROM t_gisto_detail
          		       INNER JOIN t_gisto_header ON t_gisto_header.id_gisto_header =
          		       t_gisto_detail.id_gisto_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET
          		       AND status = 2 AND ok_cancel = 0),0),

          		TRANSFER_OUT = COALESCE((SELECT SUM(gr_quantity) FROM t_grsto_detail
          		       INNER JOIN t_grsto_header ON t_grsto_header.id_grsto_header =
          		       t_grsto_detail.id_grsto_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET
          		       AND status = 2 AND ok_cancel = 0),0),

          		WASTE = COALESCE((SELECT SUM(quantity) FROM t_waste_detail
          		       INNER JOIN t_waste_header ON t_waste_header.id_waste_header =
          		       t_waste_detail.id_waste_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET
          		       AND status = 2),0)+
          			COALESCE((SELECT SUM(quantity) FROM t_waste_detail_bom
          		       INNER JOIN t_waste_header ON t_waste_header.id_waste_header =
          		       t_waste_detail_bom.id_waste_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET
          		       AND status = 2),0),

          		STOCK_AKHIR = COALESCE((SELECT quantity FROM t_stockoutlet_detail_bom
          		       INNER JOIN t_stockoutlet_header ON t_stockoutlet_header.id_stockoutlet_header =
          		       t_stockoutlet_detail_bom.id_stockoutlet_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET ORDER BY posting_date DESC LIMIT 1 ),0)+
          		      COALESCE((SELECT quantity FROM t_stockoutlet_detail
          		       INNER JOIN t_stockoutlet_header ON t_stockoutlet_header.id_stockoutlet_header =
          		       t_stockoutlet_detail.id_stockoutlet_header
          		       WHERE material_no = MATERIAL AND posting_date >= S_PERIODE AND posting_date <= E_PERIODE
          		       AND plant = OUTLET ORDER BY posting_date DESC LIMIT 1 ),0)

               WHERE OUTLET = '$plant'
               AND S_PERIODE = '$date_from'
               AND E_PERIODE = '$date_to' ");
       */

	}


}
?>