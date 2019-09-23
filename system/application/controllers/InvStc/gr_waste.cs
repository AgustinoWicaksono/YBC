using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;

namespace InvStc
{
    class gr_waste
    {
        public MySqlCommand perintah, perintah1 = null;
        public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
        public MySqlConnection koneksi = new MySqlConnection();

        public gr_waste()
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
                perintah.CommandText = "SELECT posting_date,id_waste_header FROM t_waste_header WHERE status = 2 and (material_doc_no = '' or material_doc_no is null)";
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
