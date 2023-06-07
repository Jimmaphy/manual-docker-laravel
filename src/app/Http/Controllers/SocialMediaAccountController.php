<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaAccount;
use Illuminate\Support\Facades\Redirect;

/**
 * Class SocialMediaAccountController
 * Control the social media accounts of the user
 */
class SocialMediaAccountController extends Controller
{
    /**
     * Update the social media accounts of the user
     * This will be called when the user submits the form on the profile page
     */
    public function update() 
    {
        // Get the data from the request and get the accounts
        $data = request()->all();
        $user = auth()->user();

        // Create an dictionary of the accounts given
        $givenAccounts = array(
            'GitHub' => $data['github'],
        );

        // Perform the right action for the given accounts
        foreach($givenAccounts as $media => $account) {
            $this->createAccountIfNotExists($user, $media, $account);
            $this->updateAccountWhenPresent($user, $media, $account);
            $this->deleteAccountWhenEmpty($user, $media, $account);
        }

        // Redirect back to the profile page
        return Redirect::route('profile.edit')->with('status', 'socials-updated');
    }

    /**
     * Check if an account exists for the given user and media
     *
     * @param $user The user to check
     * @param $media The media to check
     */
    private function accountExists($user, $media)
    {
        // Get the account and return whether it exists
        $account = $user->socials->where('social_media', $media)->first();
        return isset($account);
    }

    /**
     * Create an account for a user if it does not exist yet
     * 
     * @param $user The user to create the account for
     * @param $media The media to create the account for
     * @param $account The account to register
     */
    private function createAccountIfNotExists($user, $media, $account) 
    {
        // Check whether the account does not exist and the provided account is not empty
        if (!$this->accountExists($user->socials, $media) && $account) {
            // Create the account
            SocialMediaAccount::create([
                'user_id' => $user->id,
                'social_media' => $media,
                'username' => $account,
            ]);
        }
    }

    /**
     * Update an account for a user if it exists
     * 
     * @param $user The user to update the account for
     * @param $media The media to update the account for
     * @param $account The account to update to
     */
    private function updateAccountWhenPresent($user, $media, $account) 
    {
        // Check whether the account exists and the provided account is not empty
        if ($this->accountExists($user->socials, $media) && $account) {
            // Check whether the account is different from the provided account
            if ($user->socials->where('social_media', $media)->first()->username != $account) {
                // Update the account
                $user->socials->where('social_media', $media)->update([
                    'username' => $account,
                ]);
            }
        }
    }

    /**
     * Delete an account for a user if it exists and the account is empty
     * 
     * @param $user The user to delete the account for
     * @param $media The media to delete the account for
     * @param $account The string to check whether it is empty
     */
    private function deleteAccountWhenEmpty($user, $media, $account) 
    {
        // Check whether the account exists and the provided account is empty
        if ($this->accountExists($user->socials, $media) && !$account) {
            // Delete the account
            $user->socials->where('social_media', $media)->delete();
        }
    }
}
