<?php

namespace App\Services;

class FonnteService
{
    private $token;
    private $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = 'KQ1XKbd2ZHue4cn9e7hc';
    }

    /**
     * Convert phone number from 08xxx to 62xxx format
     *
     * @param string $phone Phone number
     * @return string Formatted phone number
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any spaces, dashes, or special characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Convert 08xxx to 62xxx
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }
        
        // If doesn't start with 62, add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }

    /**
     * Send WhatsApp message via Fonnte API
     *
     * @param string $target Phone number (e.g., 08123456789)
     * @param string $message Message content
     * @param string $countryCode Country code (default: 62 for Indonesia)
     * @return array Response from Fonnte API
     */
    public function sendMessage($target, $message, $countryCode = '62')
    {
        // Format phone number (convert 08xxx to 62xxx)
        $target = $this->formatPhoneNumber($target);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
                'countryCode' => $countryCode,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $this->token
            ),
        ));

        $response = curl_exec($curl);
        $error = null;

        if (curl_errno($curl)) {
            $error = curl_error($curl);
        }

        curl_close($curl);

        if ($error) {
            return [
                'status' => 'error',
                'message' => $error
            ];
        }

        return json_decode($response, true);
    }

    /**
     * Send verification token to phone number
     *
     * @param string $phone Phone number
     * @param string $token Verification token
     * @param string $nama Nama calon siswa
     * @return array Response from Fonnte API
     */
    public function sendVerificationToken($phone, $token, $nama)
    {
        $message = "*SPMB SMK Bakti Nusantara 666*\n\n";
        $message .= "Halo *{$nama}*,\n\n";
        $message .= "Terima kasih telah mendaftar! 🎓\n\n";
        $message .= "Kode verifikasi Anda adalah:\n";
        $message .= "*{$token}*\n\n";
        $message .= "Masukkan kode ini untuk menyelesaikan pendaftaran.\n";
        $message .= "Kode berlaku selama 10 menit.\n\n";
        $message .= "_Jangan bagikan kode ini kepada siapapun!_";

        return $this->sendMessage($phone, $message);
    }
}
