using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;

namespace InvStc
{
    class sap_php
    {
        public MySqlCommand perintah, perintah1 = null;
       public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
       public MySqlConnection koneksi = new MySqlConnection();

        public sap_php()
        {
            koneksi.ConnectionString = konfigurasi;
        }

        public DataSet getData()
        {
            DataSet ds = new DataSet();

            try
            {
                    koneksi.Open();
                    perintah = new MySqlCommand();
                    perintah.Connection = koneksi;
                    perintah.CommandType = CommandType.Text;
                    perintah.CommandText = "SELECT GRH.kd_vendor,GRH.nm_vendor,GRH.posting_date,GRH.delivery_date,GRH.id_grpo_header from t_grpo_header GRH " + 
								" JOIN m_outlet o ON GRH.plant = o.OUTLET where (GRH.grpo_no = '' or GRH.grpo_no is null) and GRH.status = 2";
                    MySqlDataAdapter mdap = new MySqlDataAdapter(perintah);
                    mdap.Fill(ds, "ip");
                  
                koneksi.Close();
            }
            catch (MySqlException)
            {
            }
            return ds;
        }



    }

    
}
