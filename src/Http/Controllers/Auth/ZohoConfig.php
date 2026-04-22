<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Auth;


class ZohoConfig
{

    public static function getAuthUrl($organizationId = null)
    {
        $z_api_url = config('zoho-one.api_base_url');
        $z_current_user_email = config('zoho-one.current_user_email');
        $z_return_url = config('zoho-one.redirect_uri');
        $z_url = config('zoho-one.accounts_url');

        if ($organizationId == null) {
            $client_id = config('zoho-one.client_id');
            $secret_key = config('zoho-one.client_secret');
            $z_oauth_scope = config('zoho-one.oauth_scope');
        } else {
            $client_id = config('zoho-one.client_id_' . $organizationId);
            $secret_key = config('zoho-one.client_secret_' . $organizationId);
            $z_return_url = "$z_return_url/$organizationId";
            $z_oauth_scope = config('zoho-one.oauth_scope_' . $organizationId);
        }

        //info('$z_return_url---');
        //info($z_return_url);

        return "$z_url/oauth/v2/auth?scope=$z_oauth_scope&client_id=$client_id&response_type=code&access_type=offline&redirect_uri=$z_return_url";

    }

}
