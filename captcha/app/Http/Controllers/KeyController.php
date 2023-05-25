<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Support\Facades\DB;

class KeyController {
    public function updateKey() {
        $active_key = $this->getActiveKey();

        if (!$active_key) {
            $this->insertNewActiveKeyWithId(0);
            return;
        }

        $new_key_id = ($active_key->id + 1 < 20) ? $active_key->id + 1 : 0;

        $oldest_key = Key::where('id', $new_key_id)->first();
        if ($oldest_key) 
            $oldest_key->delete();
            
        $this->disableActiveKey($active_key);
        $this->insertNewActiveKeyWithId($new_key_id);
    }

    private function getActiveKey() {
        $active_key = Key::where('active', true)->first();
        return ($active_key) ? $active_key : null;
    }

    private function disableActiveKey (Key $active_key) {
        $active_key->active = false;
        $active_key->save();
    }

    private function insertNewActiveKeyWithId(int $new_key_id) {
        DB::table('keys')->insert([
            'id' => $new_key_id,
            'key' => $this->generateRandomKey(),
            'active' => 1,
        ]);
    }

    private function generateRandomKey() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 256; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}