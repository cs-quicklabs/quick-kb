<?php

namespace App\Repositories;

use App\Models\Theme;
use App\Models\KnowledgeBase;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingRepository
{
    
    /**
     * Update account settings including the knowledge base name and theme data.
     *
     * @param array $data Associative array containing 'knowledge_base_name', 'theme_color', and 'theme_spacing'.
     * @param int $userId The ID of the user whose settings are to be updated.
     * @return bool True on successful update.
     * @throws \Exception If the knowledge base is not found or the update fails.
     */

    public function updateAccountSettings(array $data, int $userId)
    {
        
        try {
            $knowledgeBase = KnowledgeBase::where('user_id', $userId)->first();
            if(!$knowledgeBase){
                throw new \Exception(config("response_messages.knowledge_base_not_found"));
            }
            
            DB::beginTransaction();
            if (isset($data['knowledge_base_name'])) {
                $knowledgeBase->update(['knowledge_base_name' => $data['knowledge_base_name']]);
            }

            $themeData = [
                'color' => $data['theme_color'],
                'theme_spacing' => $data['theme_spacing'],
                'theme_type' => 'default'
            ];
            
            Theme::updateOrCreate(
                ['knowledge_base_id' => $knowledgeBase->id],
                [
                    'name' => 'default',
                    'theme_type' => 'default',
                    'theme' => $themeData
                ]
            );

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Retrieve the settings for the currently authenticated user.
     *
     * @return array an array containing user settings, knowledge base, and theme data.
     */

    public function settings()
    {   
        $userSettings = getLoggedInUser();
        return $userSettings;
    }
} 