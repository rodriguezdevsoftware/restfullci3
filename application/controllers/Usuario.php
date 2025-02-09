<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    var $app    = array();
    var $result = array(
        'result' => array(),
        'error'  => array(
            'status'   => 0,
            'messages' => array()
        )
    ); 

    public function __construct() {
        parent::__construct();
        
        $this->output->set_content_type('application/json');
    }

    public function add()
    {
        ### helpers/app_helper.php ###
        if(verify_authorization($this->result, $this->app))
        {
            if($this->input->server('REQUEST_METHOD') == 'POST')
            {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('name', 'Nome', 'required');
                $this->form_validation->set_rules('user', 'Nome do Usuário', 'required');
                $this->form_validation->set_rules('email', 'E-mail', 'required');
                $this->form_validation->set_rules('pass', 'Senha', 'required');

                if($this->form_validation->run())
                {
                    $this->load->model('usuario_model');

                    $usuario = array(
                        'name' => $this->input->post('name'),
                        'user' => $this->input->post('user'),
                        'email' => $this->input->post('email'),
                        'pass' => $this->input->post('pass')
                    );

                    $id_usuario = $this->usuario_model->add($this->app['id'], $usuario);

                    $this->result['result']['message'] = 'Usuário criado';

                    $this->result['result']['usuario']['id']   = $id_usuario;
                    $this->result['result']['usuario']['name'] = $usuario['name'];
                }
                else
                {
                    $this->result['error']['status'] = 1;

                    foreach($this->form_validation->error_array() as $key => $item)
                    {
                        $this->result['error']['messages'][$key] = form_error($key);
                    }

                }
            }
            else
            {
                $this->result['error']['status']     = 1;
                $this->result['error']['messages'][] = 'Método inválido';
            }
        }
       
        $this->output->set_output(json_encode($this->result));
    }

    public function edit($id)
    {
        ### helpers/app_helper.php ###
        if(verify_authorization($this->result, $this->app))
        {
            if($this->input->server('REQUEST_METHOD') == 'PUT')
            {
                $this->load->model('usuario_model');

                $usuario = $this->usuario_model->get($this->app['id'], $id);

                if(is_array($usuario) AND count($usuario) > 0)
                {
                    parse_str(file_get_contents("php://input"), $post_vars);

                    ### alterado o form_validation para funcion com put também ###
                    $this->load->library('form_validation');

                    $usuario = array(
                        'name'  => $post_vars['name'],
                        'user'  => $post_vars['user'],
                        'email' => $post_vars['email'],
                        'pass'  => $post_vars['pass']
                    );

                    $this->form_validation->set_data($usuario);

                    $this->form_validation->set_rules('name', 'Nome', 'required');
                    $this->form_validation->set_rules('user', 'Nome do Usuário', 'required');
                    $this->form_validation->set_rules('email', 'E-mail', 'required');
                    $this->form_validation->set_rules('pass', 'Senha', 'required');

                    if($this->form_validation->run())
                    {    
                        $this->usuario_model->edit($this->app['id'], $id, $usuario);

                        $this->result['result']['message'] = 'Usuário criado';

                        $this->result['result']['usuario']['id']   = $id;
                        $this->result['result']['usuario']['name'] = $usuario['name'];
                    }
                    else
                    {
                        $this->result['error']['status'] = 1;

                        foreach($this->form_validation->error_array() as $key => $item)
                        {
                            $this->result['error']['messages'][$key] = form_error($key);
                        }
                    }
                }
                else
                {
                    $this->result['error']['status']     = 1;
                    $this->result['error']['messages'][] = 'Usuário não foi encontrado';
                }
                
            }
            else
            {
                $this->result['error']['status']     = 1;
                $this->result['error']['messages'][] = 'Método inválido';
            }
        }
       
        $this->output->set_output(json_encode($this->result));
    }

    public function get($id)
    {
        ### helpers/app_helper.php ###
        if(verify_authorization($this->result, $this->app))
        {
            if($this->input->server('REQUEST_METHOD') == 'GET')
            {
                $this->load->model('usuario_model');

                $usuario = $this->usuario_model->get($this->app['id'], $id);

                $this->result['result']['usuarios'] = $usuario;
            }
            else
            {
                $this->result['error']['status']     = 1;
                $this->result['error']['messages'][] = 'Método inválido';
            }
        }

        $this->output->set_output(json_encode($this->result));
    }

    public function get_all()
    {
        ### helpers/app_helper.php ###
        if(verify_authorization($this->result, $this->app))
        {
            if($this->input->server('REQUEST_METHOD') == 'GET')
            {
                $this->load->model('usuario_model');

                $usuarios = $this->usuario_model->get_all($this->app['id']);

                $this->result['result']['usuarios'] = $usuarios;
            }
            else
            {
                $this->result['error']['status']     = 1;
                $this->result['error']['messages'][] = 'Método inválido';
            }
        }

        $this->output->set_output(json_encode($this->result));
    }

    public function delete($id)
    {
        ### helpers/app_helper.php ###
        if(verify_authorization($this->result, $this->app))
        {
            if($this->input->server('REQUEST_METHOD') == 'DELETE')
            {
                $this->load->model('usuario_model');

                $usuario = $this->usuario_model->get($this->app['id'], $id);

                if(is_array($usuario) AND count($usuario) > 0)
                {
                    $this->usuario_model->delete($this->app['id'], $id);

                    $this->result['result']['message'] = 'Usuário deletado';

                    $this->result['result']['usuario']['id']   = $id;
                    $this->result['result']['usuario']['name'] = $usuario['name'];
                }
                else
                {
                    $this->result['error']['status']     = 1;
                    $this->result['error']['messages'][] = 'Usuário não foi encontrado';
                }
            }
            else
            {
                $this->result['error']['status']     = 1;
                $this->result['error']['messages'][] = 'Método inválido';
            }
        }

        $this->output->set_output(json_encode($this->result));
    }
}
