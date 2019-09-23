using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;

namespace InvStc
{
    class grpodeliver
    {
        public MySqlCommand perintah, perintah1 = null;
        public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
        public MySqlConnection koneksi = new MySqlConnection();

        public grpodeliver()
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
                    perintah.CommandText = "SELECT b.address,b.post_code,b.city,a.plant,posting_date,a.id_grpodlv_header FROM  t_grpodlv_header a " +
                                            " JOIN m_outlet b ON a.plant = b.outlet WHERE a.status = 2 and (a.grpodlv_no ='' or a.grpodlv_no is null) order by a.id_grpodlv_header desc";
                    MySqlDataAdapter mdap = new MySqlDataAdapter(perintah);
                    mdap.Fill(ds, "pd");
                  
                koneksi.Close();
            }
            catch (MySqlException)
            {
            }
            return ds;
        }
    }
}
