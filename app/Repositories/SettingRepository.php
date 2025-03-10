<?php

namespace App\Repositories;

use App\Models\Theme;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingRepository
{
    public function updateAccountSettings(array $data, int $userId)
    {
        DB::beginTransaction();
        try {
            // Get knowledge base id for the user
            $knowledgeBase = KnowledgeBase::where('user_id', $userId)->first();
            
            // Update knowledge base name
            if (isset($data['knowledge_base_name'])) {
                $knowledgeBase->update(['knowledge_base_name' => $data['knowledge_base_name']]);
            }

            // Prepare theme data
            $themeData = [
                'color' => $data['theme_color'],
                'theme_spacing' => $data['theme_spacing'],
                'theme_type' => 'default'
            ];
            $themeData = json_encode($themeData);
            
            // Update or create theme based on knowledge_base_id
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
            throw new \Exception('Failed to update settings: ' . $e->getMessage());
        }
    }

    public function settings()
    {   
        $userSettings = getLoggedInUser();
        return $userSettings;
    }
} 