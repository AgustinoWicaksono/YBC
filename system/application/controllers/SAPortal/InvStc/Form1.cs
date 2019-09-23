using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Windows.Forms;
using System.Data.SqlClient;
using System.Threading;
using Microsoft.VisualBasic;
using MySql.Data;
using MySql.Data.MySqlClient;



namespace InvStc
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            
            InitializeComponent();
        }

        public SAPbobsCOM.Company oCompany;
        public string sErrMsg = null;
        public int lErrCode = 0;
        public int lRetCode;
        public string serverdb;
        public string SAPDb = "DEMO_MSI";
        sap_php sap_ph = new sap_php();
        sap_php1 sap_ph1 = new sap_php1();
        db_Goodissue dbi = new db_Goodissue();
        inv_trf itf = new inv_trf();
        inv_trf1 itf1 = new inv_trf1();
        inv_trfGI itfGI = new inv_trfGI();
        paket pkt = new paket();
        grsto sto = new grsto();
        grpodeliver gpd = new grpodeliver();
        grpodept gpde = new grpodept();
        errorLog erl = new errorLog();
        inv_counted ict = new inv_counted();
        gr_waste gws = new gr_waste();
        private DataSet ds,ds1;
        private MySqlCommand cmd,cmd1;
        private MySqlDataAdapter da,da1;
        private string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
       
       

        void konSAP()
        {
            oCompany = new SAPbobsCOM.Company();
            oCompany.Server = "SVR-S-2012-64";
            oCompany.DbServerType = SAPbobsCOM.BoDataServerTypes.dst_MSSQL2012;
            oCompany.DbUserName = "sa";
            oCompany.DbPassword = "abc123?";
            oCompany.UseTrusted = false;
            oCompany.CompanyDB = SAPDb;
            oCompany.UserName = "manager";
            oCompany.Password = "1234";
            oCompany.language = SAPbobsCOM.BoSuppLangs.ln_English;
            oCompany.LicenseServer = "localhost:30000";

            lRetCode = oCompany.Connect();

            if (lRetCode != 0)
            {
                int temp_int = lErrCode;
                string temp_string = sErrMsg;
                oCompany.GetLastError(out temp_int, out temp_string);
                MessageBox.Show(temp_string);
            }
            else
            {
                MessageBox.Show("Terhubung ke " + oCompany.CompanyName + " (SAP)");
                this.Text = this.Text + ": Tersambung";
            }

        }

        /*nihh
         * BASETYPE
            -gisto = 0 DONE
            -grsto = 1 DONE
            -gr_waste = 2 DONE
            -grpo = 3 DONE
            -grsto WITH DELIVERY = 67 DONE
            -twts = 5 (status = 10) DONE - Belum Dites good receipt = 5 (status = 11) DONE
            -Opname BESOK SELESAI
            -Paket DONE
          Opname
         */

        void GRPO_header()
        {
            
            DataSet data = sap_ph.getData();
            DGSAPphp.DataSource = data;
            DGSAPphp.DataMember = "ip";
        }

        void GRPO_nonheader()
        {

            DataSet data = sap_ph1.getData();
            DGSAP_phpNON.DataSource = data;
            DGSAP_phpNON.DataMember = "is";
        }

        void TWTS_header()
        {
            DataSet data = dbi.getData();
            DGtwts.DataSource = data;
            DGtwts.DataMember = "ts";
        }

        void stdstock_header()
        {
            DataSet data = itf.getData();
            DGstd.DataSource = data;
            DGstd.DataMember = "tt";
        }

        void nonstdstock_header()
        {
            DataSet data = itf1.getData();
            DGst1.DataSource = data;
            DGst1.DataMember = "tt";
        }

        void gisto_header()
        {
            DataSet data = itfGI.getData();
            dgsInvtTransGIHd.DataSource = data;
            dgsInvtTransGIHd.DataMember = "tt";
        }

        void paket_header()
        {
            DataSet data = pkt.getData();
            DGpkt.DataSource = data;
            DGpkt.DataMember = "tt";
        }

        void grsto_header()
        {
            DataSet data = sto.getData();
            dgSTO.DataSource = data;
            dgSTO.DataMember = "ts";
        }

        void grpodeliver_header()
        {
            DataSet data = gpd.getData();
            dgGRPODel.DataSource = data;
            dgGRPODel.DataMember = "pd";
        }

        void grpodeliver_dept_header()
        {
            DataSet data = gpde.getData();
            dgGRPO_dept.DataSource = data;
            dgGRPO_dept.DataMember = "pde";
        }

        void invCounted_header()
        {
            DataSet data = ict.getData();
            dgCount.DataSource = data;
            dgCount.DataMember = "ts";
        }

        void waste_header()
        {
            DataSet data = gws.getData();
            dgWaste.DataSource = data;
            dgWaste.DataMember = "ts";
        }

        void error_header()
        {
            DataSet data = erl.getData();
            dgErorLog.DataSource = data;
            dgErorLog.DataMember = "tt";
        }

        void gr_PO()
        {
            DateTime DT = DateTime.Now;
            string module = "GR PO";
            SAPbobsCOM.Documents oGR;
            oGR = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oPurchaseDeliveryNotes);

            int i = 0;
             int count = DGSAPphp.Rows.Count - 1;
             if (count != 0)
             {
                 do
                 {
                     oGR.CardCode = DGSAPphp.Rows[i].Cells[0].Value.ToString();
                     oGR.CardName = DGSAPphp.Rows[i].Cells[1].Value.ToString();
                     oGR.DocDate = Convert.ToDateTime(DGSAPphp.Rows[i].Cells[2].Value);
                     oGR.DocDueDate = Convert.ToDateTime(DGSAPphp.Rows[i].Cells[3].Value);
                     oGR.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                     int id = Convert.ToInt32(DGSAPphp.Rows[i].Cells[4].Value);
                     /** START CONECTION MYSQL **/
                     MySqlConnection conn = new MySqlConnection(konfigurasi);
                     conn.Open();
                     cmd = new MySqlCommand();
                     cmd.Connection = conn;
                     cmd.CommandType = CommandType.Text;
                     cmd.CommandText = "SELECT TGD.material_no, TGD.material_desc,TGD.gr_quantity, TGD.item, TGH.po_no,TGH.plant FROM t_grpo_detail TGD JOIN t_grpo_header TGH ON TGD.id_grpo_header = TGH.id_grpo_header where TGD.id_grpo_header = '" + id + "'";
                     ds = new DataSet();
                     da = new MySqlDataAdapter(cmd);
                     da.Fill(ds, "dt");
                     DGSAP_phpDetail.DataSource = ds;
                     DGSAP_phpDetail.DataMember = "dt";
                     conn.Close();

                     int max = DGSAP_phpDetail.Rows.Count - 1;
                     int a = 0;
                     if (max != 0)
                     {
                         do
                         {
                             string Item = DGSAP_phpDetail.Rows[a].Cells[0].Value.ToString();
                             oGR.Lines.SetCurrentLine(a);
                             oGR.Lines.BaseType = 22;
                             oGR.Lines.BaseEntry = Convert.ToInt32(DGSAP_phpDetail.Rows[a].Cells[4].Value);
                             oGR.Lines.BaseLine = Convert.ToInt32(DGSAP_phpDetail.Rows[a].Cells[3].Value);
                             oGR.Lines.ItemCode = DGSAP_phpDetail.Rows[a].Cells[0].Value.ToString();
                             oGR.Lines.ItemDescription = DGSAP_phpDetail.Rows[a].Cells[1].Value.ToString();
                             oGR.Lines.Quantity = Convert.ToDouble(DGSAP_phpDetail.Rows[a].Cells[2].Value);
                             oGR.Lines.WarehouseCode = DGSAP_phpDetail.Rows[a].Cells[5].Value.ToString();

                             //mulai batchnumber
                             cmd1 = new MySqlCommand();
                             cmd1.Connection = conn;
                             cmd1.CommandType = CommandType.Text;
                             cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND BaseType = '3' ";
                             ds1 = new DataSet();
                             da1 = new MySqlDataAdapter(cmd1);
                             da1.Fill(ds1, "dt");
                             dgBatch.DataSource = ds1;
                             dgBatch.DataMember = "dt";
                             conn.Close();
                             int b = 0;
                             int hit = dgBatch.Rows.Count - 1;
                             if (hit > 0)
                             {
                                 do
                                 {
                                     if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                     {
                                         oGR.Lines.BatchNumbers.SetCurrentLine(b);
                                         oGR.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                         oGR.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                         oGR.Lines.BatchNumbers.Add();
                                     }
                                     b += 1;
                                 } while (b < hit);
                             }
                             //Sampai Sini

                             if (a < max - 1)
                             {
                                 oGR.Lines.Add();
                             }
                             a += 1;
                         } while (a < max);
                         lRetCode = oGR.Add();
                         oCompany.GetLastError(out lErrCode, out sErrMsg);
                         if (lRetCode != 0)
                         {
                            // ErrorLog(id, module, sErrMsg, DT);
                             MessageBox.Show(sErrMsg.ToString());
                         }
                         else
                         {
                             string key = oCompany.GetNewObjectKey();
                             updateSQL(key, id);

                         }
                     }
                     i += 1;
                 } while (i < count);
             }
        }// gr_po

        void grnon_PO()
        {
            DateTime DT = DateTime.Now;
            string module = "GR Non PO";
            SAPbobsCOM.Documents oGR;
            oGR = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oPurchaseDeliveryNotes);

            int i = 0;
            int count = DGSAP_phpNON.Rows.Count - 1;
            if (count != 0)
            {
                do
                {
                    oGR.CardCode = "NPO001";
                    oGR.CardName = "Non PO Vendor";
                    oGR.DocDate = Convert.ToDateTime(DGSAP_phpNON.Rows[i].Cells[0].Value);
                    oGR.DocDueDate = Convert.ToDateTime(DGSAP_phpNON.Rows[i].Cells[0].Value);
                    oGR.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                    int id = Convert.ToInt32(DGSAP_phpNON.Rows[i].Cells[1].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT TGD.material_no, TGD.material_desc,TGD.quantity,TGH.plant FROM t_grnonpo_detail TGD JOIN t_grnonpo_header TGH ON TGD.id_grnonpo_header = TGH.id_grnonpo_header where TGD.id_grnonpo_header = '" + id + "'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    DGSAP_NONDet.DataSource = ds;
                    DGSAP_NONDet.DataMember = "dt";
                    conn.Close();

                    int max = DGSAP_NONDet.Rows.Count - 1;
                    int a = 0;
                    if (max != 0)
                    {
                        do
                        {
                            oGR.Lines.SetCurrentLine(a);
                            oGR.Lines.ItemCode = DGSAP_NONDet.Rows[a].Cells[0].Value.ToString();
                            oGR.Lines.ItemDescription = DGSAP_NONDet.Rows[a].Cells[1].Value.ToString();
                            oGR.Lines.Quantity = Convert.ToDouble(DGSAP_NONDet.Rows[a].Cells[2].Value);
                            oGR.Lines.WarehouseCode = DGSAP_NONDet.Rows[a].Cells[3].Value.ToString();
                            if (a < max - 1)
                            {
                                oGR.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);
                        lRetCode = oGR.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updateSQL1(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);
            }
        } // jangan dulu

        void good_receipt(int id,double price) //good receipt
        {
            DateTime DT = DateTime.Now;
            string module = "Good Receipt Whole to Slice";
            SAPbobsCOM.Documents oGR;
            oGR = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryGenEntry);

            MySqlConnection conn = new MySqlConnection(konfigurasi);
            conn.Open();
            cmd = new MySqlCommand();
            cmd.Connection = conn;
            cmd.CommandType = CommandType.Text;
            cmd.CommandText = "SELECT id_twts_header,posting_date FROM t_twts_header where id_twts_header = '" + id + "'";
            ds = new DataSet();
            da = new MySqlDataAdapter(cmd);
            da.Fill(ds, "dt");
            DGGr.DataSource = ds;
            DGGr.DataMember = "dt";
            oGR.DocDate = Convert.ToDateTime(DGGr.Rows[0].Cells[1].Value);
            oGR.DocDueDate = Convert.ToDateTime(DGGr.Rows[0].Cells[1].Value);
            cmd.CommandText = "SELECT item, material_no_gr, material_desc_gr, quantity_gr,b.plant FROM t_twts_detail a " +
                                  "  JOIN t_twts_header b ON a.id_twts_header = b.id_twts_header where a.id_twts_header = '" + id + "'";
            ds = new DataSet();
            da = new MySqlDataAdapter(cmd);
            da.Fill(ds, "di");
            DGGr_Detail.DataSource = ds;
            DGGr_Detail.DataMember = "di";
            

            int i = 0;
            int count = DGGr_Detail.Rows.Count - 1;
            if (count != 0)
            { 
                do
                {
                    string Item = DGGr_Detail.Rows[i].Cells[1].Value.ToString();
                    oGR.Lines.SetCurrentLine(i);
                    oGR.Lines.ItemCode = DGGr_Detail.Rows[i].Cells[1].Value.ToString();
                    oGR.Lines.ItemDescription = DGGr_Detail.Rows[i].Cells[2].Value.ToString();
                    double qty = Convert.ToDouble(DGGr_Detail.Rows[i].Cells[3].Value);
                    double price1 = price / qty;
                    oGR.Lines.Quantity = qty;
                    oGR.Lines.UnitPrice = price1;
                    oGR.Lines.WarehouseCode = DGGr_Detail.Rows[i].Cells[4].Value.ToString();
                    oGR.Lines.LineTotal = price;

                    //mulai batchnumber
                    cmd1 = new MySqlCommand();
                    cmd1.Connection = conn;
                    cmd1.CommandType = CommandType.Text;
                    cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND Basetype = '5' AND status = '11' ";
                    ds1 = new DataSet();
                    da1 = new MySqlDataAdapter(cmd1);
                    da1.Fill(ds1, "dt");
                    dgBatch.DataSource = ds1;
                    dgBatch.DataMember = "dt";
                    conn.Close();
                    int b = 0;
                    int hit = dgBatch.Rows.Count - 1;
                    if (hit > 0)
                    {
                        do
                        {
                            if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                            {
                                oGR.Lines.BatchNumbers.SetCurrentLine(b);
                                oGR.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                oGR.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                oGR.Lines.BatchNumbers.Add();
                            }
                            b += 1;
                        } while (b < hit);
                    }
                    //teko mengkene batchnumber

                    if (i < count - 1)
                    {
                        oGR.Lines.Add();
                    }
                    i += 1;
                }while(i <count);
                lRetCode = oGR.Add();
                oCompany.GetLastError(out lErrCode, out sErrMsg);
                if (lRetCode != 0)
                {
                    ErrorLog(id, module, sErrMsg, DT);
                }
                else
                {
                    string key = oCompany.GetNewObjectKey();
                    updateSQL3(key, id);
                    updateSQL2(key, id);
                }

            }
        
        }

        void TWTS() //good issue
        {
            DateTime DT = DateTime.Now;
            string module = "Good Issue Whole to Slice";
            SAPbobsCOM.Documents oGE;
            oGE = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryGenExit);
            
            int i = 0;
            int count = DGtwts.Rows.Count - 1;
            if (count != 0)
            { 
            do
            {
                oGE.DocDate = Convert.ToDateTime(DGtwts.Rows[i].Cells[1].Value);
                oGE.DocDueDate = Convert.ToDateTime(DGtwts.Rows[i].Cells[1].Value);
                int id = Convert.ToInt32(DGtwts.Rows[i].Cells[0].Value);
                /** START CONECTION MYSQL **/
                MySqlConnection conn = new MySqlConnection(konfigurasi);
                conn.Open();
                cmd = new MySqlCommand();
                cmd.Connection = conn;
                cmd.CommandType = CommandType.Text;
                cmd.CommandText = "SELECT item,material_no, material_desc, max(quantity),b.plant FROM t_twts_detail a " +
                                  "  JOIN t_twts_header b ON a.id_twts_header = b.id_twts_header where a.id_twts_header = '" + id + "' group by item, material_no, material_desc, b.plant";
                ds = new DataSet();
                da = new MySqlDataAdapter(cmd);
                da.Fill(ds, "dt");
                DGtwts_det.DataSource = ds;
                DGtwts_det.DataMember = "dt";
                conn.Close();
                int a = 0;
                int max = DGtwts_det.Rows.Count - 1;
                if (max != 0)
                {
                    do
                    {
                        string Item = DGtwts_det.Rows[a].Cells[1].Value.ToString();
                        oGE.Lines.SetCurrentLine(a);
                        oGE.Lines.ItemCode = DGtwts_det.Rows[a].Cells[1].Value.ToString();
                        oGE.Lines.ItemDescription = DGtwts_det.Rows[a].Cells[2].Value.ToString();
                        oGE.Lines.Quantity = Convert.ToDouble(DGtwts_det.Rows[a].Cells[3].Value);
                        oGE.Lines.WarehouseCode = DGtwts_det.Rows[a].Cells[4].Value.ToString();

                        //mulai batchnumber
                        cmd1 = new MySqlCommand();
                        cmd1.Connection = conn;
                        cmd1.CommandType = CommandType.Text;
                        cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND Basetype = '5' AND status = '10' ";
                        ds1 = new DataSet();
                        da1 = new MySqlDataAdapter(cmd1);
                        da1.Fill(ds1, "dt");
                        dgBatch.DataSource = ds1;
                        dgBatch.DataMember = "dt";
                        conn.Close();
                        int b = 0;
                        int hit = dgBatch.Rows.Count - 1;
                        if (hit > 0)
                        {
                            do
                            {
                                if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                {
                                    oGE.Lines.BatchNumbers.SetCurrentLine(b);
                                    oGE.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                    oGE.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                    oGE.Lines.BatchNumbers.Add();
                                }
                                b += 1;
                            } while (b < hit);
                        }
                        //teko mengkene batchnumber

                        if (a < max - 1)
                        {
                            oGE.Lines.Add();
                        }
                        a += 1;
                    } while (a < max);
                    lRetCode = oGE.Add();
                    oCompany.GetLastError(out lErrCode, out sErrMsg);
                    if (lRetCode != 0)
                    {
                        ErrorLog(id, module, sErrMsg, DT);
                    }
                    else
                    {
                        string key = oCompany.GetNewObjectKey();
                        int key1 = Convert.ToInt32(key);
                        SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                        SQLSERVER2.DataSource = "SVR-S-2012-64";
                        SQLSERVER2.InitialCatalog = "MSI";
                        SQLSERVER2.IntegratedSecurity = false;
                        SQLSERVER2.UserID = "sa";
                        SQLSERVER2.Password = "abc123?";
                        SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                        myconnection2.Open();
                        string selectQueryString2 = "SELECT DocTotal FROM OIGE WHERE DocEntry = '"+ key1 +"'";
                        SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                        SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                        DataTable dataTable2 = new DataTable();
                        sqlDataAdapter2.Fill(dataTable2);
                        DGprice.DataSource = dataTable2;
                        double price = Convert.ToDouble(DGprice.Rows[0].Cells[0].Value);               
                        good_receipt(id, price);
                    }
                }
                i += 1;


            }while(i < count);
            }
            

        }

        void inv_trf_req() // inventory transfer request
        {
            DateTime DT = DateTime.Now;
            string module = "Standart Stock";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryTransferRequest);

            int i = 0;
            int count = DGstd.Rows.Count - 1;
            if (count != 0)
            { 
                
                do
                {
                    oIT.Address = DGstd.Rows[i].Cells[0].Value.ToString() + ", " + DGstd.Rows[i].Cells[1].Value.ToString() + ", " + DGstd.Rows[i].Cells[2].Value.ToString();
                  //  oIT.ReqType = 1 ;
                   // oIT.Requester = "manager";
                    oIT.DocDate = Convert.ToDateTime(DGstd.Rows[i].Cells[3].Value);
                    oIT.FromWarehouse = "01";
                    oIT.ToWarehouse = DGstd.Rows[i].Cells[5].Value.ToString();
                   // oIT.RequriedDate = Convert.ToDateTime(DGstd.Rows[i].Cells[3].Value);
                   // oIT.DocDueDate = Convert.ToDateTime(DGstd.Rows[i].Cells[3].Value);
                   // oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                    int id = Convert.ToInt32(DGstd.Rows[i].Cells[6].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no, material_desc, requirement_qty, price FROM t_stdstock_detail where id_stdstock_header = '"+ id +"'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    DGstd_det.DataSource = ds;
                    DGstd_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = DGstd_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            oIT.Lines.ItemCode = DGstd_det.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemDescription = DGstd_det.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(DGstd_det.Rows[a].Cells[2].Value);
                            oIT.Lines.Price = Convert.ToDouble(DGstd_det.Rows[a].Cells[3].Value);
                            if (a < max - 1)
                            {
                                oIT.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);
                        
                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updateSQL4(key, id);

                        }
                    }
                    i += 1;
                }while(i < count);
               
            }
        } 

        void non_std()
        {
            DateTime DT = DateTime.Now;
            string module = "Non Standart Stock";
            SAPbobsCOM.Documents oIT;
            oIT = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oPurchaseRequest);

            int i = 0;
            int count = DGst1.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.DocDate = Convert.ToDateTime(DGst1.Rows[i].Cells[3].Value);
                    //oIT.DocDueDate = Convert.ToDateTime(DGst1.Rows[i].Cells[3].Value);
                    oIT.RequriedDate = Convert.ToDateTime(DGst1.Rows[i].Cells[3].Value);
                    oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                    int id = Convert.ToInt32(DGst1.Rows[i].Cells[5].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no, material_desc, requirement_qty,delivery_date, price "+
                    "FROM t_nonstdstock_detail where id_nonstdstock_header = '" + id + "'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    DGst2.DataSource = ds;
                    DGst2.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = DGst2.Rows.Count - 1;
                    oIT.DocDueDate = Convert.ToDateTime(DGst2.Rows[i].Cells[3].Value);
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            oIT.Lines.ItemCode = DGst2.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemDescription = DGst2.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(DGst2.Rows[a].Cells[2].Value);
                            oIT.Lines.Price = Convert.ToDouble(DGst2.Rows[a].Cells[4].Value);
                            oIT.Lines.RequiredDate = Convert.ToDateTime(DGst1.Rows[i].Cells[3].Value);
                            if (a < max - 1)
                            {
                                oIT.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);
                        
                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updateSQL5(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // Purchase Request (ngga usah dikerjain)

        void gisto()
        {
            DateTime DT = DateTime.Now;
            string module = "Good Issue Stock Transfer";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oStockTransfer);
            SAPbobsCOM.BatchNumbers oBN;
           
            int i = 0;
            int count = dgsInvtTransGIHd.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.DocDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value);
                    oIT.FromWarehouse = dgsInvtTransGIHd.Rows[i].Cells[4].Value.ToString();
                    string receive_plant = dgsInvtTransGIHd.Rows[i].Cells[6].Value.ToString();
        /*================================================================================================================================================== */
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = SAPDb;
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT WhsCode FROM OWHS WHERE U_TransFor = '" + receive_plant + "'  ";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    DgWH.DataSource = dataTable2;
                    string transit = DgWH.Rows[0].Cells[0].Value.ToString();
/*============================================================================================================================================================ */
                    oIT.ToWarehouse =transit;
                    oIT.Address = dgsInvtTransGIHd.Rows[i].Cells[0].Value.ToString() + ", " + dgsInvtTransGIHd.Rows[i].Cells[1].Value.ToString() + ", " + dgsInvtTransGIHd.Rows[i].Cells[2].Value.ToString();
                   /* oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                    oIT.DocDueDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value);
                    oIT.RequriedDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value); */
                    
                    int id = Convert.ToInt32(dgsInvtTransGIHd.Rows[i].Cells[5].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,id_gisto_header,SUM(gr_quantity) FROM t_gisto_detail  WHERE id_gisto_header = '"+  id +"' GROUP BY material_no";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgsInvtTransGIDt.DataSource = ds;
                    dgsInvtTransGIDt.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgsInvtTransGIDt.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            string Item = dgsInvtTransGIDt.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemCode = Item;
                           // oIT.Lines.ItemDescription = dgsInvtTransGIDt.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(dgsInvtTransGIDt.Rows[a].Cells[2].Value);
                            //==========================================================================================================
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND Basetype = '0' ";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch.DataSource = ds1;
                            dgBatch.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oIT.Lines.BatchNumbers.SetCurrentLine(b);
                                        oIT.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                        oIT.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                        oIT.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }
                            
                            if (a < max - 1)
                            {
                                
                                oIT.Lines.Add();
                            }
                            a += 1;
                           
                        } while (a < max);

                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            MessageBox.Show(sErrMsg.ToString());
                            //ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updategisto(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // Good Issue

        void paket()
        {
            DateTime DT = DateTime.Now;
            string module = "Good Issue Paket";
            SAPbobsCOM.Documents oGE;
            oGE = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryGenExit);

            int i = 0;
            int count = DGpkt.Rows.Count - 1;
            if (count != 0)
            {
                do
                {
                    oGE.DocDate = Convert.ToDateTime(DGpkt.Rows[i].Cells[0].Value);
                    oGE.DocDueDate = Convert.ToDateTime(DGpkt.Rows[i].Cells[0].Value);
                    int id = Convert.ToInt32(DGpkt.Rows[i].Cells[2].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT a.material_no, a.material_desc,a.quantity, b.plant FROM t_tpaket_detail_paket a " +
                                        " JOIN t_tpaket_header b ON a.id_tpaket_header = b.id_tpaket_header WHERE a.id_tpaket_header = '"+ id +"' " +
                                        " group by a.material_no, a.material_desc,a.quantity, b.plant";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    DGpkt_det.DataSource = ds;
                    DGpkt_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = DGpkt_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                           // string Item = DGpkt_det.Rows[a].Cells[0].Value.ToString();
                            oGE.Lines.SetCurrentLine(a);
                            oGE.Lines.ItemCode = DGpkt_det.Rows[a].Cells[0].Value.ToString();
                            oGE.Lines.ItemDescription = DGpkt_det.Rows[a].Cells[1].Value.ToString();
                            oGE.Lines.Quantity = Convert.ToDouble(DGpkt_det.Rows[a].Cells[2].Value);
                            oGE.Lines.WarehouseCode = DGpkt_det.Rows[a].Cells[3].Value.ToString();

                            //mulai batchnumber
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT num,quantity,id_tpaket_h_detail_paket FROM  t_tpaket_detail_paket WHERE id_tpaket_header ='" + id + "'  ";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch.DataSource = ds1;
                            dgBatch.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oGE.Lines.BatchNumbers.SetCurrentLine(b);
                                        oGE.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                        oGE.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                        oGE.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }
                            //teko mengkene batchnumber

                            if (a < max - 1)
                            {
                                oGE.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);
                        lRetCode = oGE.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            int key1 = Convert.ToInt32(key);
                            SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                            SQLSERVER2.DataSource = "SVR-S-2012-64";
                            SQLSERVER2.InitialCatalog = "MSI";
                            SQLSERVER2.IntegratedSecurity = false;
                            SQLSERVER2.UserID = "sa";
                            SQLSERVER2.Password = "abc123?";
                            SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                            myconnection2.Open();
                            string selectQueryString2 = "SELECT DocTotal FROM OIGE WHERE DocEntry = '" + key1 + "'";
                            SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                            SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                            DataTable dataTable2 = new DataTable();
                            sqlDataAdapter2.Fill(dataTable2);
                            DGPrice1.DataSource = dataTable2;
                            double price = Convert.ToDouble(DGPrice1.Rows[0].Cells[0].Value);
                            paket_receipt(id, price);
                            
                        }
                    }
                    i += 1;


                } while (i < count);
            }


        } // Good Issue (out)

        void paket_receipt(int id, double price)
        {
            DateTime DT = DateTime.Now;
            string module = "Good Receipt Paket";
            SAPbobsCOM.Documents oGR;
            oGR = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryGenEntry);
            SAPbobsCOM.Items ITM = (SAPbobsCOM.Items)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oItems);

            MySqlConnection conn = new MySqlConnection(konfigurasi);
            conn.Open();
            cmd = new MySqlCommand();
            cmd.Connection = conn;
            cmd.CommandType = CommandType.Text;
            cmd.CommandText = "SELECT posting_date,plant,id_tpaket_header FROM t_tpaket_header WHERE id_tpaket_header = '"+ id +"'";
            ds = new DataSet();
            da = new MySqlDataAdapter(cmd);
            da.Fill(ds, "dt");
            DGpkt_Rec.DataSource = ds;
            DGpkt_Rec.DataMember = "dt";
            oGR.DocDate = Convert.ToDateTime(DGpkt_Rec.Rows[0].Cells[0].Value);
            oGR.DocDueDate = Convert.ToDateTime(DGpkt_Rec.Rows[0].Cells[0].Value);
            cmd.CommandText = "SELECT a.material_no, a.material_desc, a.quantity,b.plant FROM t_tpaket_detail a "+
                                " JOIN t_tpaket_header b ON a.id_tpaket_header = b.id_tpaket_header WHERE a.id_tpaket_header = '"+ id +"'";
            ds = new DataSet();
            da = new MySqlDataAdapter(cmd);
            da.Fill(ds, "di");
            DGpkt_RecDet.DataSource = ds;
            DGpkt_RecDet.DataMember = "di";

            int i = 0;
            int count = DGpkt_RecDet.Rows.Count - 1;
            if (count != 0)
            {
                do
                {
                    string Item = DGpkt_RecDet.Rows[i].Cells[0].Value.ToString();
                    oGR.Lines.SetCurrentLine(i);
                    oGR.Lines.ItemCode = Item;
                    oGR.Lines.ItemDescription = DGpkt_RecDet.Rows[i].Cells[1].Value.ToString();
                    double qty = Convert.ToDouble(DGpkt_RecDet.Rows[i].Cells[2].Value);
                    oGR.Lines.Quantity = qty;
                    double unitPrice = price / qty;
                    oGR.Lines.UnitPrice = 50000;
                    oGR.Lines.WarehouseCode = DGpkt_RecDet.Rows[i].Cells[3].Value.ToString();
                   // oGR.Lines.LineTotal = price;
                  
                    //mulai batchnumber
                    cmd1 = new MySqlCommand();
                    cmd1.Connection = conn;
                    cmd1.CommandType = CommandType.Text;
                    cmd1.CommandText = "SELECT num,quantity,id_tpaket_h_detail FROM  t_tpaket_detail WHERE id_tpaket_header ='" + id + "' ";
                    ds1 = new DataSet();
                    da1 = new MySqlDataAdapter(cmd1);
                    da1.Fill(ds1, "dt");
                    dgBatch2.DataSource = ds1;
                    dgBatch2.DataMember = "dt";
                    conn.Close();
                    int b = 0;
                    int hit = dgBatch2.Rows.Count - 1;
                    if (hit > 0)
                    {
                        do
                        {
                            if (dgBatch2.Rows[b].Cells[0].Value.ToString() != "")
                            {
                              //  if (ITM.GetByKey(Item))
                               // {
                                    oGR.Lines.BatchNumbers.SetCurrentLine(b);
                                    oGR.Lines.BatchNumbers.BatchNumber = dgBatch2.Rows[b].Cells[0].Value.ToString();
                                    oGR.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch2.Rows[b].Cells[1].Value);
                                    oGR.Lines.BatchNumbers.BaseLineNumber = b;
                                    oGR.Lines.BatchNumbers.Add();
                               // }
                            }
                            b += 1;
                        } while (b < hit);
                    }
                    //teko mengkene batchnumber

                    if (i < count - 1)
                    {
                        oGR.Lines.Add();
                    }
                    i += 1;
                } while (i < count);
                lRetCode = oGR.Add();
                oCompany.GetLastError(out lErrCode, out sErrMsg);
                if (lRetCode != 0)
                {
                    ErrorLog(id, module, sErrMsg, DT);
                }
                else
                {
                    string key = oCompany.GetNewObjectKey();
                    updatepaket(key, id);
                    updatepaketRec(key, id);
                }

            }

        } // Good Receipt (in)

        void grsto()
        {
            DateTime DT = DateTime.Now;
            string module = "Good Receipt Antar Plant";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oStockTransfer);

            int i = 0;
            int count = dgSTO.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.Address = dgSTO.Rows[i].Cells[0].Value.ToString() + ", " + dgSTO.Rows[i].Cells[1].Value.ToString() + ", " + dgSTO.Rows[i].Cells[2].Value.ToString();
                    oIT.DocDate = Convert.ToDateTime(dgSTO.Rows[i].Cells[4].Value);

                    oIT.FromWarehouse = dgSTO.Rows[i].Cells[5].Value.ToString();
                    oIT.ToWarehouse = "TSentul";
                    int id = Convert.ToInt32(dgSTO.Rows[i].Cells[7].Value);
                    int baseEntry = Convert.ToInt32(dgSTO.Rows[i].Cells[6].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,id_gisto_header,SUM(gr_quantity) FROM t_gisto_detail  WHERE id_gisto_header = '" + id + "' GROUP BY material_no";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgSTO_det.DataSource = ds;
                    dgSTO_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgSTO_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            string Item = dgSTO_det.Rows[a].Cells[0].Value.ToString();
                           // oIT.Lines.BaseType = SAPbobsCOM.InvBaseDocTypeEnum.InventoryTransferRequest;
                           // oIT.Lines.BaseEntry = baseEntry;
                            //oIT.Lines.BaseLine = Convert.ToInt32(dgSTO_det.Rows[a].Cells[0].Value) - 1;
                            oIT.Lines.ItemCode = Item;
                            //oIT.Lines.ItemDescription = dgSTO_det.Rows[a].Cells[2].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(dgSTO_det.Rows[a].Cells[3].Value);
                            //mulai batchnumber
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND Basetype = '1' ";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch.DataSource = ds1;
                            dgBatch.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oIT.Lines.BatchNumbers.SetCurrentLine(b);
                                        oIT.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                        oIT.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                        oIT.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            } 
                            //teko mengkene batchnumber
                            if (a < max - 1)
                            {
                                oIT.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);

                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                           // ErrorLog(id, module, sErrMsg, DT);
                            MessageBox.Show(sErrMsg.ToString());
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updategrsto(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // inventory transfer

        void grsto_sd()
        {
            DateTime DT = DateTime.Now;
            string module = "Good Issue Stock Transfer";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oStockTransfer);
            SAPbobsCOM.BatchNumbers oBN;

            int i = 0;
            int count = dgSTO.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.DocDate = Convert.ToDateTime(dgSTO.Rows[i].Cells[4].Value);
                    string receive_plant = dgSTO.Rows[i].Cells[5].Value.ToString();
                    /*================================================================================================================================================== */
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = SAPDb;
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT WhsCode FROM OWHS WHERE U_TransFor = '" + receive_plant + "'  ";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    DgWH.DataSource = dataTable2;
                    string transit = DgWH.Rows[0].Cells[0].Value.ToString();
                    /*============================================================================================================================================================ */
                    oIT.FromWarehouse = transit;
                    oIT.ToWarehouse = dgSTO.Rows[i].Cells[3].Value.ToString();
                    oIT.Address = dgSTO.Rows[i].Cells[0].Value.ToString() + ", " + dgSTO.Rows[i].Cells[1].Value.ToString() + ", " + dgSTO.Rows[i].Cells[2].Value.ToString();
                    /* oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                     oIT.DocDueDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value);
                     oIT.RequriedDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value); */

                    int id = Convert.ToInt32(dgSTO.Rows[i].Cells[7].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,id_grsto_header,SUM(gr_quantity) FROM t_grsto_detail  WHERE id_grsto_header = '" + id + "' GROUP BY material_no";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgSTO_det.DataSource = ds;
                    dgSTO_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgSTO_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            string Item = dgSTO_det.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemCode = Item;
                           // oIT.Lines.ItemDescription = dgsInvtTransGIDt.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(dgSTO_det.Rows[a].Cells[2].Value);
                            //==========================================================================================================
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "'  AND Basetype = '1'";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch1.DataSource = ds1;
                            dgBatch1.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch1.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch1.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oIT.Lines.BatchNumbers.SetCurrentLine(b);
                                        oIT.Lines.BatchNumbers.BatchNumber = dgBatch1.Rows[b].Cells[0].Value.ToString();
                                        oIT.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch1.Rows[b].Cells[1].Value);
                                        oIT.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }

                            if (a < max - 1)
                            {

                                oIT.Lines.Add();
                            }
                            a += 1;

                        } while (a < max);

                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            MessageBox.Show(sErrMsg.ToString());
                            //ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updategrsto(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // inventory transfer

        void grpodlv()
        {
            DateTime DT = DateTime.Now;
            string module = "GR PO With Deliver";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oStockTransfer);
            SAPbobsCOM.BatchNumbers oBN;

            int i = 0;
            int count = dgGRPODel.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.DocDate = Convert.ToDateTime(dgGRPODel.Rows[i].Cells[4].Value);
                    string transit_plant = dgGRPODel.Rows[i].Cells[3].Value.ToString();
                    /*================================================================================================================================================== */
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = SAPDb;
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT  U_TransFor FROM OWHS WHERE WhsCode ='" + transit_plant + "'";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    DgWH.DataSource = dataTable2;
                    string receive_plant = DgWH.Rows[0].Cells[0].Value.ToString();
                    /*============================================================================================================================================================ */
                    oIT.FromWarehouse = dgGRPODel.Rows[i].Cells[3].Value.ToString();
                    oIT.ToWarehouse = receive_plant;
                    oIT.Address = dgGRPODel.Rows[i].Cells[0].Value.ToString() + ", " + dgGRPODel.Rows[i].Cells[1].Value.ToString() + ", " + dgGRPODel.Rows[i].Cells[2].Value.ToString();
                    /* oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                     oIT.DocDueDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value);
                     oIT.RequriedDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value); */

                    int id = Convert.ToInt32(dgGRPODel.Rows[i].Cells[5].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,id_grpodlv_header,SUM(gr_quantity) FROM t_grpodlv_detail  WHERE id_grpodlv_header = '" + id + "' GROUP BY material_no";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "pt");
                    dgGRPODel_det.DataSource = ds;
                    dgGRPODel_det.DataMember = "pt";
                    conn.Close();
                    int a = 0;
                    int max = dgGRPODel_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            string Item = dgGRPODel_det.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemCode = Item;
                            // oIT.Lines.ItemDescription = dgsInvtTransGIDt.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(dgGRPODel_det.Rows[a].Cells[2].Value);
                            //==========================================================================================================
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "'  AND Basetype = '67'";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch1.DataSource = ds1;
                            dgBatch1.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch1.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch1.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oIT.Lines.BatchNumbers.SetCurrentLine(b);
                                        oIT.Lines.BatchNumbers.BatchNumber = dgBatch1.Rows[b].Cells[0].Value.ToString();
                                        oIT.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch1.Rows[b].Cells[1].Value);
                                        oIT.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }

                            if (a < max - 1)
                            {

                                oIT.Lines.Add();
                            }
                            a += 1;

                        } while (a < max);

                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            MessageBox.Show(sErrMsg.ToString());
                            //ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updategrsto(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // inventory transfer

        void grpodlv_dept()
        {
            DateTime DT = DateTime.Now;
            string module = "GR PO Departement";
            SAPbobsCOM.IStockTransfer oIT;
            oIT = (SAPbobsCOM.IStockTransfer)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oStockTransfer);
            SAPbobsCOM.BatchNumbers oBN;

            int i = 0;
            int count = dgGRPO_dept.Rows.Count - 1;
            if (count != 0)
            {

                do
                {
                    oIT.DocDate = Convert.ToDateTime(dgGRPODel.Rows[i].Cells[4].Value);
                    string transit_plant = dgGRPO_dept.Rows[i].Cells[3].Value.ToString();
                    /*================================================================================================================================================== */
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = SAPDb;
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT  U_TransFor FROM OWHS WHERE WhsCode ='" + transit_plant + "'";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    DgWH.DataSource = dataTable2;
                    string receive_plant = DgWH.Rows[0].Cells[0].Value.ToString();
                    /*============================================================================================================================================================ */
                    oIT.FromWarehouse = dgGRPO_dept.Rows[i].Cells[3].Value.ToString();
                    oIT.ToWarehouse = receive_plant;
                    oIT.Address = dgGRPO_dept.Rows[i].Cells[0].Value.ToString() + ", " + dgGRPO_dept.Rows[i].Cells[1].Value.ToString() + ", " + dgGRPO_dept.Rows[i].Cells[2].Value.ToString();
                    /* oIT.DocType = SAPbobsCOM.BoDocumentTypes.dDocument_Items;
                     oIT.DocDueDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value);
                     oIT.RequriedDate = Convert.ToDateTime(dgsInvtTransGIHd.Rows[i].Cells[3].Value); */

                    int id = Convert.ToInt32(dgGRPO_dept.Rows[i].Cells[5].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,id_grpodlv_dept_header,SUM(gr_quantity) FROM t_grpodlv_dept_detail  WHERE id_grpodlv_dept_header = '" + id + "' GROUP BY material_no";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "pt");
                    dgGRPO_dept_det.DataSource = ds;
                    dgGRPO_dept_det.DataMember = "pt";
                    conn.Close();
                    int a = 0;
                    int max = dgGRPO_dept_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            oIT.Lines.SetCurrentLine(a);
                            string Item = dgGRPO_dept_det.Rows[a].Cells[0].Value.ToString();
                            oIT.Lines.ItemCode = Item;
                            // oIT.Lines.ItemDescription = dgsInvtTransGIDt.Rows[a].Cells[1].Value.ToString();
                            oIT.Lines.Quantity = Convert.ToDouble(dgGRPO_dept_det.Rows[a].Cells[2].Value);
                            //==========================================================================================================
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "'  AND Basetype = '67'";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch1.DataSource = ds1;
                            dgBatch1.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch1.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch1.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oIT.Lines.BatchNumbers.SetCurrentLine(b);
                                        oIT.Lines.BatchNumbers.BatchNumber = dgBatch1.Rows[b].Cells[0].Value.ToString();
                                        oIT.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch1.Rows[b].Cells[1].Value);
                                        oIT.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }

                            if (a < max - 1)
                            {

                                oIT.Lines.Add();
                            }
                            a += 1;

                        } while (a < max);

                        lRetCode = oIT.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            MessageBox.Show(sErrMsg.ToString());
                            //ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            updategrsto(key, id);

                        }
                    }
                    i += 1;
                } while (i < count);

            }
        } // inventory transfer departement

        void inv_count1()
        {
            DateTime DT = DateTime.Now;
            string module = "Stock Counting Opname";
            int count = dgCount.Rows.Count - 1;
            int i = 0;
            do
            {
                int id = Convert.ToInt32(dgCount.Rows[i].Cells[1].Value);
                try
                {
                    SAPbobsCOM.CompanyService oCS = oCompany.GetCompanyService();
                    SAPbobsCOM.InventoryCountingsService oICS = oCS.GetBusinessService(SAPbobsCOM.ServiceTypes.InventoryCountingsService);
                    SAPbobsCOM.InventoryCounting oIC = oICS.GetDataInterface(SAPbobsCOM.InventoryCountingsServiceDataInterfaces.icsInventoryCounting) as SAPbobsCOM.InventoryCounting;
                    oIC.CountDate = Convert.ToDateTime(dgCount.Rows[i].Cells[0].Value);

                    SAPbobsCOM.InventoryCountingLines oICLS = oIC.InventoryCountingLines;

                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,  quantity, t_stockoutlet_header.plant FROM t_stockoutlet_detail " +
                                       " JOIN t_stockoutlet_header ON t_stockoutlet_detail.id_stockoutlet_header = t_stockoutlet_header.id_stockoutlet_header " +
                                       " WHERE t_stockoutlet_detail.id_stockoutlet_header = '" + id + "'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgCount_det.DataSource = ds;
                    dgCount_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgCount_det.Rows.Count - 1;

                    do
                    {
                        string Item = dgCount_det.Rows[a].Cells[0].Value.ToString();
                        SAPbobsCOM.InventoryCountingLine oICL = oICLS.Add();
                        oICL.ItemCode = dgCount_det.Rows[a].Cells[0].Value.ToString();
                        oICL.CountedQuantity = Convert.ToDouble(dgCount_det.Rows[a].Cells[1].Value);
                        oICL.WarehouseCode = dgCount_det.Rows[a].Cells[2].Value.ToString();
                        oICL.Counted = SAPbobsCOM.BoYesNoEnum.tYES;
                       
                        //mulai batchnumber
                        cmd1 = new MySqlCommand();
                        cmd1.Connection = conn;
                        cmd1.CommandType = CommandType.Text;
                       // cmd1.CommandText = "SELECT num,Quantity,id_stockoutlet_h_detail FROM t_stockoutlet_detail WHERE id_stockoutlet_header ='" + id + "' AND ItemCode = '" + Item + "' ";
                        ds1 = new DataSet();
                        da1 = new MySqlDataAdapter(cmd1);
                        da1.Fill(ds1, "dt");
                        dgBatch.DataSource = ds1;
                        dgBatch.DataMember = "dt";
                        conn.Close();
                        int b = 0;
                        int hit = dgBatch.Rows.Count - 1;
                        if (hit > 0)
                        {
                            do
                            {
                                if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                {
                                    /*oICL.BatchNumbers.SetCurrentLine(b);
                                    oICL.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                    oICL.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                    oICL.Lines.BatchNumbers.Add();*/
                                }
                                b += 1;
                            } while (b < hit);
                        }
                        //teko mengkene batchnumber

                        a += 1;
                    } while (a < max);
                    SAPbobsCOM.InventoryCountingParams oICP = oICS.Add(oIC);
                }
                catch (Exception Ex)
                {
                    ErrorLog(id, module, sErrMsg, DT);
                }
                finally
                {
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = "MSI";
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT MAX(DocEntry) FROM OINC";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    dgDoc.DataSource = dataTable2;
                    string key = dgDoc.Rows[0].Cells[0].Value.ToString();
                    updateCounting(key, id);
                }
            i += 1;
            }while(i < count);
        } // inventory counting (Opname)


        void inv_count2()
        {
            DateTime DT = DateTime.Now;
            string module = "Stock Posting Opname";
            int count = dgCount.Rows.Count - 1;
            int i = 0;
            do
            {
                int id = Convert.ToInt32(dgCount.Rows[i].Cells[1].Value);
                try
                {
                    SAPbobsCOM.CompanyService oCS = oCompany.GetCompanyService();
                    SAPbobsCOM.InventoryPostingsService oICS = oCS.GetBusinessService(SAPbobsCOM.ServiceTypes.InventoryPostingsService);
                    SAPbobsCOM.InventoryPosting oIC = oICS.GetDataInterface(SAPbobsCOM.InventoryPostingsServiceDataInterfaces.ipsInventoryPosting) as SAPbobsCOM.InventoryPosting;
                    oIC.CountDate = Convert.ToDateTime(dgCount.Rows[i].Cells[0].Value);

                    SAPbobsCOM.InventoryPostingLines oICLS = oIC.InventoryPostingLines;

                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,  quantity, t_stockoutlet_header.plant FROM t_stockoutlet_detail " +
                                       " JOIN t_stockoutlet_header ON t_stockoutlet_detail.id_stockoutlet_header = t_stockoutlet_header.id_stockoutlet_header " +
                                       " WHERE t_stockoutlet_detail.id_stockoutlet_header = '" + id + "'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgCount_det.DataSource = ds;
                    dgCount_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgCount_det.Rows.Count - 1;

                    do
                    {
                        string Item = dgCount_det.Rows[a].Cells[0].Value.ToString();
                        SAPbobsCOM.InventoryPostingLine oICL = oICLS.Add();
                        oICL.ItemCode = dgCount_det.Rows[a].Cells[0].Value.ToString();
                        oICL.CountedQuantity = Convert.ToDouble(dgCount_det.Rows[a].Cells[1].Value);
                        oICL.WarehouseCode = dgCount_det.Rows[a].Cells[2].Value.ToString();
                        //oICL.Counted = SAPbobsCOM.BoYesNoEnum.tYES;

                        //mulai batchnumber
                        cmd1 = new MySqlCommand();
                        cmd1.Connection = conn;
                        cmd1.CommandType = CommandType.Text;
                        cmd1.CommandText = "SELECT num,Quantity,id_stockoutlet_h_detail FROM t_stockoutlet_detail WHERE id_stockoutlet_header ='" + id + "' AND material_no = '" + Item + "' ";
                        ds1 = new DataSet();
                        da1 = new MySqlDataAdapter(cmd1);
                        da1.Fill(ds1, "dt");
                        dgBatch.DataSource = ds1;
                        dgBatch.DataMember = "dt";

                        conn.Close();
                        int b = 0;
                        int hit = dgBatch.Rows.Count - 1;
                        if (hit > 0)
                        {
                            do
                            {

                                if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                {
                                    SAPbobsCOM.InventoryPostingBatchNumber oICLB = oICL.InventoryPostingBatchNumbers.Add();
                                    //oICLB.BatchNumber;
                                    oICLB.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                    oICLB.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);           
                                }
                                b += 1;
                            } while (b < hit);
                        }
                        //teko mengkene batchnumber

                        a += 1;
                    } while (a < max);
                    SAPbobsCOM.InventoryPostingParams oICP = oICS.Add(oIC);
                }
                catch (Exception Ex)
                {
                    ErrorLog(id, module, sErrMsg, DT);
                }
                finally
                {
                    SqlConnectionStringBuilder SQLSERVER2 = new SqlConnectionStringBuilder();
                    SQLSERVER2.DataSource = "SVR-S-2012-64";
                    SQLSERVER2.InitialCatalog = "MSI";
                    SQLSERVER2.IntegratedSecurity = false;
                    SQLSERVER2.UserID = "sa";
                    SQLSERVER2.Password = "abc123?";
                    SqlConnection myconnection2 = new SqlConnection(SQLSERVER2.ConnectionString);
                    myconnection2.Open();
                    string selectQueryString2 = "SELECT MAX(DocEntry) FROM OINC";
                    SqlDataAdapter sqlDataAdapter2 = new SqlDataAdapter(selectQueryString2, myconnection2);
                    SqlCommandBuilder sqlCommandBuilder2 = new SqlCommandBuilder(sqlDataAdapter2);
                    DataTable dataTable2 = new DataTable();
                    sqlDataAdapter2.Fill(dataTable2);
                    dgDoc.DataSource = dataTable2;
                    string key = dgDoc.Rows[0].Cells[0].Value.ToString();
                    updateCounting(key, id);
                }
                i += 1;
            } while (i < count);
        } // inventory Posting (Opname)

        void gr_waste()
        {
            DateTime DT = DateTime.Now;
            string module = "Good Issue Waste";
            SAPbobsCOM.Documents oGE;
            oGE = (SAPbobsCOM.Documents)oCompany.GetBusinessObject(SAPbobsCOM.BoObjectTypes.oInventoryGenExit);

            int i = 0;
            int count = dgWaste.Rows.Count - 1;
            if (count != 0)
            {
                do
                {
                    oGE.DocDate = Convert.ToDateTime(dgWaste.Rows[i].Cells[0].Value);
                    oGE.DocDueDate = Convert.ToDateTime(dgWaste.Rows[i].Cells[0].Value);
                    oGE.Comments = "Good Issue from Waste";
                    int id = Convert.ToInt32(dgWaste.Rows[i].Cells[1].Value);
                    /** START CONECTION MYSQL **/
                    MySqlConnection conn = new MySqlConnection(konfigurasi);
                    conn.Open();
                    cmd = new MySqlCommand();
                    cmd.Connection = conn;
                    cmd.CommandType = CommandType.Text;
                    cmd.CommandText = "SELECT material_no,material_desc,quantity,t_waste_header.plant FROM t_waste_detail " +
                                        " JOIN t_waste_header ON t_waste_detail.id_waste_header= t_waste_header.id_waste_header "+
                                        " WHERE t_waste_detail.id_waste_header = '"+ id+"'";
                    ds = new DataSet();
                    da = new MySqlDataAdapter(cmd);
                    da.Fill(ds, "dt");
                    dgWaste_det.DataSource = ds;
                    dgWaste_det.DataMember = "dt";
                    conn.Close();
                    int a = 0;
                    int max = dgWaste_det.Rows.Count - 1;
                    if (max != 0)
                    {
                        do
                        {
                            string Item = dgWaste_det.Rows[a].Cells[0].Value.ToString();
                            oGE.Lines.SetCurrentLine(a);
                            oGE.Lines.ItemCode = dgWaste_det.Rows[a].Cells[0].Value.ToString();
                            oGE.Lines.ItemDescription = dgWaste_det.Rows[a].Cells[1].Value.ToString();
                            oGE.Lines.Quantity = Convert.ToDouble(dgWaste_det.Rows[a].Cells[2].Value);
                            oGE.Lines.WarehouseCode = dgWaste_det.Rows[a].Cells[3].Value.ToString();

                            //mulai batchnumber
                            cmd1 = new MySqlCommand();
                            cmd1.Connection = conn;
                            cmd1.CommandType = CommandType.Text;
                            cmd1.CommandText = "SELECT BatchNum,Quantity,BaseLinNum FROM t_batch WHERE BaseEntry ='" + id + "' AND ItemCode = '" + Item + "' AND Basetype = '2' ";
                            ds1 = new DataSet();
                            da1 = new MySqlDataAdapter(cmd1);
                            da1.Fill(ds1, "dt");
                            dgBatch.DataSource = ds1;
                            dgBatch.DataMember = "dt";
                            conn.Close();
                            int b = 0;
                            int hit = dgBatch.Rows.Count - 1;
                            if (hit > 0)
                            {
                                do
                                {
                                    if (dgBatch.Rows[b].Cells[0].Value.ToString() != "")
                                    {
                                        oGE.Lines.BatchNumbers.SetCurrentLine(b);
                                        oGE.Lines.BatchNumbers.BatchNumber = dgBatch.Rows[b].Cells[0].Value.ToString();
                                        oGE.Lines.BatchNumbers.Quantity = Convert.ToDouble(dgBatch.Rows[b].Cells[1].Value);
                                        oGE.Lines.BatchNumbers.Add();
                                    }
                                    b += 1;
                                } while (b < hit);
                            }
                            //teko mengkene batchnumber

                            if (a < max - 1)
                            {
                                oGE.Lines.Add();
                            }
                            a += 1;
                        } while (a < max);
                        lRetCode = oGE.Add();
                        oCompany.GetLastError(out lErrCode, out sErrMsg);
                        if (lRetCode != 0)
                        {
                            ErrorLog(id, module, sErrMsg, DT);
                        }
                        else
                        {
                            string key = oCompany.GetNewObjectKey();
                            
                            updateWaste(key, id);
                        }
                    }
                    i += 1;

                } while (i < count);
            }
            
        } // good issue

        void SAPall()
        {
      // grpodlv();
        grpodlv_dept();
        //gr_PO();
        //grnon_PO();
        //TWTS();
        //inv_trf_req();
        //non_std();
        //grsto();
        //grsto_sd();
        //gisto();
        //paket(); 
        //error_header();
        //countError();
        //inv_count1();
        //gr_waste();
        //inv_count2();
        }

        void countError()
        {
            MySqlConnection conn = new MySqlConnection(konfigurasi);
            conn.Open();
            cmd = new MySqlCommand();
            cmd.Connection = conn;
            cmd.CommandType = CommandType.Text;
            cmd.CommandText = "SELECT * FROM  error_log";
            ds = new DataSet();
            da = new MySqlDataAdapter(cmd);
            da.Fill(ds, "dt");
            dgErorLog.DataSource = ds;
            dgErorLog.DataMember = "dt";
            conn.Close();

            int max = dgErorLog.Rows.Count - 1;
            label3.Text = max.ToString();
        
        } // nangkep jumlah error

        public void ErrorLog(int ID, string module,  string sErrMsg,DateTime DT)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("insert into error_log(id_trans,modul,message,time_error) values(@id_trans,@modul,@message,@time_error)", con);
                con.Open();
                cmd.Parameters.AddWithValue("@id_trans", ID);
                cmd.Parameters.AddWithValue("@modul", module);
                cmd.Parameters.AddWithValue("@message", sErrMsg);
                cmd.Parameters.AddWithValue("@time_error", DT);
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        } //nangkep error

        public void updateSQL(string grpo_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_grpo_header SET grpo_no = '"+ grpo_no +"' where id_grpo_header ='"+ id +"'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateSQL1(string grpo_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_grnonpo_header SET grnonpo_no = '" + grpo_no + "' where id_grnonpo_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateSQL2(string gr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_twts_header SET gi_no = '" + gr_no + "' where id_twts_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateSQL3(string gr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_twts_header SET gr_no = '" + gr_no + "' where id_twts_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateSQL4(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_stdstock_header SET pr_no = '" + pr_no + "' where id_stdstock_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateSQL5(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_nonstdstock_header SET pr_no = '" + pr_no + "' where id_nonstdstock_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updategisto(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_gisto_header SET gisto_no = '" + pr_no + "' where id_gisto_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updatepaket(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_tpaket_header SET material_doc_no_out = '" + pr_no + "' where id_tpaket_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updatepaketRec(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_tpaket_header SET material_doc_no = '" + pr_no + "' where id_tpaket_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updategrsto(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_grsto_header SET grsto_no = '" + pr_no + "' where id_grsto_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateCounting(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_stockoutlet_header SET material_doc_no = '" + pr_no + "' where id_stockoutlet_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void updateWaste(string pr_no, int id)
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("UPDATE t_waste_header SET material_doc_no = '" + pr_no + "' where id_waste_header ='" + id + "'", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void deleteAll()
        {
            try
            {
                MySqlConnection con = new MySqlConnection(konfigurasi);
                cmd = new MySqlCommand("DELETE FROM error_log", con);
                con.Open();
                cmd.ExecuteNonQuery();
                con.Close();
            }
            catch (Exception r)
            {
                MessageBox.Show(r.ToString());
            }
        }

        public void SplashScreen()
        {
            Application.Run(new Form1());
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            // TODO: This line of code loads data into the 'sap_phpDataSet.error_log' table. You can move, or remove it, as needed.
            //this.error_logTableAdapter.Fill(this.sap_phpDataSet.error_log);
            GRPO_header();
            grpodeliver_header();
            grpodeliver_dept_header();
            GRPO_nonheader();
            TWTS_header();
            stdstock_header();
            nonstdstock_header();
            gisto_header();
            paket_header();
            grsto_header();
            invCounted_header();
            waste_header();
            konSAP();
            SAPall();
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            
        }

        private void button1_Click(object sender, EventArgs e)
        {
            DialogResult dialogResult = MessageBox.Show("Are you sure ?", "Delete Confirmation", MessageBoxButtons.YesNo);
            if (dialogResult == DialogResult.Yes)
            {
                //do something
                deleteAll();
                dgErorLog.Refresh();
                error_header();
                countError();
            }
            else if (dialogResult == DialogResult.No)
            {
                //do something else
            }
            
        }
    }
}
