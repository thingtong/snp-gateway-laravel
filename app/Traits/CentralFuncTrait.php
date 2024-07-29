<?php

namespace App\Traits;
use DateTime;
use App\Models\Constant;
use Illuminate\Support\Facades\Http;
trait CentralFuncTrait

{
    private function secured_encrypt($data)
    {
        // $first_key = base64_decode('+mUmi+RIn0nuHc8iuXEom+h6UxuAtsxnM+h0nW9lLLU=');
        // $second_key = base64_decode('rhvfMLNpIbSwqD4FmSwUz3LKuUQbRlOV0iA0no2JBYnXZY4L7K+ZYaxNDGz62jufdR8TgHEsUH05561Ug69n6A==');
        $first_key = base64_decode(env('FIRST_KEY'));
        $second_key = base64_decode(env('SECOND_KEY'));
       
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $first_encrypted = openssl_encrypt($data, $method, $first_key, OPENSSL_RAW_DATA, $iv);
        $second_encrypted = hash_hmac('sha3-512', $first_encrypted, $second_key, true);

        $output = base64_encode($iv . $second_encrypted . $first_encrypted);
       
        return $output;
    }

    private function secured_decrypt($input)
    {
        if (!empty($input)) {
            $first_key = base64_decode(env('FIRST_KEY'));
            $second_key = base64_decode(env('SECOND_KEY'));
            $mix = base64_decode($input);

            $method = "aes-256-cbc";
            $iv_length = openssl_cipher_iv_length($method);

            $iv = substr($mix, 0, $iv_length);
            $second_encrypted = substr($mix, $iv_length, 64);
            $first_encrypted = substr($mix, $iv_length + 64);

            $data = openssl_decrypt($first_encrypted, $method, $first_key, OPENSSL_RAW_DATA, $iv);
            $second_encrypted_new = hash_hmac('sha3-512', $first_encrypted, $second_key, true);

            if (hash_equals($second_encrypted, $second_encrypted_new)) {
                return $data;
            }
        }
        return $input;
    }
    
    private function validateNumericFields($data, $numericFields, $prefix = '')
    {
        $isValid = true;
        $messages = [];

        foreach ($numericFields as $field) {
            if (isset($data[$field])) {
                // ตรวจสอบว่าเป็นตัวเลขทั้งหมดหรือไม่
                if (!is_numeric($data[$field])) {
                    $isValid = false;
                    $messages[$prefix ? $prefix . '.' . $field : $field] = ucfirst($field) . ' must be numeric.';
                } else {
                    // ตรวจสอบว่าเป็นจำนวนเต็มหรือทศนิยม (ยกเว้นถ้าค่าเป็น "0")
                    if ($data[$field] !== "0" && $data[$field] !== 0 && !filter_var($data[$field], FILTER_VALIDATE_FLOAT) && !filter_var($data[$field], FILTER_VALIDATE_INT)) {
                        $isValid = false;
                        $messages[$prefix ? $prefix . '.' . $field : $field] = ucfirst($field) . ' must be a valid number format (integer or decimal).';
                    }
                }
            }
        }

        return [
            'isValid' => $isValid,
            'messages' => $messages,
        ];
    }

    private function validateDateTimeFields($data, $dateTimeFields, $prefix = '')
    {
        $isValid = true;
        $messages = [];

        foreach ($dateTimeFields as $field) {
            if (isset($data[$field])) {
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $data[$field]);
                if (!$dateTime || $dateTime->format('Y-m-d H:i:s') !== $data[$field]) {
                    $isValid = false;
                    $fullFieldName = !empty($prefix) ? $prefix . '.' . $field : $field;
                    $messages[$fullFieldName] = ucfirst($field) . ' must be in the format YYYY-MM-DD HH:MM:SS.';
                }
            }
        }

        return [
            'isValid' => $isValid,
            'messages' => $messages,
        ];
    }

    private function validateFields($data, $requiredFields, $prefix = '')
    {
        $isValid = true;
        $messages = [];
    
        foreach ($requiredFields as $field) {
            // ตรวจสอบฟิลด์ที่ต้องการ
            $fullFieldName = !empty($prefix) ? $prefix . '.' . $field : $field;
    
            if (!isset($data[$field])) {
                $isValid = false;
                $messages[$fullFieldName] = ucfirst($field) . ' is required.';
            
            } elseif ($data[$field] === null || (empty($data[$field]) && $data[$field] !== "0" && $data[$field] !== 0)) {
                $isValid = false;
                $messages[$fullFieldName] = ucfirst($field) . ' must not be empty.';
            
            }
        }
    
        return [
            'isValid' => $isValid,
            'messages' => $messages,
        ];
    }

    private function validateLimit1($data, $requiredFields, $prefix = '')
    {
        $isValid = true;
        $messages = [];

        foreach ($requiredFields as $field) {
            // ตรวจสอบฟิลด์ที่ต้องการ
            $fullFieldName = !empty($prefix) ? $prefix . '.' . $field : $field;

            if (isset($data[$field]) && strlen($data[$field]) > 1) {
                $isValid = false;
                $messages[$fullFieldName] = ucfirst($field) . ' must contain only 1 character.';
            }
        }

        return [
            'isValid' => $isValid,
            'messages' => $messages,
        ];
    }

    public function searchMemberPhone($phoneNumber)
    {
        // Assuming the endpoint is available and returns a JSON response
        $response = Http::get(route('mudjai.mudjaimemberphone', ['phonenumber' => $phoneNumber]));

        if ($response->successful()) {
            return $response->json();
        } else {
            // Handle the error
            return [
                'error' => 'Failed to fetch data from Mudjai API',
                'messages' => $response->body(),
            ];
        }


    }
}
