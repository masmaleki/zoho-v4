<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Auth;


class ZohoConfig
{

    public static function getAuthUrl($organizationId = null)
    {
        $z_api_url = config('zoho-v4.api_base_url');
        $z_current_user_email = config('zoho-v4.current_user_email');
        $z_return_url = config('zoho-v4.redirect_uri');
        $z_url = config('zoho-v4.accounts_url');

        if ($organizationId == null) {
            $client_id = config('zoho-v4.client_id');
            $secret_key = config('zoho-v4.client_secret');
            $z_oauth_scope = config('zoho-v4.oauth_scope');
        } else {
            $client_id = config('zoho-v4.client_id_' . $organizationId);
            $secret_key = config('zoho-v4.client_secret_' . $organizationId);
            $z_return_url = "$z_return_url/$organizationId";
            $z_oauth_scope = config('zoho-v4.oauth_scope_' . $organizationId);
        }

        //info('$z_return_url---');
        //info($z_return_url);

        return "$z_url/oauth/v2/auth?scope=$z_oauth_scope&client_id=$client_id&response_type=code&access_type=offline&redirect_uri=$z_return_url";

    }

}
