using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Microsoft.VisualBasic;
using MySql.Data.MySqlClient;

namespace InvStc
{
    class paket
    {
        public MySqlCommand perintah, perintah1 = null;
        public string konfigurasi = "Server=localhost;Port=3306;UID=root;PWD=;Database=sap_php";
        public MySqlConnection koneksi = new MySqlConnection();

        public paket()
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
                    perintah.CommandText = "SELECT posting_date,plant,id_tpaket_header FROM t_tpaket_header " +
                                         " WHERE (material_doc_no = '' or material_doc_no is null) and (material_doc_no_out ='' or material_doc_no_out is null) and status = 2 ";
                    MySqlDataAdapter mdap = new MySqlDataAdapter(perintah);
                    mdap.Fill(ds, "tt");
                  
                koneksi.Close();
            }
            catch (MySqlException)
            {
            }
            return ds;
        }
    }
}
