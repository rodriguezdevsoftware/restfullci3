<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_model {

    public function add($id_app, $usuario)
    {
        $qr_sql = "
            INSERT INTO usuario 
                 (
                    id_app, 
                    name, 
                    user, 
                    email, 
                    pass, 
                    date_add
                 )  
            VALUES 
                 (
                    ".intval($id_app).", 
                    '".trim($usuario['name'])."', 
                    '".trim($usuario['user'])."', 
                    '".trim($usuario['email'])."', 
                    SHA2('".trim($usuario['pass'])."', 256),  
                    NOW()
                 );";

        $this->db->query($qr_sql);

        $qr_sql = "SELECT LAST_INSERT_ID() AS id_gerado;";

        $usuario = $this->db->query($qr_sql)->row_array();

        return $usuario['id_gerado'];
    }

    public function edit($id_app, $id, $usuario)
    {
        $qr_sql = "
            UPDATE usuario  
               SET name      = '".trim($usuario['name'])."',  
                   user      = '".trim($usuario['user'])."',
                   email     = '".trim($usuario['email'])."',
                   pass      = SHA2('".trim($usuario['pass'])."', 256), 
                   date_edit = NOW()  
             WHERE id_app = ".intval($id_app)."
               AND id     = ".intval($id).";";

        $this->db->query($qr_sql);
    }

    public function get_all($id_app)
    {
        $qr_sql = "
            SELECT id,
                   name,
                   user,
                   email,
                   DATE_FORMAT(date_add, '%d/%m/%Y %H:%i:%s') AS date_add,
                   DATE_FORMAT(date_edit, '%d/%m/%Y %H:%i:%s') AS date_edit 
              FROM usuario  
             WHERE id_app = ".intval($id_app).";";

        return $this->db->query($qr_sql)->result_array();
    }

    public function get($id_app, $id)
    {
        $qr_sql = "
            SELECT id,
                   name,
                   user,
                   email,
                   DATE_FORMAT(date_add, '%d/%m/%Y %H:%i:%s') AS date_add,
                   DATE_FORMAT(date_edit, '%d/%m/%Y %H:%i:%s') AS date_edit 
              FROM usuario  
             WHERE id_app = ".intval($id_app)."
               AND id     = ".intval($id).";";

        return $this->db->query($qr_sql)->row_array();
    }

    public function delete($id_app, $id)
    {
        $qr_sql = "
            DELETE
              FROM usuario  
             WHERE id_app = ".intval($id_app)."
               AND id     = ".intval($id).";";

        $this->db->query($qr_sql);
    }
}