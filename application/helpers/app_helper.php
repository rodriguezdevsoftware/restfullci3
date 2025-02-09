<?php defined('BASEPATH') OR exit('No direct script access allowed');

if( ! function_exists('verify_authorization'))
{
    function verify_authorization(&$result, &$app)
    {
        $CI = & get_instance();

        $CI->load->model('app_model');

        $authorization = str_replace('Bearer ', '', $CI->input->get_request_header('Authorization'));

        $app = $CI->app_model->get_app($authorization);

        if(is_array($app) AND count($app) > 0)
        {
            return TRUE;
        }
        else
        {
            $result['error']['status']     = 1;
            $result['error']['messages'][] = 'Authorization inválido ou expirado';

            return FALSE;
        }
    }

}