<?php

use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;
use Aws\Exception\CredentialsException;
use Aws\SecretsManager\SecretsManagerClient;

if (!function_exists('secret')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function secret($key, $default = null)
    {
        $value = fromSecretsManager($key);

        if (empty($value) === false) {
            if ($value === 'null') {
                return null;
            } elseif ($value === 'true') {
                return true;
            } elseif ($value === 'false') {
                return false;
            }

            return $value;
        }

        return env($key, $default);
    }
}

if (!function_exists('fromSecretsManager')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @return mixed
     */
    function fromSecretsManager($key)
    {
        $secretName = 'LARAVEL_SCAFFOLD';

        $client = new SecretsManagerClient([
            'version' => '2017-10-17',
            'region' => 'us-east-2',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID', ''),
                'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
            ],
        ]);

        try {
            $result = $client->getSecretValue(['SecretId' => $secretName]);
        } catch (CredentialsException $e) {
            return '';
        } catch (AwsException $e) {
            $error = $e->getAwsErrorCode();
            $message = $e->getAwsErrorMessage();
            Log::error("$error to secret $secretName: $message");
            return '';
        }

        if (isset($result['SecretString'])) {
            $secretString = $result['SecretString'];
            $secrets = json_decode($secretString, true);
            return $secrets[$key];
        }

        $secretString = base64_decode($result['SecretBinary']);
        $secrets = json_decode($secretString, true);
        return $secrets[$key];
    }
}