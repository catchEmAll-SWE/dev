<?php

namespace App\Http\Business;

use App\Models\Key;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KeyManager {

    public function updateKey() {
        $active_key = KeyManager::getActiveKey();

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

    private static function getActiveKey() : Key {
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
            'key' => Crypt::generateKey('AES-256-CBC'),
            'active' => 1,
        ]);
    }

    public static function getActiveKeyValue() : string {
        return KeyManager::getActiveKey()->key;
    }

    public static function getKeyNumber() : int {
        return KeyManager::getActiveKey()->id;
    }

    public static function getKeyValue(int $key_number) : string {
        return Key::where('id', $key_number)->first()->key;
    }
}