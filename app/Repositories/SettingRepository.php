<?php

namespace App\Repositories;

use App\Models\Theme;
use App\Models\KnowledgeBase;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

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

            // Store in cookies
            Cookie::queue('themeData', json_encode($themeData), 60 * 24 * 30);

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


    /**
     * Manage the database by exporting it as a SQLite file.
     *
     * @return array An associative array with keys 'status' and 'message'.
     */
    public function exportDatabase() {
        try {
            $sqlitePath = config('database.connections.sqlite.database');
            $sqlitePath = database_path(basename($sqlitePath));
            $exportPath = storage_path('app/public/exports');
            $exportFileName = 'database.sqlite';
            $exportFilePath = $exportPath . '/' . $exportFileName;
            $resp = [];
            if (!file_exists($sqlitePath)) {
                $resp['status'] = false;
                $resp['message'] = config('response_messages.database_not_found');
                return $resp;
            }
            if (!file_exists($exportPath)) {
                mkdir($exportPath, 0777, true);
            }
            copy($sqlitePath, $exportFilePath);

            $path = asset('storage/exports/' . $exportFileName);

            $resp['path'] = $path;
            return $resp;
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }


    public function importDatabase($params)  {
        try {
            $file = $params['database_file'];
            $filePath = $file->storeAs('imports', 'database.sqlite', 'public');
            //$importPath = storage_path('app/'.$filePath);

            $tempDBPath = storage_path('app/public/' . $filePath);
           

            config([
                'database.connections.temp_sqlite' => [
                    'driver' => 'sqlite',
                    'database' => $tempDBPath,
                    'prefix' => '',
                ],
            ]);

            $tables = DB::connection('temp_sqlite')
                    ->select("SELECT name FROM sqlite_master WHERE type='table';");

            $tableNames = collect($tables)->pluck('name')->toArray();
            
            $requiredTables = ['users', 'knowledge_bases', 'themes', 'workspaces', 'modules', 'articles', 'article_ratings']; 

            $missingTables = array_diff($requiredTables, $tableNames);
            if ($missingTables) {
                unlink($tempDBPath);
                throw new \Exception(config('response_messages.missing_tables'));
            }

            $destinationPath = database_path('database.sqlite'); 

            if (file_exists($destinationPath)) {
                unlink($destinationPath); 
            }

            copy($tempDBPath, $destinationPath); 

            chmod($destinationPath, 0777);

            // (optional) Clean up temp file
            unlink($tempDBPath);

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
} 