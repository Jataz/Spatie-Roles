<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use LdapRecord\Models\Model;
use Spatie\Permission\Traits\HasRoles;
namespace App\Models;

use LdapRecord\Models\ActiveDirectory\User as BaseLdapUser;
use LdapRecord\Auth\BindException;

class LdapUser extends BaseLdapUser
{
    /**
     * Authenticate a user against Active Directory.
     *
     * @param string $username
     * @param string $password
     * @return self|null
     * @throws BindException
     */
    public static function authenticate($username, $password)
    {
        // Fetch the user from Active Directory
        $ldapUser = self::where('samaccountname', $username)->first();
    
        if ($ldapUser) {
            // Retrieve the userAccountControl attribute (ensure it's an integer)
            $userAccountControl = (int) $ldapUser->getFirstAttribute('userAccountControl');
    
            // Check if the account is disabled (flag 2)
            if ($userAccountControl & 2) {
                // Account is disabled
                return null;
            }
    
            // If the account is active, attempt authentication
            if ($ldapUser->getConnection()->auth()->attempt($ldapUser->getDn(), $password)) {
                return $ldapUser; // Successful login for active user
            }
        }
    
        return null; // Authentication failed or account is inactive
    }
    

    /**
     * Fetch user details after successful authentication.
     *
     * @return array
     */
    public function getUserDetails()
    {
        return [
            'username' => $this->getFirstAttribute('samaccountname'),
            'full_name' => $this->getFirstAttribute('cn'),
        ];
    }
}
