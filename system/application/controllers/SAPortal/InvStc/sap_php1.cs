using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;


namespace InvStc
{
    class sap_php1
    {

        public MySqlCommand perintah, perintah1 = null;
        public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
        public MySqlConnection koneksi = new MySqlConnection();

        public sap_php1()
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
                    perintah.CommandText = "SELECT GRH.posting_date,GRH.id_grnonpo_header from t_grnonpo_header GRH " +
                                            " JOIN m_outlet o ON GRH.plant = o.OUTLET where (GRH.grnonpo_no = '' or GRH.grnonpo_no is null) and GRH.status = 2";
                    MySqlDataAdapter mdap = new MySqlDataAdapter(perintah);
                    mdap.Fill(ds, "is");
                  
                koneksi.Close();
            }
            catch (MySqlException)
            {
            }
            return ds;
        }

    }
}
