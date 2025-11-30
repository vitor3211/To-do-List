<?php
    class Crypto{
        private $key;

        public function __construct($key){
            $this->key = $key;
        }

        public function xorEncrypt($data, $key){
            $output = '';
            for($i=0, $keylen = strlen($key); $i<strlen($data); $i++){
                $output .= $data[$i] ^ $key[$i % $keylen];
            }
            return $output;
        }

        public function encrypt($plaintext){
            $ciphertext = $this->xorEncrypt($plaintext, $this->key);
            return base64_encode($ciphertext);
        }

        public function decrypt($ciphertext){
            $ciphertext = base64_decode($ciphertext);
            return $this->xorEncrypt($ciphertext, $this->key);
        }

    }
?>