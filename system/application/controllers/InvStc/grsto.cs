using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;

namespace InvStc
{
    class grsto
    {
        public MySqlCommand perintah, perintah1 = null;
        public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
        public MySqlConnection koneksi = new MySqlConnection();

        public grsto()
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
                    perintah.CommandText = "SELECT b.address,b.post_code,b.city,a.plant,a.delivery_date,a.delivery_plant,a.no_doc_gist,a.id_grsto_header FROM t_grsto_header a " +
                                            " JOIN m_outlet b ON a.plant = b.outlet WHERE a.status = 2 and (a.grsto_no ='' or a.grsto_no is null) order by a.id_grsto_header desc";
                    MySqlDataAdapter mdap = new MySqlDataAdapter(perintah);
                    mdap.Fill(ds, "ts");
                  
                koneksi.Close();
            }
            catch (MySqlException)
            {
            }
            return ds;
        }
    }
}
