<?php

namespace Masmaleki\ZohoAllInOne\Http\Controllers\Records;


use GuzzleHttp\Client;
use Masmaleki\ZohoAllInOne\Http\Controllers\Auth\ZohoTokenCheck;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ZohoSaleOrderController
{
    public static function create($data = [])
    {
        $organization_id = $data['organization_id'] ?? null;
        unset($data['organization_id']);
        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = $data;

        try {
            $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function update($data = [])
    {
        $sales_order_id = $data['id'] ?? null;
        $organization_id = $data['organization_id'] ?? null;
        unset($data['id']);
        unset($data['organization_id']);
        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sales_order_id . '?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = $data;

        try {
            $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function getAll($organization_id, $page = 1, $condition = '')
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders?organization_id=' . $organization_id . '&page=' . $page . $condition;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function getById($sale_order_id, $organization_id = null)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sale_order_id . '?organization_id=' . $organization_id;

        $client = new Client();

        $headers = ['Authorization' => 'Zoho-oauthtoken ' . $token->access_token,];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function getByCustomerId($zoho_customer_id, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders?organization_id=' . $organization_id . '&customer_id=' . $zoho_customer_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function searchByCustomerId($zoho_customer_id, $searchParameter, $organization_id)
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders?&customer_id=' . $zoho_customer_id . '&organization_id=' . $organization_id;

        if ($searchParameter) {
            $apiURL .= '&salesorder_number_contains=' . $searchParameter;
        }

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
        return $responseBody;
    }

    public static function getPDF($sale_order_id, $organization_id)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or organization ID.',
            ];
        }
        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sale_order_id . '?accept=pdf';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers, 'stream' => false]);
            $responseBody = $response->getBody();

            $streamResponse = new StreamedResponse(function () use ($responseBody) {
                while (!$responseBody->eof()) {
                    echo $responseBody->read(1024);
                }
            });

            $streamResponse->headers->set('Content-Type', 'application/pdf');
            $streamResponse->headers->set('Cache-Control', 'no-cache');

            return $streamResponse;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getCRMSaleOrderById($sale_order_id, $fields = null)
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return [
                'data' => [
                    0 => [
                        'code' => 498,
                        'message' => 'Invalid or missing token.',
                        'status' => 'error',
                    ]
                ],
            ];
        }

        $apiURL = $token->api_domain . '/crm/v3/Sales_Orders/' . $sale_order_id;

        if ($fields) {
            $apiURL .= '?fields=' . $fields;
        }

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, ['headers' => $headers]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'data' => [
                    0 => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'status' => 'error',
                    ]
                ],
            ];
        }
        return $responseBody;
    }

    public static function createV6($data = [])
    {

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return [
                'data' => [
                    0 => [
                        'code' => 498,
                        'message' => 'Invalid or missing token.',
                        'status' => 'error',
                    ]
                ],
            ];
        }
        $apiURL = $token->api_domain . '/crm/v6/Sales_Orders';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        try {
            $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'data' => [
                    0 => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'status' => 'error',
                    ]
                ],
            ];
        }
        return $responseBody;
    }

    public static function updateV6($data = [])
    {
        $zoho_sales_order_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return [
                'data' => [
                    0 => [
                        'code' => 498,
                        'message' => 'Invalid or missing token.',
                        'status' => 'error',
                    ]
                ],
            ];
        }
        $apiURL = $token->api_domain . '/crm/v6/Sales_Orders/' . $zoho_sales_order_id;
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_sales_order_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        try {
            $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'data' => [
                    0 => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'status' => 'error',
                    ]
                ],
            ];
        }
        return $responseBody;
    }

    public static function updateV2_1($data = [])
    {
        $zoho_sales_order_id = $data['id'];

        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return [
                'data' => [
                    0 => [
                        'code' => 498,
                        'message' => 'Invalid or missing token.',
                        'status' => 'error',
                    ]
                ],
            ];
        }
        $apiURL = $token->api_domain . '/crm/v2.1/Sales_Orders/' . $zoho_sales_order_id . '';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        if (!isset($data['id'])) {
            $data['id'] = $zoho_sales_order_id;
        }

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        try {
            $response = $client->request('PUT', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $responseBody = [
                'data' => [
                    0 => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'status' => 'error',
                    ]
                ],
            ];
        }
        return $responseBody;
    }

    public static function createCRMSaleOrder($data = [])
    {
        $token = ZohoTokenCheck::getToken();
        if (!$token) {
            return null;
        }
        $apiURL = $token->api_domain . '/crm/v3/Sales_Orders';
        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        $body = [
            'data' => [
                0 => $data
            ]
        ];

        $response = $client->request('POST', $apiURL, ['headers' => $headers, 'body' => json_encode($body)]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
    public static function addAttachment($data = [])
    {
        $sales_order_id = $data['id'] ?? null;
        $organization_id = $data['organization_id'] ?? null;
        $file_path = $data['file_path'] ?? null;

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$sales_order_id || !$organization_id || !$file_path || !file_exists(storage_path('app/assets/' . $file_path))) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or required parameters or file not found.',
            ];
        }


        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sales_order_id . '/attachment?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('POST', $apiURL, [
                'headers' => $headers,
                'multipart' => [
                    [
                        'name' => 'attachment',
                        'contents' => fopen(storage_path('app/assets/' . $file_path), 'r'),
                        'filename' => basename($file_path),
                    ],
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);

            return [
                'code' => $statusCode,
                'response' => $responseBody,
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function deleteAttachment($data = [])
    {
        $sales_order_id = $data['id'] ?? null;
        $organization_id = $data['organization_id'] ?? null;

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$sales_order_id || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or required parameters .',
            ];
        }


        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sales_order_id . '/attachment?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('DELETE', $apiURL, [
                'headers' => $headers,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);

            return [
                'code' => $statusCode,
                'response' => $responseBody,
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function requestApproval($data = [])
    {
        $sales_order_id = $data['id'] ?? null;
        $organization_id = $data['organization_id'] ?? null;

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$sales_order_id || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or required parameters.',
            ];
        }

        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sales_order_id . '/submit?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('POST', $apiURL, [
                'headers' => $headers,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);

            return [
                'code' => $statusCode,
                'response' => $responseBody,
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function getComments($data = [])
    {
        $sales_order_id = $data['id'] ?? null;
        $organization_id = $data['organization_id'] ?? null;

        $token = ZohoTokenCheck::getToken();
        if (!$token || !$sales_order_id || !$organization_id) {
            return [
                'code' => 498,
                'message' => 'Invalid/missing token or required parameters.',
            ];
        }

        $apiURL = config('zoho-one.books_api_base_url') . '/books/v3/salesorders/' . $sales_order_id . '/comments?organization_id=' . $organization_id;

        $client = new Client();

        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $token->access_token,
        ];

        try {
            $response = $client->request('GET', $apiURL, [
                'headers' => $headers,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);

            return [
                'code' => $statusCode,
                'response' => $responseBody,
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

}
