<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
if (!function_exists('setJsonResponse'))
{
    function setJsonResponse($response)
    {
        $ci =& get_instance();
        $returnResponse = $ci->output
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        return $returnResponse;
    }
}

if (!function_exists('removeEmptyValues'))
{
    /**
     * Remove any elements where the value is empty
     * @param  array $array the array to walk
     * @return array
     */
     function removeEmptyValues(array &$array)
     {
        foreach ($array as $key => &$value) 
        {
            if (is_array($value)) 
            {
                 $value =removeEmptyValues($value);
            }
            if (empty($value)) 
            {
                /**
                 * Remove element if null or empty or set null to empty string
                 */
                //unset($array[$key]);
                $array[$key] = 'empty';
                
                 /**
                 * set base url with image name
                 */
                $change_key = 'profile_picture';
                $image_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/consultme.com/assets/users_images/moto.png";
                $array[$change_key] = $image_url;
            }
        }
        return $array;
    }
}
?>