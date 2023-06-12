<?php

namespace App\Http\Business;

use App\Models\Key;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KeyManager {

    public static function updateKey() : void {
        $active_key_number = KeyManager::getActiveKeyNumber();

        if ($active_key_number == -1) 
            self::insertNewActiveKeyWithId(0);

        else {

            $new_key_id = $active_key_number + 1 % 20;

            $oldest_key = Key::where('id', $new_key_id)->first();
            if ($oldest_key) 
                $oldest_key->delete();
                
            DB::table('keys')->where('id', $active_key_number)->update(['active' => 0]);
            self::insertNewActiveKeyWithId($new_key_id);
        }
    }

    private static function insertNewActiveKeyWithId(int $key_number) : void {
        DB::table('keys')->insert([
            'id' => $key_number,
            'key' => Crypt::generateKey('AES-256-CBC'),
            'active' => 1,
        ]);
    }

    public static function getKey(int $key_number) : string {
        return Key::where('id', $key_number)->first()->key;
    }

    public static function getActiveKeyNumber() : int {
        $key = Key::where('active', true)->first();
        return ($key == null) ? -1 : $key->id;
    }
}