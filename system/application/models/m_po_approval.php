<?php
class M_po_approval extends Model {

	function M_po_approval() {
		parent::Model();
		$this->load->model('m_admin');
//		$this->load->model('m_general');
	}

	function get_user_to_login_sap() {
      return $this->m_admin->admin_select_username($this->session->userdata['ADMIN']['admin_id']);
    }

	function get_user_pwd_to_login_sap() {
      return $this->session->userdata['ADMIN']['password'];
    }

	function sap_po_approval_header_select($po = "", $release = "") {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("BAPI_PO_GETDETAIL");
         $this->m_saprfc->importParameter(array ("PURCHASEORDER"),
                                          array ($po));
         $this->m_saprfc->executeSAP();
         $PO_HEADER = $this->m_saprfc->export("PO_HEADER");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($PO_HEADER) > 0) {
          return $PO_HEADER;
        } else {
          return FALSE;
        }

        /*
        $this->db->from('wiwid_po_appr_header');
		$this->db->where('po', $po);
		$this->db->where('release', $release);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->row_array();
		}	else {
			return FALSE;
		}
         */
	}

	function sap_po_approval_header_update($data) {

         $this->m_saprfc->setUserRfc($this->get_user_to_login_sap());
         $this->m_saprfc->setPassRfc($this->get_user_pwd_to_login_sap());
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         if ($data['status']==1)
             $this->m_saprfc->functionDiscover("BAPI_PO_RELEASE");
         else
             $this->m_saprfc->functionDiscover("BAPI_PO_RESET_RELEASE");

         $this->m_saprfc->importParameter(array ("PURCHASEORDER","PO_REL_CODE","USE_EXCEPTIONS",),
                                          array ($data['po'],$data['release'],"X",));
         $this->m_saprfc->setInitTable("RETURN");
         $this->m_saprfc->executeSAP();
         $REL_STATUS_NEW = $this->m_saprfc->export("REL_STATUS_NEW");
         $RETURN = $this->m_saprfc->fetch_rows("RETURN");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

         $sap_messages = '';
         for($i=1;$i<=$count;$i++) {
           $sap_messages = $sap_messages.' <br> '.$RETURN[$i]['MESSAGE'];
         }
         $approved_data = array (
           "REL_STATUS_NEW" => $REL_STATUS_NEW,
           "sap_messages" => $sap_messages,
           "sap_messages_type" => $RETURN[1]['TYPE']
         );

         return $approved_data;

	   /*	$this->db->where('po', $data['po']);
		if($this->db->update('wiwid_po_appr_header', $data))
			return TRUE;
		else
			return FALSE;*/
	}

	function sap_po_approval_header_reject($data) {

         $this->m_saprfc->setUserRfc($this->get_user_to_login_sap());
         $this->m_saprfc->setPassRfc($this->get_user_pwd_to_login_sap());
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
          $this->m_saprfc->functionDiscover("ZMM_REJECT_PO");

         $this->m_saprfc->importParameter(array ("PA_EBELN","PA_COMMIT",),
                                          array ($data['po'],"X",));
         $this->m_saprfc->executeSAP();
         $PA_STAT = $this->m_saprfc->export("PA_STAT");
         $PA_TEXT = $this->m_saprfc->export("PA_TEXT");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

         $approved_data = array (
           "PA_STAT" => $PA_STAT,
           "sap_messages" => $PA_TEXT,
         );

         return $approved_data;

	   /*	$this->db->where('po', $data['po']);
		if($this->db->update('wiwid_po_appr_header', $data))
			return TRUE;
		else
			return FALSE;*/
	}

	function sap_po_approval_details_select($po = "", $release = "") {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("BAPI_PO_GETDETAIL");
         $this->m_saprfc->importParameter(array ("PURCHASEORDER","ITEMS",),
                                          array ($po,"X",));
         $this->m_saprfc->setInitTable("PO_ITEMS");
         $this->m_saprfc->executeSAP();
         $PO_ITEMS = $this->m_saprfc->fetch_rows("PO_ITEMS");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($PO_ITEMS) > 0) {
          return $PO_ITEMS;
        } else {
          return FALSE;
        }

/*		$this->db->from('wiwid_po_appr_detail');
		$this->db->where('po', $po);
		$this->db->where('release', $release);

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query;
		}	else {
			return FALSE;
		}
      */
	}

	function sap_po_approval_details_select_delivery_date($po = "") {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("BAPI_PO_GETDETAIL");
         $this->m_saprfc->importParameter(array ("PURCHASEORDER","SCHEDULES",),
                                          array ($po,"X",));
         $this->m_saprfc->setInitTable("PO_ITEM_SCHEDULES");
         $this->m_saprfc->executeSAP();
         $PO_ITEMS = $this->m_saprfc->fetch_rows("PO_ITEM_SCHEDULES");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($PO_ITEMS) > 0) {
          return $PO_ITEMS;
        } else {
          return FALSE;
        }

	}

	function sap_po_approval_details_select_cost_center($po = "") {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("BAPI_PO_GETDETAIL");
         $this->m_saprfc->importParameter(array ("PURCHASEORDER","ACCOUNT_ASSIGNMENT",),
                                          array ($po,"X",));
         $this->m_saprfc->setInitTable("PO_ITEM_ACCOUNT_ASSIGNMENT");
         $this->m_saprfc->executeSAP();
         $PO_ITEMS = $this->m_saprfc->fetch_rows("PO_ITEM_ACCOUNT_ASSIGNMENT");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (count($PO_ITEMS) > 0) {
          return $PO_ITEMS;
        } else {
          return FALSE;
        }

	}

	function sap_po_approval_details_po_status($po) {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_GET_STAT_PO");
         $this->m_saprfc->importParameter(array ("PV_EBELN"),
                                          array ($po,));
         $this->m_saprfc->executeSAP();
         $PV_PROCSTAT = $this->m_saprfc->export("PV_PROCSTAT");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        if (!empty($PV_PROCSTAT)) {
          return $PV_PROCSTAT;
        } else {
          return FALSE;
        }

	}

	function sap_po_approval_select_cost_center_desc($cost_center_code) {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_DWN_MASTER");
         $this->m_saprfc->setInitTable("ZM_MSTRKOSTL");
         $this->m_saprfc->executeSAP();
         $COST_CENTERS = $this->m_saprfc->fetch_rows("ZM_MSTRKOSTL");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        foreach ( $COST_CENTERS as $COST_CENTER ) {
           if (strcmp($COST_CENTER['KOSTL'],$cost_center_code) == 0) {
             return $COST_CENTER;
           } else {
             continue;
           }
        }
        return FALSE;
	}

	function sap_po_approval_select_int_order_desc($int_order_no) {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_DWN_MASTER");
         $this->m_saprfc->setInitTable("ZM_MSTRAUFNR");
         $this->m_saprfc->executeSAP();
         $INT_ORDERS = $this->m_saprfc->fetch_rows("ZM_MSTRAUFNR");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

        foreach ( $INT_ORDERS as $INT_ORDER ) {
           if (strcmp($INT_ORDER['AUFNR'],$int_order_no) == 0) {
             return $INT_ORDER;
           } else {
             continue;
           }
        }
        return FALSE;
	}

	function sap_po_approval_select_release_code_desc($release_code) {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_DWN_MASTER");
         $this->m_saprfc->setInitTable("ZM_T16FD");
         $this->m_saprfc->executeSAP();
         $T16FDS = $this->m_saprfc->fetch_rows("ZM_T16FD");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

         if (!empty($T16FDS))
           foreach ( $T16FDS as $T16FD ) {
             if (strcmp($T16FD['FRGCO'],$release_code) == 0) {
               return $T16FD;
             } else {
               continue;
             }
        }
        return FALSE;
	}

	function sap_po_approval_select_release_status($release_code,$release_group) {

         $this->m_saprfc->setUserRfc();
         $this->m_saprfc->setPassRfc();
         $this->m_saprfc->sapAttr();
         $this->m_saprfc->connect();
         $this->m_saprfc->functionDiscover("ZMM_DWN_MASTER");
         $this->m_saprfc->setInitTable("ZM_T16FV");
         $this->m_saprfc->setInitTable("ZM_T16FW");
         $this->m_saprfc->executeSAP();
         $T16FVS = $this->m_saprfc->fetch_rows("ZM_T16FV");
         $T16FWS = $this->m_saprfc->fetch_rows("ZM_T16FW");
         $this->m_saprfc->free();
         $this->m_saprfc->close();

         if (!empty($T16FVS)&&!empty($T16FWS)) {
           $user_is_approver = FALSE;
           foreach ( $T16FWS as $T16FW ) {
             if ((strcasecmp($T16FW['OBJID'],$this->get_user_to_login_sap()) == 0)&&
                (strcasecmp($T16FW['FRGCO'],$release_code) == 0)&&
                (strcasecmp($T16FW['FRGGR'],$release_group) == 0)) {
               $user_is_approver = TRUE;
              }
             $i++;
           }
           if ($user_is_approver)
               foreach ( $T16FVS as $T16FV ) {
                 if ((strcasecmp($T16FV['FRGCO'],$release_code) == 0)&&
                    (strcasecmp($T16FV['FRGGR'],$release_group) == 0)) {
                 if (strcasecmp($T16FV['FRGA1'],'X') == 0)
                   return 1;
                 else if (strcasecmp($T16FV['FRGA2'],'X') == 0)
                   return 2;
                 else if (strcasecmp($T16FV['FRGA3'],'X') == 0)
                   return 3;
                 else if (strcasecmp($T16FV['FRGA4'],'X') == 0)
                   return 4;
                 else if (strcasecmp($T16FV['FRGA5'],'X') == 0)
                   return 5;
                 else if (strcasecmp($T16FV['FRGA6'],'X') == 0)
                   return 6;
                 else if (strcasecmp($T16FV['FRGA7'],'X') == 0)
                   return 7;
                 else if (strcasecmp($T16FV['FRGA8'],'X') == 0)
                   return 8;
                 else
                   continue;
                }
    	    }
        }
        return FALSE;
     }
}